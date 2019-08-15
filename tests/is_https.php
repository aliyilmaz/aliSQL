<?php
require_once '../src/Mind.php';

$Mind = new Mind();

$url = 'https://www.google.com/';
if($Mind->is_https($url)){
    echo 'Bu bir HTTPS bağlantısıdır.';
} else {
    echo 'Bu bir HTTPS bağlantısı değildir.';
}