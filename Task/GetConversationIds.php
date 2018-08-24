<?php

/**
 * Class GetConversationIds
 */
class GetConversationIds implements Task
{
    /**
     * GetConversationIds constructor.
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
        $params = [
            'types' => 'public_channel,private_channel,mpim,im'
        ];
        $response = $client->sendPostRequest(SlackMethods::USERS_CONVERSATIONS, $params);
        $channels = [];
        foreach ($response['channels'] as $channel) {
            $channels[] = new Channel(
                $channel['id'],
                $this->getName($channel),
                $this->getStatus($channel)
            );
        }
        return $channels;
    }

    /**
     * @param array $channel
     * @return string
     */
    private function getStatus(array $channel): string
    {
        if (array_key_exists('is_channel', $channel) && $channel['is_channel'] === true) {
            return Channel::TYPE_PUBLIC_CHANNEL;
        }
        if (array_key_exists('is_group', $channel) && $channel['is_group'] === true) {
            return Channel::TYPE_PRIVATE_CHANNEL;
        }
        if (array_key_exists('is_im', $channel) && $channel['is_im'] === true) {
            return Channel::TYPE_PRIVATE_DIRECT;
        }
        return Channel::TYPE_PRIVATE_GROUP;
    }

    /**
     * @param array $channel
     * @return string
     */
    private function getName(array $channel): string
    {
        if (array_key_exists('name', $channel)) {
            return $channel['name'];
        }
        return 'Direct message';
    }
}
