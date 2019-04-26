<?php
require_once '../src/Mind.php';

$Mind = new Mind();

$schema = array(
    'test'=>'ali'
);

if($Mind->is_json(json_encode($schema))){
    echo 'This is a json syntax.';
} else {
    echo 'This is not a json syntax.';
}
