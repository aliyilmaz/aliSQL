<?php

require_once '../src/Mind.php';
$conf = array(
    // 'translate'=>array(
    //     'table'                 =>  'translations',
    //     'column'                =>  'lang',
    //     'haystack'              =>  'name',
    //     'return'                =>  'text',
    //     'lang'                   =>  'GB'
    // )
);

$Mind = new Mind($conf);

$scheme = array(
    'id:increments',
    'name:small',
    'text:small',
    'lang:small',
    'user_id:small',
    '_token:small',
    'status:string',
    'created_at:string',
    'updated_at:string'
);

if($Mind->tableCreate('translations', $scheme)){
    $data = array(
            array(
                "name" => "dashboard",
                "text" => "Dashboard",
                "lang" => "GB",
                "user_id" => 1,
                "_token" => $Mind->generateToken(),
                "status" => 1,
                "created_at" => $Mind->timestamp
            ),
            array(
                "name" => "profile-signout",
                "text" => "Sign out",
                "lang" => "GB",
                "user_id" => 1,
                "_token" => $Mind->generateToken(),
                "status" => 1,
                "created_at" => $Mind->timestamp
            ),
            array(
                "name" => "dashboard",
                "text" => "Başlangıç",
                "lang" => "TR",
                "user_id" => 1,
                "_token" => $Mind->generateToken(),
                "status" => 1,
                "created_at" => $Mind->timestamp
            ),
            array(
                "name" => "profile-signout",
                "text" => "Oturumu kapat",
                "lang" => "TR",
                "user_id" => 1,
                "_token" => $Mind->generateToken(),
                "status" => 1,
                "created_at" => $Mind->timestamp
            )
        );
        
    $Mind->insert('translations', $data);
}

echo $Mind->translate('dashboard'); // Varsayılan olarak TR belirtildiği için Başlangıç geri döndürülür.
echo '<br />';
echo $Mind->translate('dashboard', 'TR'); // Başlangıç
echo '<br />';
echo $Mind->translate('dashboard', 'GB'); // Dashboard