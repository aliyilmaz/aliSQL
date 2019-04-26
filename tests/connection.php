<?php

require_once '../src/Mind.php';

$Mind = new Mind();
echo '<h5>Connection method. new Mind()</h5>';

$conf = array(
    'host' => 'localhost',
    'dbname' => 'mydb',
    'username' => 'root',
    'password' => '',
);
$Mind = new Mind($conf);
echo '<h5>Connection method. new Mind($conf)</h5>';

echo '<h1>The database connection method is running.</h1>';
