<?php

require 'vendor/autoload.php';

define('DIR_BASE', __DIR__ . DIRECTORY_SEPARATOR);

$format_base = DIR_BASE . '%s' . DIRECTORY_SEPARATOR;
define('DIR_APP', sprintf($format_base, 'App'));
define('DIR_TASK', sprintf($format_base, 'Task'));
define('DIR_MODEL', sprintf($format_base, 'Model'));
define('DIR_CACHE', sprintf($format_base, 'Cache'));

require DIR_BASE . 'GuzzleClient.php';
require DIR_BASE . '.env.php';
require DIR_BASE . 'emojis.php';
require DIR_BASE . 'setup.php';
require DIR_BASE . 'enter_channel.php';
require DIR_BASE . 'cache.php';

require DIR_TASK . 'Task.php';
require DIR_TASK . 'SendMessage.php';
require DIR_TASK . 'GetConversationIds.php';
require DIR_TASK . 'GetConversations.php';
require DIR_TASK . 'GetUsersInConversation.php';
require DIR_TASK . 'GetUserInfo.php';
require DIR_TASK . 'GetLastMessages.php';
require DIR_TASK . 'SendChatCommand.php';

require DIR_APP . 'SlackMethods.php';
require DIR_APP . 'Colors.php';
require DIR_APP . 'SlackSyntax.php';

require DIR_MODEL . 'Message.php';
require DIR_MODEL . 'User.php';
require DIR_MODEL . 'Channel.php';

define('CACHE_EMOJIS', DIR_CACHE . 'emojis.php');

require DIR_BASE . 'command_line.php';
