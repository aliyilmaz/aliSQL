<?php

require_once '../src/Mind.php';

$Mind = new Mind();

echo $Mind->generateToken();
// echo $Mind->generateToken(30);