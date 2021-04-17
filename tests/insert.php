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

// echo '<br>';
// $values = array(
//     array(
//         'username'=>'Ali Yılmaz0',
//         'password'=>md5('123456')
//     ),
//     array(
//         'username'=>'Ali Yılmaz1',
//         'password'=>md5('123456')
//     ),
//     array(
//         'username'=>'Ali Yılmaz2',
//         'password'=>md5('123456')
//     )
// );

// if($Mind->insert('users', $values)){
//     echo 'Kayıt eklendi.';
// } else {
//     echo 'Kayıt eklenemedi.';
// }

// $values = array(
//     'username'=>'aliyilmaz1',
//     'password'=>'1111111111'
// );
// $options = array(
//     'log'=>array(
//         'dataa'=>json_encode($values)
//     )
// );
// if($Mind->insert('users', $values, $options)){
//     echo 'Kayıt eklendi.';
// } else {
//     echo 'Kayıt eklenemedi.';
// }

// echo '<br>';
// if($this->delete('users', 1, array('posts'=>'author_id', 'gallery'=>'author_id'))){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// $values = array(
//     'username'=>'aliyilmaz1',
//     'password'=>'1111111111'
// );
// $trigger = array(
//     'users'=>array(
//         'username'=>'aliyilmaz2',
//         'password'=>'2222222222'
//     ),
//     'log'=>array(
//         'data'=>'test'
//     )
// );
// if($Mind->insert('users', $values, $trigger)){
//     echo 'Kayıt eklendi.';
// } else {
//     echo 'Kayıt eklenemedi.';
// }


// $values = array(
//     'username'=>'aliyilmaz1',
//     'password'=>'1111111111'
// );
// $trigger = array(
//     'users'=>array(
//         array(
//             'username'=>'ali1',
//             'password'=>'pass1'
//         ),
//         array(
//             'username'=>'ali2',
//             'password'=>'pass2'
//         )
//     ),
//     'log'=>array(
//         'data'=>'test'
//     )
// );
// if($Mind->insert('users', $values, $trigger)){
//     echo 'Kayıt eklendi.';
// } else {
//     echo 'Kayıt eklenemedi.';
// }
