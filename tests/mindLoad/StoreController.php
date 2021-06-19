<?php

class StoreController extends Mind
{

    public function __construct($conf = array())
    {
        parent::__construct($conf);
    }

    public function index()
    {
        //
        echo 'merhaba ben store\'dan index';
    }

    public function create()
    {
        //
        echo 'merhaba ben create';
    }

}
