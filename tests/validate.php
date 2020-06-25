<?php

require_once('../src/Mind.php');

$Mind = new Mind();

/*
 | Support Rule;
 | --------------------------------------------------------
 | required, email, url, phone, color, https, http,
 | json, max-num, min-num, max-char, min-char, numeric,
 | min-age, max-age, date, unique, unchanged, bool, iban, 
 | ipv4, ipv6, blood, coordinate, distance
 | 
 */

//  Data
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

// Rule
$rule = array(
    'title'             =>  'required|unique:posts',
    'email'             =>  'email|unchanged:users',
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

// Message
$message = array(
    'required'          =>  'It should not be left blank.',
    'email'             =>  'A valid e-mail address must be specified.',
    'url'               =>  'A valid URL must be specified.',
    'phone'             =>  'A valid phone number must be specified.',
    'color'             =>  'A valid color must be specified.',
    'https'             =>  'A valid https address must be specified.',
    'http'              =>  'A valid http address must be specified.',
    'json'              =>  'A valid json data must be specified.',
    'max-num'           =>  'The maximum number should not be exceeded.',
    'min-num'           =>  'The minimum number must be specified.',
    'max-char'          =>  'The maximum character limit must not be exceeded.',
    'min-char'          =>  'Minimum character limit must be specified.',
    'numeric'           =>  'Numeric character must be specified.',
    'min-age'           =>  'An age less than the minimum age must be specified.',
    'max-age'           =>  'An age greater than the maximum age must be specified.',
    'date'              =>  'Date must be specified in year-month-day format.',
    'unique'            =>  'A unique record must be specified.',
    'unchanged'         =>  'The same or different data must be specified.',
    'bool'              =>  'Validation failed.',
    'iban'              =>  'The IBAN account has not been verified.',
    'ipv4'              =>  'An IP address must be specified in the ipv4 syntax.',
    'ipv6'              =>  'An IP address must be specified in the ipv6 syntax.',
    'blood'             =>  'The blood group according to the instructions should be specified.',
    'coordinate'        =>  'A valid coordinate must be specified.',
    'distance'          =>  'The coordinate point within range must be specified.'

);

if($Mind->validate($rule, $data, $message)){
    echo 'Everything is OK';
} else {
    echo '<pre>';
    print_r($Mind->errors);
    echo '</pre>';
}