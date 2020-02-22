<?php

require_once '../src/Mind.php';

$Mind = new Mind();

if($Mind->is_iban('SE35 500 0000 0549 1000 0003')){
    echo 'The account number has been verified.';
} else {
    echo 'The account number has not been verified.';
}