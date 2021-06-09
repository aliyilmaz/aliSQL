<?php
require_once '../src/Mind.php';

$Mind = new Mind();

$url = 'http://www.google.com/';
if($Mind->is_http($url)){
    echo 'Bu bir HTTP bağlantısıdır.';
} else {
    echo 'Bu bir HTTP bağlantısı değildir.';
}