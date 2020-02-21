<?php

require_once '../src/Mind.php';

$Mind = new Mind();

echo '<br>';

if($Mind->is_blood('0+')){
    echo 'Yes, this is a blood.';
} else {
    echo 'No, this is not a blood.';
}

echo '<br>';

if($Mind->is_blood('0+', '0+')){
    echo 'Yes, this is a compatible blood.';
} else {
    echo 'No, this is not compatible blood.';
}
