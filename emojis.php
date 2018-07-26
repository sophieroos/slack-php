<?php

if (!file_exists(__DIR__ . '\Cache')) {
    mkdir(__DIR__ . '\Cache');
}

if (!file_exists(__DIR__ . '\Cache\emojis.php')) {
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

        $puntkomma_pos = strpos($line, ';');
        $unicodes = trim(substr($line, 0, $puntkomma_pos));
        $emoji['code points'] = explode(' ', $unicodes);

        $hekje_pos = strpos($line, '#');
        $emoji_and_name = trim(substr($line, $hekje_pos + 1));

        $white_space_pos = strpos($emoji_and_name, ' ');
        $emoji['emoji'] = substr($emoji_and_name, 0, $white_space_pos);
        $emoji['name'] = substr($emoji_and_name, $white_space_pos + 1);

        $emojis[] = $emoji;
    }

    file_put_contents(__DIR__ . '\Cache\emojis.php', '<?php return ' . var_export($emojis, true) . ';');
}