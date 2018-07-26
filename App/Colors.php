<?php

class Colors
{
    const ANSI = "\e[";

    const BLACK = self::ANSI . '';
    const LIGHT_BLUE = self::ANSI . '1;34m';

    const RESET = self::ANSI . '0m';

}