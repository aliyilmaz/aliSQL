<?php

require_once '../src/Mind.php';


$Mind = new Mind();

/* -------------------------------------------------------------------------- */
/*            Mind.php içinde api bilgilerini belirterek kullanmak            */
/* -------------------------------------------------------------------------- */
// $status = $Mind->sms('Bu bir test mesajıdır', '+905551112233');
// if($status){
//     echo 'SMS gönderildi.';
// } else {
//     echo 'SMS gönderilemedi.';
// }

/* -------------------------------------------------------------------------- */
/*           Mind'ı çağırırken api bilgilerini belirterek kullanmak           */
/* -------------------------------------------------------------------------- */
$conf = array(
    'sms'=>array(
        'mutlucell'=>array(
            'ka'=>'',
            'pwd'=>'',
            'org'=>'',
            'charset'=>'turkish'
        )
    )
);
$Mind = new Mind($conf);
$status = $Mind->sms('Bu bir test mesajıdır', '+905551112233');
if($status){
    echo 'SMS gönderildi.';
} else {
    echo 'SMS gönderilemedi.';
}


/* -------------------------------------------------------------------------- */
/*             Api'leri doğrudan sms metoduna göndererek kullanmak            */
/* -------------------------------------------------------------------------- */
// $conf = array(
//     'mutlucell'=>array(
//         'ka'=>'',
//         'pwd'=>'',
//         'org'=>'',
//         'charset'=>'turkish'
//     )
// );
// $status = $Mind->sms('Bu bir test mesajıdır', '+905551112233', $conf);
// if($status){
//     echo 'SMS gönderildi.';
// } else {
//     echo 'SMS gönderilemedi.';
// }