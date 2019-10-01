<?php
require_once '../src/Mind.php';

$Mind = new Mind();

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
