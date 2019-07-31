<?php
require_once '../src/Mind.php';

$Mind = new Mind();



$str = 'http://localhost';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır.';
} else {
    echo 'Bu bir bağlantı değildir.';
}

echo '<hr>';

$str = 'example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır.';
} else {
    echo 'Bu bir bağlantı değildir.';
}

echo '<hr>';

$str = 'http://example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır.';
} else {
    echo 'Bu bir bağlantı değildir.';
}

echo '<hr>';

$str = 'http://www.example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır.';
} else {
    echo 'Bu bir bağlantı değildir.';
}

echo '<hr>';

$str = 'https://www.example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır.';
} else {
    echo 'Bu bir bağlantı değildir.';
}
