<?php

/**
 * @param string $line
 * @param GuzzleClient $client
 */
function enter_channel(string $line, GuzzleClient $client)
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
 * @param string $message
 * @param string $channelId
 * @param GuzzleClient $client
 */
function send_message(string $message, string $channelId, GuzzleClient $client)
{
    $sendMessage = new SendMessage();
    $sendMessage->withChannel($channelId)->withMessage(new Message($message));

    $sendMessage->execute($client);

    echo $_ENV['current_user']->createStyledString();
}
