<?php

/**
 * Class Channel
 */
class Channel
{
    const TYPE_PUBLIC_CHANNEL = 'public_channel';

    const TYPE_PRIVATE_CHANNEL = 'private_channel';

    const TYPE_PRIVATE_DIRECT = 'im';

    const TYPE_PRIVATE_GROUP = 'mpim';

    const TYPE_DIRECT_MESSAGE_YOU = 'direct message to yourself';

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
    private $type;

    /**
     * @var array
     */
    private $members = [];

    /**
     * Channel constructor.
     * @param string $id
     * @param string $name
     * @param string $type
     */
    public function __construct(string $id, string $name, string $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->cleanUpName($this->name);
    }

    /**
     * @return array
     */
    public function members(): array
    {
        return $this->members;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param User $user
     */
    public function addMember(User $user)
    {
        $this->members[] = $user;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s: %s', $this->id, $this->name());
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function cleanUpName(string $name)
    {
        if ($this->type === self::TYPE_PRIVATE_DIRECT || $this->type === self::TYPE_DIRECT_MESSAGE_YOU) {
            return $this->members[0];
        }

        if ($this->type === self::TYPE_PRIVATE_CHANNEL) {
            return implode('-', $this->members);
        }

        return str_replace(['--', 'mpdm-', '-1'], [' ', '', ''], $name);
    }
}
