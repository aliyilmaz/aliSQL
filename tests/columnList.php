<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

print_r($Mind->columnList('phonebook'));