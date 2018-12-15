<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();


echo '<hr>';

#TRANSPARENT
$color = 'transparent';
if($Mind->is_color($color)){
    echo $color.' - A valid color parameter.';
} else {
    echo $color.' - It is not a valid color parameter.';
}

echo '<hr>';

#COLOR NAME
$color = 'AliceBlue';
if($Mind->is_color($color)){
    echo $color.' - A valid color parameter.';
} else {
    echo $color.' - It is not a valid color parameter.';
}

echo '<hr>';

#HEX
$color = '#000000';
if($Mind->is_color($color)){
    echo $color.' - A valid color parameter.';
} else {
    echo $color.' - It is not a valid color parameter.';
}

echo '<hr>';

#RGB
$color = 'rgb(10, 10, 20)';
if($Mind->is_color($color)){
    echo $color.' - A valid color parameter.';
} else {
    echo $color.' - It is not a valid color parameter.';
}

echo '<hr>';

#RGBA
$color = 'rgba(100,100,100,0.9)';
if($Mind->is_color($color)){
    echo $color.' - A valid color parameter.';
} else {
    echo $color.' - It is not a valid color parameter.';
}

echo '<hr>';

#HSL
$color = 'hsl(10,30%,40%)';
if($Mind->is_color($color)){
    echo $color.' - A valid color parameter.';
} else {
    echo $color.' - It is not a valid color parameter.';
}

echo '<hr>';

#HSLA
$color = 'hsla(120, 60%, 70%, 0.3)';
if($Mind->is_color($color)){
    echo $color.' - A valid color parameter.';
} else {
    echo $color.' - It is not a valid color parameter.';
}