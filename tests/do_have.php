<?php
require_once('../src/Mind.php');

$Mind = new Mind();

if($Mind->do_have('users', 'Reid Burke')){
    echo 'true';
} else {
    echo 'false';
}