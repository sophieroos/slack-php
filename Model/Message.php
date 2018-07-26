<?php

/**
 * Class Message
 */
class Message
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $text;

    /**
     * @param string $message
     * @param User $user
     */
    public function __construct(string $message, User $user)
    {
        $this->text = $message;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s%s', $this->user->createStyledString(), $this->createStyledString($this->text));
    }

    /**
     * @param string $text
     * @return string
     */
    private function createStyledString(string $text): string
    {
        $message_spaced_length = $_ENV['width_of_screen'] - User::USERNAME_SPACED_LENGTH;
        $new_line_30_spaces = PHP_EOL . str_repeat(' ', User::USERNAME_SPACED_LENGTH);

        $lines = explode("\n", $text);
        $lines = array_filter($lines, function ($line) {
            return $line !== '' && $line !== "\r";
        });

        $text = '';
        foreach ($lines as $line) {
            while (strlen($line) > $message_spaced_length) {
                $try = substr($line, 0, $message_spaced_length);
                $space_pos = strrpos($try, ' ') + 1;
                if ($text !== '') {
                    $text .= $new_line_30_spaces;
                }
                $text .= substr($try, 0, $space_pos);
                $line = substr($line, $space_pos);
            }
            if ($text !== '') {
                $text .= $new_line_30_spaces;
            }
            $text .= $line;
        }
        return $text;
    }
}
