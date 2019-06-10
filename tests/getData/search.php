<?php
require_once('../../src/Mind.php');

$Mind = new Mind();


echo '<h2>1) Bir veya birçok kelimeyi veritabanı tablosunun tüm sütunlarında aramak (tilo, re)</h2>';
$options = array(
    'search'=>array(
        'keyword'=>'%tilo%'
    )
);


echo '<pre>';
echo '<h3>Sorgu Şeması</h3>';
print_r($options);

echo '<h3>Sorgu Sonucu</h3>';
print_r($Mind->getData('users', $options));
echo '</pre>';

echo '<hr>';

$options = array(
    'search'=>array(
        'keyword'=>array('%tilo%', '%re%')
    )
);


echo '<pre>';
echo '<h3>Sorgu Şeması</h3>';
print_r($options);

echo '<h3>Sorgu Sonucu</h3>';
print_r($Mind->getData('users', $options));
echo '</pre>';


echo '<hr>';

echo '<h2>2) Kelime aramasını veritabanı tablosunun belirtilen sütun veya sütunlarında yapmak (tilo, e10)</h2>';
$options = array(
    'search'=>array(
        'keyword'=>'%tilo%',
        'column'=>'username'
    )
);


echo '<pre>';
echo '<h3>Sorgu Şeması</h3>';
print_r($options);

echo '<h3>Sorgu Sonucu</h3>';
print_r($Mind->getData('users', $options));
echo '</pre>';

echo '<hr>';

$options = array(
    'search'=>array(
        'keyword'=>'%e10%',
        'column'=>array(
            'username',
            'password'
        )
    )
);


echo '<pre>';
echo '<h3>Sorgu Şeması</h3>';
print_r($options);

echo '<h3>Sorgu Sonucu</h3>';
print_r($Mind->getData('users', $options));
echo '</pre>';

echo '<hr>';

echo '<h2>3) Bir kaydın farklı sütunlarında ki verileri çoklu denklem esasına göre aramak (Eric Ferraiuolo, e10adc3949ba59abbe56e057f20f883e)</h2>';
$options = array(
    'search'=>array(
        'and'=>array(
            'password'=>'e10adc3949ba59abbe56e057f20f883e',
            'created_at'=>'03-06-2019 17:22:37'
        )
    )
);


echo '<pre>';
echo '<h3>Sorgu Şeması</h3>';
print_r($options);

echo '<h3>Sorgu Sonucu</h3>';
print_r($Mind->getData('users', $options));
echo '</pre>';

echo '<hr>';