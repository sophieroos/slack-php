<?php

class SendChatCommand implements Task
{
    /**
     * @var string
     */
    private $command;

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
        $this->command = $parameters[1];

        $this->message = new Message(implode(' ', array_slice($parameters, 2)), $_ENV['current_user']);
    }

    /**
     * @param GuzzleClient $client
     * @return Message
     */
    public function execute(GuzzleClient $client): \Message
    {
        $params = [
            'channel' => $this->channel,
            'command' => '/' . $this->command,
            'text' => $this->message->text(),
        ];

        $client->sendPostRequest(SlackMethods::CHAT_COMMAND, $params);

        return $this->message;
    }
}