<?php

/**
 * @param GuzzleClient $client
 */
function setup(GuzzleClient $client)
{
    $_ENV['users'] = [];
    $_ENV['channels'] = [];

    $currrent_user = new User($_ENV['current_user_id']);

    $getUserInfo = new GetUserInfo($currrent_user);
    $currrent_user = $getUserInfo->execute($client);
    $_ENV['current_user'] = $currrent_user;

    $getConverstations = new GetConversations();
    $getConverstations->execute($client);

    $_SESSION['entered_channel'] = false;

    echo 'Done', PHP_EOL;
}
