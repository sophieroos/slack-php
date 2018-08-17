<?php

/**
 * @param GuzzleClient $client
 */
function cache(GuzzleClient $client)
{
    if (!file_exists(DIR_CACHE) || !is_dir(DIR_CACHE)) {
        mkdir(DIR_CACHE);
    }

    cache_emojis($client);
}