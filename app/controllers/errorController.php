<?php

class errorController extends Controller
{
    function __construct()
    {
    }

    function index()
    {
        $data = [
            'title' => '404 Not Found'
        ];
        View::render('404', $data);
    }
}
