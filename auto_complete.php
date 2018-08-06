<?php

function get_auto_complete_options()
{
    $options = [
        'SendChatCommand:me:dnd',
        GetConversations::class,
    ];

    $channels = require CACHE_CHANNELS;
    foreach ($channels as $channel) {
        /**
         * @var $channel Channel
         */
        $name = $channel->getShortChannelName();
        $options[] = $name;
        $options[] = 'sendMessage' . $name;
    }

    return $options;
}
