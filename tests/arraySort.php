<?php

require_once '../src/Mind.php';

$Mind = new Mind();

/* -------------------------------------------------------------------------- */
/*                                    ARRAY                                   */
/* -------------------------------------------------------------------------- */
echo '<h1>ARRAY</h1>';
echo '<hr>';

// 1 KADEMELİ DİZİLERDE SIRALAMA YAPMAK
$data = array(
    2021,
    2020,
    2019
);
echo '<h4>2021 üstte</h4>';
$Mind->print_pre($Mind->arraySort($data, 'DESC'));


// 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTEREK SIRALAMA YAPMAK
$data = array(
    array(
        'username'=>'aliyilmaz',
        'age'=>33
    ),
    array(
        'username'=>'eylül',
        'age'=>30
    )
);
echo '<hr>';
echo '<h4>eylül üstte</h4>';
$Mind->print_pre($Mind->arraySort($data, 'ASC', 'age'));


// 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTMEDEN SIRALAMA YAPMAK
// İLK ANAHTAR DEĞERİNİ REFERANS ALIR
$data = array(
    array(
        'username'=>'aliyilmaz',
        'age'=>33
    ),
    array(
        'username'=>'aliyilmaz1',
        'age'=>29
    ),
    array(
        'username'=>'eylül',
        'age'=>30
    )
);
echo '<hr>';
echo '<h4>aliyilmaz üstte</h4>';
$Mind->print_pre($Mind->arraySort($data, 'ASC'));


/* -------------------------------------------------------------------------- */
/*                                    JSON                                    */
/* -------------------------------------------------------------------------- */
echo '<h1>JSON</h1>';
echo '<hr>';

// 1 KADEMELİ DİZİLERDE SIRALAMA YAPMAK
$data = json_encode(array(
    2021,
    2020,
    2019
));
echo '<h4>2021 üstte</h4>';
$Mind->print_pre($Mind->arraySort($data, 'DESC'));


// 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTEREK SIRALAMA YAPMAK
$data = json_encode(array(
    array(
        'username'=>'aliyilmaz',
        'age'=>33
    ),
    array(
        'username'=>'eylül',
        'age'=>30
    )
));
echo '<hr>';
echo '<h4>eylül üstte</h4>';
$Mind->print_pre($Mind->arraySort($data, 'ASC', 'age'));


// 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTMEDEN SIRALAMA YAPMAK
// İLK ANAHTAR DEĞERİNİ REFERANS ALIR
$data = json_encode(array(
    array(
        'username'=>'aliyilmaz',
        'age'=>33
    ),
    array(
        'username'=>'aliyilmaz1',
        'age'=>29
    ),
    array(
        'username'=>'eylül',
        'age'=>30
    )
));
echo '<hr>';
echo '<h4>aliyilmaz üstte</h4>';
$Mind->print_pre($Mind->arraySort($data, 'ASC'));