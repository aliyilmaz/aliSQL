<?php
require_once '../src/Mind.php';

$Mind = new Mind();


echo '<hr>';

$str = 'http://localhost';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir.';
}

echo '<hr>';

$str = 'https://127.0.0.1/test';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir.';
}

echo '<hr>';

$str = 'https://test.example.com/test';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir. <strong>'.$str.'</strong>';
}

echo '<hr>';

$str = 'https://test-example.com/test';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir. <strong>'.$str.'</strong>';
}

echo '<hr>';

$str = 'example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir. <strong>'.$str.'</strong>';
}

echo '<hr>';

$str = 'http://example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir. <strong>'.$str.'</strong>';
}

echo '<hr>';

$str = 'http://www.example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir. <strong>'.$str.'</strong>';
}

echo '<hr>';

$str = 'https://www.example.com';
if($Mind->is_url($str)){
    echo 'Bu bir bağlantıdır. <strong>'.$str.'</strong>';
} else {
    echo 'Bu bir bağlantı değildir. <strong>'.$str.'</strong>';
}
