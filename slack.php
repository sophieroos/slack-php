<?php

include 'app.php';

$client = new GuzzleClient();
setup($client);

while (true) {
    $line = trim(readline());

    if (strlen($line) > 0) {
        if (strpos($line, ':')) {
            run_task($line, $client);
            continue;
        }
        if (in_array(strtolower($line), $_ENV['channels-lower-case'], false)) {
            enter_channel($line, $client);
            continue;
        }
        if ($_SESSION['entered_channel'] !== false) {
            if (stripos($line, 'exit') !== false) {
                exit_channel();
                continue;
            }
            send_message($line, $_SESSION['entered_channel'], $client);
            continue;
        }
        echo "Function doesn't exist";
    } else {
        echo 'Mention a function';
    }
    echo PHP_EOL;
}

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
 * @param $line
 * @param $client
 */
function run_task($line, $client)
{
    $line = str_replace(':', ' ', $line);
    $array = explode(' ', $line);
    $task = str_replace('-', '', $array[0]);


    if (class_exists($task)) {
        /**
         * @var $task Task
         */
        $task = new $task(array_slice($array, 1));
        $results = $task->execute($client);

        if (is_array($results)) {
            foreach ($results as $result) {
                echo $result, PHP_EOL;
            }
            return;
        }
        echo $results;
    }
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
