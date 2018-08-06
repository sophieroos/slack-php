<?php
/**
 * @param $string
 * @param $function
 * @return mixed
 */
function get_match($string, $function)
{
    if (stripos($function, $string) === 0) {
        return $function;
    }
}

/**
 * @param $string
 * @return array
 */
function get_autocomplete_matches($string)
{
    $matches = [];
    foreach (get_auto_complete_options() as $function) {
        $matches[] = get_match($string, strtolower($function)) . ' ';
    }
    return array_filter($matches);
}

/**
 * @return bool|string
 */
function get_command()
{
    $rl_info = readline_info();
    return substr($rl_info['line_buffer'], 0, $rl_info['point']);
}

readline_completion_function(function () {
    return get_autocomplete_matches(get_command());
});
