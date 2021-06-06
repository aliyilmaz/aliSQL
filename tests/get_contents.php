<?php
require_once '../src/Mind.php';

$Mind = new Mind();

/*$url = 'https://www.cloudflare.com/';
$left = '';
$right = '';
$data 	= $Mind->get_contents($left, $right, $url);
print_r($data);

echo '<br><br>';

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

echo '<br><br>';

$url = 'src=\'-str\'-after src=\'-str\'-after src=\'-str\'-after src=\'-str\'-after';
$left = 'src=\'';
$right = '\'-after';
$data 	= $Mind->get_contents($left, $right, $url);
print_r($data);

echo '<br><br>';

$url = '{"filmler": [  {"imdb": "tt0116231", "url": "&lt;iframe src=&#039;https://example.com&#039; width=&#039;640&#039; height=&#039;360&#039; frameborder=&#039;0&#039; marginwidth=&#039;0&#039; marginheight=&#039;0&#039; scrolling=&#039;NO&#039; allowfullscreen=&#039;allowfullscreen&#039;&gt;&lt;/iframe&gt;"} ]}';
$left = 'src=&#039;';
$right = '&#039;';
$data 	= $Mind->get_contents($left, $right, $url);
print_r($data);*/

// $url = 'https://www.example.com/login';
// $left = '';
// $right = '';
// $options = array(
// //    'referer'=>$url,
//     'post'=>array(
//         'username'=>'aliyilmaz',
//         'password'=>'123456'
//     )
// );

// // Start connection.
// $Mind->get_contents($left, $right, $url, $options);

// // Session access.
// $url = 'https://www.example.com/admin/users';
// $left = '<title>';
// $right = '</title>';
// $data = $Mind->get_contents($left, $right, $url);
// $Mind->print_pre($data);


$xml_data ='<?xml version="1.0" encoding="UTF-8"?>'.
    
    '<smspack ka="kullanici_adi" pwd="kullanici_parolasi" org="Originator_adi" >'.
    
    '<mesaj>'.
    
        '<metin>'.$this->post['metin'].'</metin>'.
    
            '<nums>'.$this->post['telefon'].'</nums>'.
    
    '</mesaj>'.
    
    
    
    '<mesaj>'.
    
            '<metin>'.$this->post['metin'].'</metin>'.
    
            '<nums>'.$this->post['telefon'].'</nums>'.
    
    '</mesaj>'.
    
'</smspack>';

$options = array(
    'post'=>$xml_data
);

$output = $this->get_contents('', '', 'https://smsgw.mutlucell.com/smsgw-ws/sndblkex', $options);