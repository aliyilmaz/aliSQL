<?php
require_once('../../src/Mind.php');

$Mind = new Mind();

$options = array(
    'column'=>'fakeColumnName'
);
print_r($Mind->getData('users', $options));

/*
 *
Array
(
)
 *
 *
 * */

$options = array(
    'column'=>'username'
);
print_r($Mind->getData('users', $options));

/*
 *
Array
(
    [0] => Array
        (
            [username] => Tilo Mitra
        )

    [1] => Array
        (
            [username] => Eric Ferraiuolo
        )

    [2] => Array
        (
            [username] => Reid Burke
        )

    [3] => Array
        (
            [username] => Andrew Wooldridge
        )

)
 *
 *
 * */


$options = array(
    'column'=>array('username')
);
print_r($Mind->getData('users', $options));

/*
 *
Array
(
    [0] => Array
        (
            [username] => Tilo Mitra
        )

    [1] => Array
        (
            [username] => Eric Ferraiuolo
        )

    [2] => Array
        (
            [username] => Reid Burke
        )

    [3] => Array
        (
            [username] => Andrew Wooldridge
        )

)
 *
 *
 * */

$options = array(
    'column'=>array('fakeColumnName', 'email', 'password')
);
print_r($Mind->getData('users', $options));

/*
 *
Array
(
    [0] => Array
        (
            [email] => tilo.mitra@example.com
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

    [1] => Array
        (
            [email] => eric.ferraiuolo@example.com
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

    [2] => Array
        (
            [email] => reid.burke@example.com
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

    [3] => Array
        (
            [email] => andrew.wooldridge@example.com
            [password] => e10adc3949ba59abbe56e057f20f883e
        )

)
 *
 *
 * */