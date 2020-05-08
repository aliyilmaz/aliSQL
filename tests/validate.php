<?php

require_once('../src/Mind.php');

$Mind = new Mind();

/**
 * Support Rule;
 * required, email, url, phone, color, https, http,
 * json, max-num, min-num, max-char, min-char, numeric,
 * min-age, max-age, date, unique, bool, iban, ipv4,
 * ipv6, blood, coordinate, distance
 * 
 */

//  Veriler
$data = array(
    'title'             =>  'Merhaba dünya1',
    'email'             =>  'aliyilmaz.work@gmail.com',
    'phone_number'      =>  '05554248988',
    'background_color'  =>  '#ffffff',
    'webpage'           =>  'http://google.com',
    'https_webpage'     =>  'https://google.com',
    'http_webpage'      =>  'http://google.com',
    'json_data'         =>  '{ "name":"John", "age":30, "car":null }',
    'content'           =>  'merhaba',
    'summary'           =>  'merhab',
    'quentity'          =>  '4',
    'numeric_str'       =>  12,
    'birthday'          =>  '1987-02-14',
    'register_date'     =>  '2020-02-18 14:34:22',
    'status'            =>  1,
    'ibanNumber'        =>  'SE35 5000 0000 0549 1000 0003',
    'ipv4Address'       =>  '127.0.0.1',
    'ipv6Address'       =>  '2001:0db8:85a3:08d3:1319:8a2e:0370:7334',
    'bloodGroup'        =>  '0+',
    'coordinates'       =>  '41.008610,28.971111',
    'distances'         =>  '41.008610,28.971111@39.925018,32.836956'


 );

// Kurallar
$rule = array(
    'title'             =>  'required|unique:posts',
    'email'             =>  'email',
    'phone_number'      =>  'phone',
    'background_color'  =>  'color',
    'webpage'           =>  'url',
    'https_webpage'     =>  'https',
    'http_webpage'      =>  'http',
    'json_data'         =>  'json',
    'content'           =>  'max-char:7',
    'summary'           =>  'min-char:6|max-char:10',
    'quentity'          =>  'max-num:4|min-num:2',
    'numeric_str'       =>  'numeric',
    'birthday'          =>  'min-age:33|max-age:40',
    'register_date'     =>  'date:Y-m-d H:i:s',
    'status'            =>  'bool:true',
    'ibanNumber'        =>  'iban',
    'ipv4Address'       =>  'ipv4',
    'ipv6Address'       =>  'ipv6',
    'bloodGroup'        =>  'blood:0+',
    'coordinates'       =>  'required|coordinate',
    'distances'         =>  'distance:349 km'
);

// Mesajlar
$message = array(
    'required'          =>  'Boş bırakılmamalıdır.',
    'email'             =>  'Geçerli bir e-mail adresi belirtilmelidir.',
    'url'               =>  'Geçerli bir URL belirtilmelidir.',
    'phone'             =>  'Geçerli bir telefon numarası belirtilmelidir.',
    'color'             =>  'Geçerli bir renk belirtilmelidir.',
    'https'             =>  'Geçerli bir https adresi belirtilmelidir.',
    'http'              =>  'Geçerli bir http adresi belirtilmelidir.',
    'json'              =>  'Geçerli bir json verisi belirtilmelidir.',
    'max-num'           =>  'Maksimum sayı aşılmamalıdır.',
    'min-num'           =>  'Minumum sayı belirtilmelidir.',
    'max-char'          =>  'Maksimum karakter limiti aşılmamalıdır.',
    'min-char'          =>  'Minumum karakter limiti belirtilmelidir.',
    'numeric'           =>  'Numerik karakter belirtilmelidir.',
    'min-age'           =>  'Minumum yaştan küçük bir yaş belirtilmelidir.',
    'max-age'           =>  'Maksimum yaştan büyük bir yaş belirtilmelidir.',
    'date'              =>  'Yıl-Ay-Gün biçiminde tarih belirtilmelidir.',
    'unique'            =>  'Benzersiz bir kayıt belirtilmelidir.',
    'bool'              =>  'Doğrulama başarısız.',
    'iban'              =>  'IBAN hesabı doğrulanamadı.',
    'ipv4'              =>  'ipv4 söz diziminde bir IP adresi belirtilmelidir.',
    'ipv6'              =>  'ipv6 söz diziminde bir IP adresi belirtilmelidir.',
    'blood'             =>  'Yönergelerde bulunan bir kan grubu belirtilmelidir.',
    'coordinate'        =>  'Geçerli bir koordinat belirtilmelidir.',
    'distance'          =>  'Menzil içinde bulunan koordinat noktası belirtilmelidir.'

);

// Kural isimleri
echo '<h3>All Rules</h3>';
echo '<ol><li>'.implode('</li><li>', array_keys($message)).'</li></ol>';

if($Mind->validate($rule, $data, $message)){
    echo '<h3>Rule</h3>';
    echo '<pre>';
    print_r($rule);
    echo '</pre>';

    echo '<h3>Data</h3>';
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    echo '<h3>Message</h3>';
    echo '<pre>';
    print_r($message);
    echo '</pre>';
} else {
    print_r($Mind->errors);
}
echo '</pre>';
