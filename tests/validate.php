<?php

require_once('../src/Mind.php');

$Mind = new Mind();

/**
 * Support Rule;
 * required, email, phone, color, 
 * url, https, http, json, max, min,
 * numeric
 * 
 */

//  Veriler
$data = array(
    'title'             =>  'merhaba dünya',
    'email'             =>  'aliyilmaz.work@gmail.com',
    'phone_number'      =>  '05554248988',
    'background_color'  =>  '#ffffff',
    'webpage'           =>  'http://google.com',
    'https_webpage'     =>  'https://google.com',
    'http_webpage'      =>  'http://google.com',
    'json_data'         =>  '{ "name":"John", "age":30, "car":null }',
    'content'           =>  'merhaba',
    'summary'           =>  'merha',
    'numeric_str'       =>  '12',
    'birthday'          =>  '1987-02-14'

 );

// Kurallar
$rule = array(
    'title'             =>  'required',
    'email'             =>  'email',
    'phone_number'      =>  'phone',
    'background_color'  =>  'color',
    'webpage'           =>  'url',
    'https_webpage'     =>  'https',
    'http_webpage'      =>  'http',
    'json_data'         =>  'json',
    'content'           =>  'max:7',
    'summary'           =>  'min:5',
    'numeric_str'       =>  'numeric',
    'birthday'          =>  'age:34'
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
    'max'               =>  'Maksimum karakter limiti aşılmamalıdır.',
    'min'               =>  'Minumum karakter limiti belirtilmelidir.',
    'numeric'           =>  'Numerik karakter belirtilmelidir.',
    'age'               =>  'Bu işlem için yaş sınırlaması vardır.'

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

