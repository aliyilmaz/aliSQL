<?php
require_once('../src/Mind.php');

$Mind = new Mind();

echo '<br>';
$values = array(
    'username'=>'Ali Yılmaz',
    'password'=>md5('123456')
);

if($Mind->update('users', $values, 3)){
    echo 'Kayıt güncellendi.';
} else {
    echo 'Kayıt güncellenemedi.';
}



echo '<br>';
$values = array(
    'username'=>'Ali Yılmaz11',
    'password'=>md5('123456')
);

if($Mind->update('users', $values, 3, 'id')){
    echo 'Kayıt güncellendi.';
} else {
    echo 'Kayıt güncellenemedi.';
}
