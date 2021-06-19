<?php

class HomeController extends Mind
{

    public function __construct($conf = array())
    {
        parent::__construct($conf);
    }

    public function index()
    {
        //
        echo 'merhaba ben index';
    }

    public function create()
    {
        //
        echo 'merhaba ben create';
    }

}
