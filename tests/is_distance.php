<?php

require_once '../src/Mind.php';

$Mind = new Mind();

/* These are two points in Turkey */
$point1 = array(41.008610,28.971111); // Istanbul
$point2 = array(39.925018,32.836956); // Anitkabir

echo '<br>';
if($Mind->is_distance($point1, $point2, '349:km')){
    echo 'It is within range.';
} else {
    echo 'It is not within range.';
}
echo '<br>';
if($Mind->is_distance($point1, $point2, '347:km')){
    echo 'It is within range.';
} else {
    echo 'It is not within range.';
}