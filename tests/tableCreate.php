<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

$scheme = array(
  'id:increments',
  'name_surname',
  'email_address'
);
if($Mind->tableCreate('yenitablo', $scheme)){
    echo 'Tablo oluşturuldu.';
} else {
    echo 'Tablo oluşturulamadı.';
}