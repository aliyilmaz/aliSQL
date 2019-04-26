<?php

require_once '../src/Mind.php';

$Mind = new Mind();

/**
 * Record reading.
 *
 * @param string $tableName
 * @param string $option[column]
 *
 * @return mixed
 * */
$option = array(
    'column' => 'name',
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (column[string])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (column[string])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param mixed  $option[column]
 *
 * @return mixed
 * */
$option = array(
    'column' => array(
        'name',
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (column[array])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (column[array])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param string $option[search][keyword]
 *
 * @return mixed
 * */
$option = array(
    'search' => array(
        'keyword' => 'Ali Yılmaz',
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (search[keyword][string])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (search[keyword][string])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param mixed  $option[search][keyword]
 *
 * @return mixed
 * */
$option = array(
    'search' => array(
        'keyword' => array('Ali Yılmaz', 'Ali Yılmaz83'),
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (search[keyword][array])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (search[keyword][array])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param string $option[search][where]
 *
 * @return mixed
 * */
$option = array(
    'search' => array(
        'keyword' => 'Ali Yılmaz',
        'where' => 'all',
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (search[where])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (search[where])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param string $option[search][column]
 *
 * @return mixed
 * */
$option = array(
    'search' => array(
        'keyword' => 'Ali Yılmaz',
        'column' => 'name',
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (search[column][string])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (search[column][string])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param mixed  $option[search][column]
 *
 * @return mixed
 * */
$option = array(
    'search' => array(
        'keyword' => 'Ali Yılmaz',
        'column' => array('name', 'phone'),
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (search[column][array])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (search[column][array])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param mixed  $option[search][equal]
 *
 * @return mixed
 * */
$option = array(
    'search' => array(
        'equal' => array('username' => 'admin', 'password' => 'root'),
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (search[equal])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (search[equal])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param mixed  $option[limit][start]
 *
 * @return mixed
 * */
$option = array(
    'limit' => array(
        'start' => 4,
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (limit[start])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (limit[start])</h5>';

/**
 * Record reading.
 *
 * @param string $tableName
 * @param mixed  $option[limit][end]
 *
 * @return mixed
 * */
$option = array(
    'limit' => array(
        'end' => 10,
    ),
);
$tableName = 'phonebook';
$get = $Mind->get($tableName, $option);

if (!$get) {
    exit('Error: Record reading. (limit[end])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';
}
echo '<h5>Record reading. (limit[end])</h5>';

echo '<h1>The record reading method is running.</h1>';
