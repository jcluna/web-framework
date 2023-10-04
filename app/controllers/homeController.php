<?php

class homeController
{
    function __construct()
    {
    }

    function index()
    {
        $data = [
            'title' => 'Web Framework'
        ];

        View::render('web', $data);
    }
}
