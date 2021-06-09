<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

if($Mind->is_table('phonebook')){
    echo 'true';
} else {
    echo 'false';
}