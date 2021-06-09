<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$second_size = '35 KB';
$Mind->post['photo'] = array(
	'size'=>35840
);
if($Mind->is_size($Mind->post['photo'], $second_size)){
	echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}

echo '<br>';

$Mind->post['photo'] = array(
	'size'=>36700160
);
if($Mind->is_size($Mind->post['photo'], '35 MB')){
	echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}

echo '<br>';

$Mind->post['photo'] = array(
	'size'=>37580963840
);
if($Mind->is_size($Mind->post['photo'], '35 GB')){
	echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}

echo '<br>';

$Mind->post['photo'] = array(
	'size'=>1099511627776
);
if($Mind->is_size($Mind->post['photo'], '1 TB')){
	echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}

echo '<br>';

$Mind->post['photo'] = array(
	'size'=>1125899906842624
);
if($Mind->is_size($Mind->post['photo'], '1 PB')){
	echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}

echo '<br>';

$second_size = 35839;
$first_size = 35839;
if($Mind->is_size($first_size, $second_size)){
	echo 'Değer belirtilen boyuttan küçüktür';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}

echo '<br>';

$second_size = '35 KB';
$first_size = '35840';
if($Mind->is_size($first_size, $second_size)){
	echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}

echo '<br>';

$second_size = '1024 KB';
$first_size = '1023 KB';
if($Mind->is_size($first_size, $second_size)){
	echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
} else {
	echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
}
