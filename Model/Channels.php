<?php

/**
 * Class Channel
 */
class Channels extends \ArrayIterator
{
    private $channels = [];

    public static function createFromApi(array $data)
    {
        return new self(
            array_map(function (array $channel) {
                return Channel::createFromApi(
                    $channel['id'],
                    self::getName($channel),
                    self::getStatus($channel)
                );
            }, $data)
        );
    }


    /**
     * @param array $channel
     * @return string
     */
    private static function getStatus(array $channel): string
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
     * @param $channel
     * @return string
     */
    private static function getName($channel): string
    {
        if (array_key_exists('name', $channel)) {
            return $channel['name'];
        }
        return 'Direct message';
    }

    private function __construct(array $channels)
    {
        $this->channels = $channels;
    }

    public function containsChannelWithName($name)
    {
        foreach ($this->channels as $channel) {
            /** @var Channel $channel */
            if ($name === $channel->getShortChannelName()) {
                return true;
            }
        }
        return false;
    }
}
