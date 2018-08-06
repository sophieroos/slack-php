<?php

/**
 * @param $client
 */
function cache_channels($client)
{
    if (!file_exists(CACHE_CHANNELS)) {

        $getConverstations = new GetConversations();
        $channels = $getConverstations->execute($client);

        file_put_contents(CACHE_CHANNELS, '<?php return ' . var_export($channels, true) . ';');
    }
}
