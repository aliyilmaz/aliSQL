<?php
require_once '../src/Mind.php';

$Mind = new Mind();
//
//
//$scheme = array(
//    'id:increments',
//    'username:string',
//    'password:string',
//    'email:string',
//    'avatar:small',
//    '_token:small',
//    'created_at:string',
//    'updated_at:string'
//);
//$Mind->tableCreate('users', $scheme);
//
//$scheme = array(
//    array(
//        'username'=>'Tilo Mitra',
//        'password'=>md5('123456'),
//        'email'=>'tilo.mitra@example.com',
//        'avatar'=>'public/img/common/tilo-avatar.png',
//        '_token'=>md5(rand(999,9999)),
//        'created_at'=>$Mind->timestamp
//    ),
//    array(
//        'username'=>'Eric Ferraiuolo',
//        'password'=>md5('123456'),
//        'email'=>'eric.ferraiuolo@example.com',
//        'avatar'=>'public/img/common/ericf-avatar.png',
//        '_token'=>md5(rand(999,9999)),
//        'created_at'=>$Mind->timestamp
//    ),
//    array(
//        'username'=>'Reid Burke',
//        'password'=>md5('123456'),
//        'email'=>'reid.burke@example.com',
//        'avatar'=>'public/img/common/reid-avatar.png',
//        '_token'=>md5(rand(999,9999)),
//        'created_at'=>$Mind->timestamp
//    ),
//    array(
//        'username'=>'Andrew Wooldridge',
//        'password'=>md5('123456'),
//        'email'=>'andrew.wooldridge@example.com',
//        'avatar'=>'public/img/common/andrew-avatar.png',
//        '_token'=>md5(rand(999,9999)),
//        'created_at'=>$Mind->timestamp
//    )
//);
//$scheme = array(
//    'username'=>'Deniz',
//    'password'=>md5('123456'),
//    'email'=>'deniz@example.com',
//    'avatar'=>'public/img/common/deniz.png',
//    '_token'=>md5(rand(999,9999)),
//    'created_at'=>$Mind->timestamp
//);

//$Mind->insert('users', $scheme);

echo '<br>';

/*
Array
(
    [id] => 1
    [username] => Tilo Mitra
    [password] => e10adc3949ba59abbe56e057f20f883e
    [email] => tilo.mitra@example.com
    [avatar] => public/img/common/tilo-avatar.png
    [_token] => 9e7ba617ad9e69b39bd0c29335b79629
    [created_at] => 10-06-2019 04:28:51
    [updated_at] =>
)
*/
echo '<pre>';
print_r($Mind->samantha('users', array('id'=>'1')));
echo '</pre>';

echo '<br>';

/*
Array
(
    [username] => Tilo Mitra
    [password] => e10adc3949ba59abbe56e057f20f883e
)
*/
echo '<pre>';
print_r($Mind->samantha('users', array('id'=>'1'), array('username', 'password')));
echo '</pre>';

echo '<br>';

/*
    public/img/common/tilo-avatar.png
*/
echo $Mind->samantha('users', array('id'=>'1'), 'avatar' );

echo '<br>';

/*
 * Array
(
    [0] => Array
        (
            [username] => Tilo Mitra
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

    [1] => Array
        (
            [username] => Eric Ferraiuolo
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

    [2] => Array
        (
            [username] => Reid Burke
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

    [3] => Array
        (
            [username] => Andrew Wooldridge
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

    [4] => Array
        (
            [username] => Deniz
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

)
 */
echo '<pre>';
print_r($Mind->samantha('users', array('password'=>'e10adc3949ba59abbe56e057f20f883e'), array('username', 'password')));
echo '</pre>';