<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

if($Mind->is_db('mydb')){
    echo 'true';
} else {
    echo 'false';
}