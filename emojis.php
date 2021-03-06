<?php

/**
 * @param GuzzleClient $client
 */
function cache_emojis(GuzzleClient $client)
{
    if (!file_exists(CACHE_EMOJIS)) {
        $emojis = array_merge(get_emojis_from_unicode(), get_emojis_from_slack($client));
        file_put_contents(CACHE_EMOJIS, '<?php return ' . var_export($emojis, true) . ';');
    }
}

/**
 * @param GuzzleClient $client
 * @return array
 */
function get_emojis_from_slack($client): array
{
    $results = $client->sendPostRequest(SlackMethods::EMOJI_LIST)['emoji'];

    $emojis = [];
    foreach ($results as $name => $picture) {
        $emoji = [];
        $emoji['code points'] = [];
        $emoji['emoji'] = $picture;
        $emoji['name'] = $name;

        $emojis[] = $emoji;
    }

    return $emojis;
}

/**
 * @return array
 */
function get_emojis_from_unicode(): array
{
    $file = file('https://unicode.org/Public/emoji/11.0/emoji-test.txt');

    $file = array_filter($file, function ($value) {
        if (strpos($value, 'qualified') === false) {
            return false;
        }
        if (strpos($value, '#') === 0) {
            return false;
        }
        return true;
    });

    $emojis = [];
    foreach ($file as $line) {
        $emoji = [];

        $semicolon_pos = strpos($line, ';');
        $unicodes = trim(substr($line, 0, $semicolon_pos));
        $emoji['code points'] = explode(' ', $unicodes);

        $hash_pos = strpos($line, '#');
        $emoji_and_name = trim(substr($line, $hash_pos + 1));

        $white_space_pos = strpos($emoji_and_name, ' ');
        $emoji['emoji'] = substr($emoji_and_name, 0, $white_space_pos);
        $emoji['name'] = substr($emoji_and_name, $white_space_pos + 1);

        $emojis[] = $emoji;
    }
    return $emojis;
}
