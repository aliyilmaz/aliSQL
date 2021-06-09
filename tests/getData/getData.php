<?php
require_once('../../src/Mind.php');

$Mind = new Mind();

// $options = array(
//     'sort'=>'id:asc',
//     'limit'=>array(
//         'start'=>2,
//         'end'=>1
//     ),
//     'format'=>'json'
// );

// $Mind->print_pre($Mind->getData('users', $options));


// $scheme = array(
//     'users','groups'
// );

// $scheme = array(
//     'users',
//     'groups'=>array(
//         'column'=>'name'
//     )
// );

$scheme = array(
    'users'=>array(
        'column'=>array('username', 'password')
    ),
    'groups'=>array(
        'column'=>array('name')
    )
);


$Mind->print_pre($Mind->getData($scheme));