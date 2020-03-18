<?php

require_once '../src/Mind.php';

$Mind = new Mind();

echo '<br>';
if($Mind->is_age('1987-03-17', 35)){
    echo 'Age is appropriate.';
} else {
    echo 'Age is not appropriate.';
}
echo '<br>';
if($Mind->is_age('1987-03-17', 32)){
    echo 'Age is appropriate.';
} else {
    echo 'Age is not appropriate.';
}
echo '<br>';
if($Mind->is_age('1987-03-17', 35)){
    echo 'Age is appropriate.';
} else {
    echo 'Age is not appropriate.';
}