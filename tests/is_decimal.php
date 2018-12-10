<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

if($Mind->is_decimal('7,2')){
    echo 'This is a decimal number.';
} else {
    echo 'This is not a decimal number.';
}