<?php

/**
 * @param $line
 * @param $client
 */
function enter_channel($line, $client)
{
    $channelId = array_search($line, $_ENV['channels-lower-case'], false);

    echo 'Entered channel ', $_ENV['channels'][$channelId], PHP_EOL;

    $parameters = [$channelId];
    $last_messages = new GetLastMessages($parameters);

    $last_messages = $last_messages->execute($client);

    foreach ($last_messages as $message) {
        echo $message, PHP_EOL;
    }

    while ($message !== false) {
        echo $_ENV['current_user']->createStyledString();

        $message = read_message();
        $sendMessage = new SendMessage([$channelId, $message]);
        $sendMessage->execute($client);
    }
}

/**
 * @return string
 */
function read_message()
{
    $line = trim(readline());
    if ($line == '') {
        echo 'Closed channel', PHP_EOL;
        return false;
    }
    return $line;
}