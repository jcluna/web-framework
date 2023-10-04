<?php

function get_sitename()
{
    return 'Web Framework';
}

function now()
{
    return date('Y-m-d H:i:s');
}

function to_object($array)
{
    return json_decode(json_encode($array));
}
