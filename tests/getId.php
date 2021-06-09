<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$needle = array(
    'username'=>'burcu',
    'password'=>md5(123123)
);

echo $Mind->getId('users', $needle);