<?php

/**
 * Class Channel
 */
class Channel
{
    const TYPE_PUBLIC_CHANNEL = 'public_channel';

    CONST TYPE_PRIVATE_CHANNEL = 'private_channel';

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

    public static function createFromApi(
        $id,
        $name,
        $type
    ) {
        return new self($id, $name, $type);
    }

    /**
     * Channel constructor.
     * @param $id
     * @param $name
     * @param $type
     */
    public function __construct($id, $name, $type)
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
    public function getShortChannelName()
    {
        return str_replace(' ', '', $this->name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s: %s', $this->id, $this->name());
    }

    public static function __set_state($array)
    {
        $id = $array['id'];
        $name = $array['name'];
        $type = $array['type'];
        $self = new self($id, $name, $type);
        $self->members = $array['members'];
        return $self;
    }

    /**
     * @param $name
     * @return mixed
     */
    private function cleanUpName($name)
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
