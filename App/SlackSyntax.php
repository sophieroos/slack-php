<?php


class SlackSyntax
{
    const AS = '|';

    const AT_CHANNEL = '<!';
    const AT_USER = '<@';

    const EMOJI = ':';
    const LINK = '<';

    const BOLD = '*';
    const ITALIC = '_';
    const CODE = '`';
    const QUOTE = '&gt;';

    const CHANNEL_REFERENCE = '<#';

    const SUB_TEAM = '<!subteam^';

    const AMPERSAND = '&amp;';

    /**
     * @param string $emojiName
     * @return string
     */
    public static function getEmoji(string $emojiName): string
    {
        $emojis = require DIR_BASE . 'Cache/emojis.php';

        foreach ($emojis as $emoji) {
            if (stripos($emoji['name'], $emojiName) !== false) {
                return $emoji['emoji'];
            }
        }
        return '❌';
    }

    /**
     * @param string $link
     * @return string
     */
    public static function getLink(string $link): string
    {
        return $link;
    }
}