<?php


/**
 * Class GetLastMessages
 */
class GetLastMessages implements Task
{
    /**
     * @var string
     */
    private $channelId;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->channelId = $parameters[0];
    }

    /**
     * @param GuzzleClient $client
     * @return array
     */
    public function execute(GuzzleClient $client): array
    {
        $params = [
            'channel' => $this->channelId,
            'limit' => 10,
        ];

        $messages = $client->sendPostRequest(SlackMethods::CONVERSATIONS_HISTORY, $params)['messages'];

        return array_map(function ($message) use ($client) {
            $user = $this->getUserFromMessage($message);

            return new Message($this->getTextFromMessage($message), $this->getUserWithInfo($user, $client));
        }, array_reverse($messages));
    }

    /**
     * @param $message
     * @return string
     */
    private function getTextFromMessage($message): string
    {
        if (array_key_exists('subtype', $message)) {
            $subtype = $message['subtype'];

            if ($subtype === 'file_comment') {
                return $message['comment']['comment'];
            }

            if ($subtype === 'bot_message') {
                return $message['attachments'][0]['pretext'];
            }
        }

        return $message['text'];
    }

    /**
     * @param $message
     * @return User
     */
    private function getUserFromMessage($message): User
    {
        if (array_key_exists('subtype', $message)) {
            $subtype = $message['subtype'];

            if ($subtype === 'file_comment') {
                return new User($message['comment']['user']);
            }
            if ($subtype === 'bot_message') {
                $user = new User($message['bot_id']);
                $user->setBot();
                return $user;
            }
        }

        return new User($message['user']);
    }

    /**
     * @param $userId
     * @param $client
     * @return mixed
     */
    private function getUserWithInfo($userId, $client)
    {
        $getUserInfo = new GetUserInfo($userId);
        return $getUserInfo->execute($client);
    }

}
