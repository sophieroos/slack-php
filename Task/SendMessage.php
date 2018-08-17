<?php

/**
 * Class SendMessage
 */
class SendMessage implements Task
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @var string
     */
    private $channelId;

    /**
     * SendMessage constructor.
     * @param $parameters
     */
    public function __construct(array $parameters = [])
    {
        if (count($parameters) >= 2) {
            $this->channelId = array_search(strtolower($parameters[0]), $_ENV['channels-lower-case'], false);

            $this->message = new Message(implode(' ', array_slice($parameters, 1)), $_ENV['current_user']);
        }
    }

    /**
     * @param GuzzleClient $client
     * @return Message
     */
    public function execute(GuzzleClient $client): \Message
    {
        $params = [
            'channel' => $this->channelId,
//            'channel' => 'DA3TFDKLK',
            'text' => $this->message->text(),
        ];

        $client->sendPostRequest(SlackMethods::CHAT_POST_MESSAGE, $params);

        return $this->message;
    }

    /**
     * @param string $channelId
     * @return $this
     */
    public function withChannel(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * @param Message $message
     * @return $this
     */
    public function withMessage(Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}
