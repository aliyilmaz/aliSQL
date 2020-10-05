<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$str = '123456';

if($Mind->is_md5($str)){
    echo 'This is an md5.';
} else {
    echo 'This is not an MD5.';
}

if($Mind->is_md5(md5($str))){
    echo 'This is an md5.';
} else {
    echo 'This is not an MD5.';
}