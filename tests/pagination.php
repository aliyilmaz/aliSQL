<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

// url: pagination.php?page OR pagination.php?page=1
// url: pagination.php?p OR pagination.php?p=1
$options = array(
    'prefix'=>'page', // Default p
    'search'=>array(
        'scope'=>'like',
        'keyword'=>'%a%',
        'column'=>'text',
        'delimiter'=>array(
            'or'=>'AND'
        ),
        'or'=>array(
            array(
                'sender_id'=>1,
                'reciver_id'=>1
            ),
            array(
                'sender_id'=>3,
                'reciver_id'=>3
            )
        )
    ),
    'column'=>array('sender_id','reciver_id','text'), // array / string
    'limit'=>2, // Default 5
    'format'=>'json' // json 
);
// $data = $Mind->pagination('messages');
$data = $Mind->pagination('messages', $options);


if($Mind->is_json($data)){

    /* -------------------------------------------------------------------------- */
    /*                                    JSON                                    */
    /* -------------------------------------------------------------------------- */
    echo '<pre>';
    echo $data;
    echo '</pre>';

    $data = json_decode($data, true);

} else {

    /* -------------------------------------------------------------------------- */
    /*                                    ARRAY                                   */
    /* -------------------------------------------------------------------------- */
    echo '<pre>';
    print_r($data['data']);
    echo '</pre>';
}

echo "\n";

/* -------------------------------------------------------------------------- */
/*                                 NAVIGATION                                 */
/* -------------------------------------------------------------------------- */
$prefix = $data['prefix'];
for ($i=1; $i <= $data['totalPage']; $i++) { 

    echo "\n<a ";

    if($i == $Mind->post[$prefix] OR empty($Mind->post[$prefix])){ 
        echo 'class="pageSelected" ';
    }
    echo 'href="'.$Mind->base_url.'pagination.php?'.$prefix.'='.$i.'">'.$i.'</a>';
}

echo "\n\n";

?>

<style>
a,.pageSelected{
    padding:5px;
    letter-spacing: 20px;
    text-decoration: none;
    text-align: center;
}
.pageSelected{
    background-color: #444;
    color: #fff;
}
</style>