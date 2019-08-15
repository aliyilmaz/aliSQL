<?php
require_once '../src/Mind.php';

$Mind = new Mind();

echo '<br>';
$url 	= 'https://www.cloudflare.com/';
$left 	= '<title>';
$right	= '</title>';
$data 	= $Mind->get_contents($left, $right, $url);
print_r($data);


echo '<br><br>';

$url 	= 'https://www.cloudflare.com/';
$left 	= '<link rel="alternate" hreflang="';
$right	= '"';
$data 	= $Mind->get_contents($left, $right, $url);
print_r($data);


echo '<br><br>';

$url 	= 'Örnek bir içeriktir. <title>Merhaba Dünya!</title>';
$left 	= '<title>';
$right	= '</title>';
$data 	= $Mind->get_contents($left, $right, $url);
print_r($data);