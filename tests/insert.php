<?php
require_once('../src/Mind.php');

$Mind = new Mind();

echo '<br>';
$values = array(
    'username'=>'Ali Yılmaz',
    'password'=>md5('123456')
);

if($Mind->insert('users', $values)){
    echo 'Kayıt eklendi.';
} else {
    echo 'Kayıt eklenemedi.';
}

echo '<br>';
$values = array(
    array(
        'username'=>'Ali Yılmaz0',
        'password'=>md5('123456')
    ),
    array(
        'username'=>'Ali Yılmaz1',
        'password'=>md5('123456')
    ),
    array(
        'username'=>'Ali Yılmaz2',
        'password'=>md5('123456')
    )
);

if($Mind->insert('users', $values)){
    echo 'Kayıt eklendi.';
} else {
    echo 'Kayıt eklenemedi.';
}
