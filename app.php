<?php

require 'vendor/autoload.php';

define('DS', DIRECTORY_SEPARATOR);
define('DIR_BASE', __DIR__ . DS);
define('DIR_APP', DIR_BASE . 'App' . DS);
define('DIR_TASK', DIR_BASE . 'Task' . DS);
define('DIR_MODEL', DIR_BASE . 'Model' . DS);
define('DIR_CACHE', DIR_BASE . 'Cache' . DS);

define('CACHE_EMOJIS', DIR_CACHE . 'emojis.php');
define('CACHE_CHANNELS', DIR_CACHE . 'channels.php');

include DIR_BASE . 'GuzzleClient.php';
include DIR_BASE . '.env.php';
include DIR_BASE . 'emojis.php';
include DIR_BASE . 'setup.php';
include DIR_BASE . 'channels.php';
include DIR_BASE . 'cache.php';
include DIR_BASE . 'auto_complete.php';

include DIR_TASK . 'Task.php';
include DIR_TASK . 'SendMessage.php';
include DIR_TASK . 'GetConversationIds.php';
include DIR_TASK . 'GetConversations.php';
include DIR_TASK . 'GetUsersInConversation.php';
include DIR_TASK . 'GetUserInfo.php';
include DIR_TASK . 'GetLastMessages.php';
include DIR_TASK . 'SendChatCommand.php';

include DIR_APP . 'SlackMethods.php';
include DIR_APP . 'Colors.php';
include DIR_APP . 'SlackSyntax.php';

include DIR_MODEL . 'Message.php';
include DIR_MODEL . 'User.php';
include DIR_MODEL . 'Channel.php';
include DIR_MODEL . 'Channels.php';

include DIR_BASE . 'command_line.php';

