<?php

require_once('../src/Mind.php');

$Mind = new Mind();

/**
 * Support Rule;
 * required, email, phone, color, 
 * url, https, http, json, max, min,
 * min-age, max-age, date, numeric,
 * unique, bool, IBAN
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
    'numeric_str'       =>  12,
    'birthday'          =>  '1987-02-14',
    'register_date'     =>  '2020-02-18',
    'status'            =>  1,
    'ibanNumber'        =>  'SE35 5000 0000 0549 1000 0003',
    'ipv4Address'       =>  '127.0.0.1',
    'ipv6Address'       =>  '2001:0db8:85a3:08d3:1319:8a2e:0370:7334',


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
    'content'           =>  'max-num:7',
    'summary'           =>  'min-num:6|max-num:10',
    'numeric_str'       =>  'numeric',
    'birthday'          =>  'min-age:34|max-age:40',
    'register_date'     =>  'date',
    'status'            =>  'bool',
    'ibanNumber'        =>  'iban',
    'ipv4Address'       =>  'ipv4',
    'ipv6Address'       =>  'ipv6'
);

// Mesajlar
$message = array(
    'required'          =>  'Boş bırakılmamalıdır.',
    'email'             =>  'Geçerli bir e-posta adresi belirtilmelidir.',
    'url'               =>  'Geçerli bir URL belirtilmelidir.',
    'phone'             =>  'Geçerli bir telefon numarası belirtilmelidir.',
    'color'             =>  'Geçerli bir renk belirtilmelidir.',
    'https'             =>  'Geçerli bir https adresi belirtilmelidir.',
    'http'              =>  'Geçerli bir http adresi belirtilmelidir.',
    'json'              =>  'Geçerli bir json verisi belirtilmelidir.',
    'max-num'           =>  'Maksimum karakter limiti aşılmamalıdır.',
    'min-num'           =>  'Minumum karakter limiti belirtilmelidir.',
    'numeric'           =>  'Numerik karakter belirtilmelidir.',
    'min-age'           =>  'Minumum yaştan küçük bir yaş belirtemezsiniz.',
    'max-age'           =>  'Maksimum yaştan büyük bir yaş belirtemezsiniz.',
    'date'              =>  'Yıl-Ay-Gün biçiminde tarih belirtilmelidir.',
    'unique'            =>  'Benzersiz bir kayıt belirtilmelidir.',
    'bool'              =>  'Doğrulama başarısız.',
    'iban'              =>  'IBAN hesabı doğrulanamadı.',
    'ipv4'              =>  'ipv4 söz diziminde bir IP adresi belirtilmelidir.',
    'ipv6'              =>  'ipv6 söz diziminde bir IP adresi belirtilmelidir.'

);

// Kural isimleri
echo '<h1 align="center">'.implode(', ', array_keys($message)).'</h1>';

echo '<pre>';
if($Mind->validate($rule, $data, $message)){
    print_r($rule);
    print_r($data);
} else {
    print_r($Mind->errors);
}
echo '</pre>';

