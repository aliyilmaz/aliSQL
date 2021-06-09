<?php

require_once '../src/Mind.php';

$Mind = new Mind();

echo '<br>';
if($Mind->is_ipv4('208.111.171.236')){
    echo 'This is an ipv4 address.';
} else {
    echo 'This is not an ipv4 address.';
}

echo'<br>';
if($Mind->is_ipv4('256.111.171.236')){
    echo 'This is an ipv4 address.';
} else {
    echo 'This is not an ipv4 address.';
}