<?php

class homeController
{
    function __construct()
    {
    }

    function index()
    {
        $data = [
            'id' => 1,
            'titulo' => 'Una página'
        ];

        View::render('test', $data);
    }
}
