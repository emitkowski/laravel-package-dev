<?php

/*
 * Debug echo function
 */
function er($input, $die = 0)
{
    echo($input . '<br />');

    if ($die) {
        die();
    }
}

/*
 * Debug print function
 */
function pr($input, $die = 0)
{
    echo '<pre>';
    print_r($input);
    echo '</pre>';

    if ($die) {
        die();
    }
}

/*
 * XDebug var_dump function
 */
function xr($input, $die = 0)
{
    xdebug_var_dump($input);

    if ($die) {
        die();
    }
}
