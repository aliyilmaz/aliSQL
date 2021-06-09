<?php

require_once '../src/Mind.php';

$Mind = new Mind();


echo '<br>';
if($Mind->is_ipv6('2001:0db8:85a3:08d3:1319:8a2e:0370:7334')){
    echo 'This is an ipv6 address.';
} else {
    echo 'This is not an ipv6 address.';
}

echo'<br>';
if($Mind->is_ipv6('2001:0db8:85a3:08d3:1319:8a2e:0370:7334dsdsd')){
    echo 'This is an ipv6 address.';
} else {
    echo 'This is not an ipv6 address.';
}
