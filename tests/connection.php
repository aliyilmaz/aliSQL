<?php

require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();
echo '<h5>Connection method. new Mind()</h5>';

$conf = array(
    'host'      =>  'localhost',
    'dbname'    =>  'mydb',
    'username'  =>  'root',
    'password'  =>  ''
);
$Mind = new Mind($conf);
echo '<h5>Connection method. new Mind($conf)</h5>';