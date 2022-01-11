<?php

if (!function_exists('debugVar')) {
    /**
     * Print value of a variable in <pre> tag
     * @param  mix $var variable to be printed
     */
    function debugVar($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
