<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

if($Mind->is_column('phonebook', 'name')){
    echo 'true';
} else {
    echo 'false';
}