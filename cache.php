<?php

/**
 * @param $client
 */
function cache($client)
{
    if (!file_exists(DIR_CACHE) || !is_dir(DIR_CACHE)) {
        mkdir(DIR_BASE . 'Cache');
    }

    cache_emojis();
    cache_channels($client);
}
