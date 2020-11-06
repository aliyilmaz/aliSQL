<?php

require_once '../../src/Mind.php';

$Mind = new Mind();

// $Mind->backup('mydb');

// $Mind->backup(array('mydb', 'trek'));

// $Mind->backup('mydb', 'restore/');

$Mind->backup(array('mydb', 'trek'), './');