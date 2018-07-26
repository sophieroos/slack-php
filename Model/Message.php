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
     * Message constructor.
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
        $space = str_repeat(' ', 29 - strlen($this->user));

        $user_colored = $this->user;
        if ($this->user === $_ENV['current_user']) {
            $user_colored = Colors::LIGHT_BLUE . $this->user . Colors::RESET;
        }

        return sprintf('%s:%s%s', $user_colored, $space, $this->createSpacedText($this->text));
    }

    /**
     * @param string $text
     * @return string
     */
    private function createSpacedText(string $text): string
    {
        $new_line_30_spaces = PHP_EOL . str_repeat(' ', 30);
        $lines = explode("\n", $text);
        $lines = array_filter($lines, function ($line) {
            return $line !== '' && $line !== "\r";
        });

        $text = '';
        foreach ($lines as $line) {
            while (strlen($line) > 180) {
                $try = substr($line, 0, 180);
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