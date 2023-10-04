<?php

function get_sitename()
{
    return 'Web Framework';
}

function to_object($array)
{
    return json_decode(json_encode($array));
}
