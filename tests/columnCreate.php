<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

$scheme = array(
    'username'
);
if($Mind->columnCreate('yenitablo', $scheme)){
    echo 'Sütun oluşturuldu.';
} else {
    echo 'Sütun oluşturulamadı.';
}

echo '<br>';

$scheme = array(
//    'id:increments:14',
    'created_at',
    'updated_at',
    '_token'
);
if($Mind->columnCreate('yenitablo', $scheme)){
    echo 'Sütunlar oluşturuldu.';
} else {
    echo 'Sütunlar oluşturulamadı.';
}