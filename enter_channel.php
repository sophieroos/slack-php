<?php

/**
 * @param $line
 * @param $client
 */
function enter_channel($line, $client)
{
    $channelId = array_search($line, $_ENV['channels-lower-case'], false);
    $parameters = [$channelId];
    $last_messages = new GetLastMessages($parameters);

    $last_messages = $last_messages->execute($client);

    foreach ($last_messages as $message) {
        echo $message, PHP_EOL;
    }
    echo $_ENV['current_user']->createStyledString();

    $_SESSION['entered_channel'] = $channelId;
}

function exit_channel()
{
    $_SESSION['entered_channel'] = false;
    echo 'Exited' . PHP_EOL;
}

/**
 * @param $message
 * @param $channelId
 * @param $client
 */
function send_message($message, $channelId, $client)
{
    $sendMessage = new SendMessage();
    $sendMessage->withChannel($channelId)->withMessage(new Message($message));

    $sendMessage->execute($client);

    echo $_ENV['current_user']->createStyledString();
}