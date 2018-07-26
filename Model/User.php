<?php

/**
 * Class User
 */
class User
{
    const USERNAME_SPACED_LENGTH = 30;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $realName;

    /**
     * @var bool
     */
    private $bot = false;

    /**
     * User constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    public function setBot()
    {
        $this->bot = true;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->bot;
    }

    /**
     * @param string $name
     * @param string $realName
     */
    public function setInfo(string $name, string $realName)
    {
        $this->name = $name;
        $this->realName = $realName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->id === $_ENV['current_user']->id()) {
            return 'Me';
        }
        return $this->realName;
    }

    /**
     * @return string
     */
    public function createStyledString(): string
    {
        $space = str_repeat(' ', self::USERNAME_SPACED_LENGTH - strlen($this) - 1);

        $user_colored = $this;
        if ($this === $_ENV['current_user']) {
            $user_colored = Colors::LIGHT_BLUE . $this . Colors::RESET;
        }
        return sprintf('%s:%s', $user_colored, $space);
    }
}