<?php

/**
 * Class GetUsersInConversation
 */
class GetUsersInConversation
{
    /**
     * @var Channel
     */
    private $channel;

    /**
     * GetConversationIds constructor.
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param GuzzleClient $client
     * @return array
     */
    public function execute(GuzzleClient $client): array
    {
        $params = [
            'channel' => $this->channel->id()
        ];
        $response = $client->sendPostRequest(SlackMethods::CONVERSATIONS_MEMBERS, $params);

        return $response['members'];
    }
}