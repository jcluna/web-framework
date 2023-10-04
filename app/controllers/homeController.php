<?php

class homeController
{
    function __construct()
    {
    }

    function index()
    {
        $data = [
            'title' => 'Home'
        ];

        View::render('web', $data);
    }
}
