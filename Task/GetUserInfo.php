<?php

/**
 * Class GetUserInfo
 */
class GetUserInfo
{
    /**
     * @var User
     */
    private $user;

    /**
     * GetUserInfo constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param GuzzleClient $client
     * @return mixed
     */
    public function execute(GuzzleClient $client)
    {
        $type = 'user';
        if ($this->user->isBot()) {
            $type = 'bot';
        }
        if (!array_key_exists($this->user->id(), $_ENV['users'])) {
            $params = [
                $type => $this->user->id(),
            ];

            if ($type === 'bot') {
                $user = $client->sendPostRequest(SlackMethods::BOTS_INFO, $params)[$type];
                $real_name = $user['name'];
            } else {
                $user = $client->sendPostRequest(SlackMethods::USERS_INFO, $params)[$type];
                $real_name = $user['profile']['real_name'];
            }

            $this->user->setInfo($user['name'], $real_name);
            $_ENV['users'][$this->user->id()] = $this->user;
            return $this->user;
        }
        return $_ENV['users'][$this->user->id()];
    }
}
