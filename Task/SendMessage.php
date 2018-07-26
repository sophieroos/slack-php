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
    private $channel;

    /**
     * SendMessage constructor.
     * @param $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->channel = array_search(strtolower($parameters[0]), $_ENV['channels-lower-case'], false);

        $this->message = new Message(implode(' ', array_slice($parameters, 1)), $_ENV['current_user']);
    }

    /**
     * @param GuzzleClient $client
     * @return Message
     */
    public function execute(GuzzleClient $client): \Message
    {
        $params = [
            'channel' => $this->channel,
            'text' => $this->message->text(),
        ];

        $client->sendPostRequest(SlackMethods::CHAT_POST_MESSAGE, $params);

        return $this->message;
    }
}