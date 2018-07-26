<?php

/**
 * Class GetConversationIds
 */
class GetConversations implements Task
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
    }

    /**
     * @param GuzzleClient $client
     * @return array
     */
    public function execute(GuzzleClient $client): array
    {
        $getConversations = new GetConversationIds();
        $channels = $getConversations->execute($client);

        foreach ($channels as $channel) {
            /** @var $channel Channel */

            $channelType = $channel->type();

            if ($channelType !== Channel::TYPE_PUBLIC_CHANNEL) {
                $users = $this->getUsersInChannel($channel, $client);

                foreach ($users as $key => $id) {
                    if ($channelType === Channel::TYPE_PRIVATE_DIRECT) {
                        if (count($users) === 1) {
                            $_ENV['current_user'] = $this->addMemberToChannel($users[0], $channel, $client);
                            $channel->setType(Channel::TYPE_DIRECT_MESSAGE_YOU);
                        }

                        if ($key !== 0) {
                            $this->addMemberToChannel($id, $channel, $client);
                        }
                    }

                    if ($channelType === Channel::TYPE_PRIVATE_CHANNEL) {
                        $this->addMemberToChannel($id, $channel, $client);
                    }
                }
            }
            $this->addChannelToAutocompleteOptions($channel);
        }

        return $channels;
    }

    /**
     * @param $id
     * @param Channel $channel
     * @param $client
     * @return User
     */
    private function addMemberToChannel($id, Channel $channel, $client): \User
    {
        $user = new User($id);
        $getUserInfo = new GetUserInfo($user);
        $user = $getUserInfo->execute($client);

        $channel->addMember($user);

        return $user;
    }

    /**
     * @param Channel $channel
     */
    private function addChannelToAutocompleteOptions(Channel $channel)
    {
        $channelName = str_replace(' ', '', $channel->name());
        $_ENV['channels'][$channel->id()] = $channelName;
        $_ENV['channels-lower-case'][$channel->id()] = strtolower($channelName);

        if ($channel->type() !== Channel::TYPE_DIRECT_MESSAGE_YOU) {
            $_ENV['autocomplete_options'][] = 'sendmessage:' . $channelName;
            $_ENV['autocomplete_options'][] = $channelName;
            return;
        }

        array_unshift($_ENV['autocomplete_options'], 'sendmessage:' . $channelName);
    }

    /**
     * @param Channel $channel
     * @param GuzzleClient $client
     * @return array
     */
    private function getUsersInChannel(Channel $channel, GuzzleClient $client): array
    {
        $getUsersInConversation = new GetUsersInConversation($channel);
        return $getUsersInConversation->execute($client);
    }
}