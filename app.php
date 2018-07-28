<?php

require 'vendor/autoload.php';

define('DIR_BASE', __DIR__ . '/');
define('DIR_APP', DIR_BASE . 'App/');
define('DIR_TASK', DIR_BASE . 'Task/');
define('DIR_MODEL', DIR_BASE . 'Model/');
define('DIR_CACHE', DIR_BASE . 'Cache/');

include DIR_BASE . 'GuzzleClient.php';
include DIR_BASE . '.env.php';
include DIR_BASE . 'emojis.php';
include DIR_BASE . 'setup.php';
include DIR_BASE . 'cache.php';

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

include DIR_BASE . 'command_line.php';
