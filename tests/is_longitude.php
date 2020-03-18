<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$longitude = '28.971111';

echo '<br>';

if($Mind->is_longitude($longitude)){
    echo 'The current longitude.';
} else {
    echo 'Invalid longitude.';
}
