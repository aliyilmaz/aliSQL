<?php
require_once ('../src/Mind.php');

$Mind = new Mind();


$scheme = array(
  'id:increments',
  'username',
  'password'
);
if($Mind->tableCreate('users', $scheme)){
    echo 'Tablo oluşturuldu.';
} else {
    echo 'Tablo oluşturulamadı.';
}