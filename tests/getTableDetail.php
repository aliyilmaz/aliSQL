<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$Mind->selectDB('test1');

echo '<pre>';
print_r($Mind->getTableDetail('users'));
echo '</pre>';