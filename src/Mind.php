<?php

/**
 *
 * @package    Mind
 * @version    Release: 3.0.1
 * @license    GPLv3
 * @author     Ali YILMAZ <aliyilmaz.work@gmail.com>
 * @category   Php Framework, Design pattern builder for PHP.
 * @link       https://github.com/aliyilmaz/Mind
 *
 */

/**
 * Class Mind
 */
class Mind extends PDO
{
    private $host           =  'localhost';
    private $dbName         =  'mydb';
    private $username       =  'root';
    private $password       =  '';
    private $charset        =  'utf8';

    private $sess_set       =  array(
        'path'                  =>  './session/',
        'path_status'           =>  false,
        'status_session'        =>  true
    );

    public  $post;
    public  $base_url;
    public  $timezone       =  'Europe/Istanbul';
    public  $timestamp;
    public  $error_status   =  false;
    public  $error_file     =  'app/views/errors/404';

    /**
     * Mind constructor.
     * @param array $conf
     */
    public function __construct($conf=array()){

        if(isset($conf['host'])){
            $this->host = $conf['host'];
        }

        if(isset($conf['dbName'])){
            $this->dbName = $conf['dbName'];
        }

        if(isset($conf['username'])){
            $this->username = $conf['username'];
        }

        if(isset($conf['password'])){
            $this->password = $conf['password'];
        }

        if(isset($conf['charset'])){
            $this->charset = $conf['charset'];
        }

        try {
            parent::__construct('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->username, $this->password);
            $this->query('SET CHARACTER SET ' . $this->charset);
            $this->query('SET NAMES ' . $this->charset);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch ( PDOException $e ){
            print $e->getMessage();
        }

        $this->request();
        $this->session_check();

        error_reporting(-1);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        date_default_timezone_set($this->timezone);
        $this->timestamp = date("d-m-Y H:i:s");
        $this->base_url = dirname($_SERVER['SCRIPT_NAME']).'/';

    }

    public function __destruct()
    {
        if($this->error_status){
            $this->mindLoad(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$this->error_file);
            exit();
        }
    }

    /**
     * Database selector.
     *
     * @param $dbName
     */
    public function selectDB($dbName){
        if($this->is_db($dbName)){
            $this->exec("USE ".$dbName);
        }
    }

    /**
     * Lists the databases.
     *
     * @return array
     */
    public function dbList(){

        $dbNames = array();
        $sql     = 'SHOW DATABASES';

        try{
            $query = $this->query($sql, PDO::FETCH_ASSOC);

            foreach ( $query as $database ) {
                $dbNames[] = implode('', $database);
            }

            return $dbNames;

        } catch (Exception $e){
            return $dbNames;
        }
    }

    /**
     * Lists database tables.
     *
     * @param null $dbName
     * @return array
     */
    public function tableList($dbName=null){

        $tblNames = array();

        if(!is_null($dbName)){
            $dbParameter = ' FROM '.$dbName;
        } else {
            $dbParameter = '';
        }

        $sql     = 'SHOW TABLES'.$dbParameter;

        try{
            $query = $this->query($sql, PDO::FETCH_ASSOC);

            foreach ($query as $tblName){
                $tblNames[] = implode('', $tblName);
            }

            return $tblNames;

        } catch (Exception $e){
            return $tblNames;
        }
    }

    /**
     * Lists table columns.
     *
     * @param $tblName
     * @return array
     */
    public function columnList($tblName){

        $columns = array();
        $sql = 'SHOW COLUMNS FROM ' . $tblName;

        try{
            $query = $this->query($sql, PDO::FETCH_ASSOC);

            $columns = array();

            foreach ( $query as $column ) {

                $columns[] = $column['Field'];
            }

            return $columns;

        } catch (Exception $e){
            return $columns;
        }
    }

    /**
     * Creating a database.
     *
     * @param $dbName
     * @return bool
     */
    public function dbCreate($dbName){

        $dbNames = array();

        if(is_array($dbName)){
            foreach ($dbName as $key => $value) {
                $dbNames[] = $value;
            }
        } else {
            $dbNames[] = $dbName;
        }

        $xDbNames = $this->dbList();

        foreach ($dbNames as $db) {
            if(in_array($db, $xDbNames)){
                return false;
            }
        }

        try{

            foreach ( $dbNames as $dbName ) {

                $sql = "CREATE DATABASE";
                $sql .= " ".$dbName;

                $query = $this->query($sql);
                if(!$query){
                    return false;
                } else {
                    return true;
                }
            }

        }catch (Exception $e){
            return false;
        }

        return true;
    }

    /**
     * Creating a table.
     *
     * @param $tblName
     * @param $scheme
     * @return bool
     */
    public function tableCreate($tblName, $scheme){

        if(is_array($scheme) AND !$this->is_table($tblName)){

            try{

                $sql = "CREATE TABLE";
                $sql .= " ".$tblName."( ";
                $sql .= implode(',', $this->cGenerator($scheme));
                $sql .= ")";

                if(!$this->query($sql)){
                    return false;
                }
                return true;
            }catch (Exception $e){
                return false;
            }
        }

        return false;

    }

    /**
     * Creating a column.
     *
     * @param $tblName
     * @param $scheme
     * @return bool
     */
    public function columnCreate($tblName, $scheme){

        if($this->is_table($tblName)){

            try{

                $sql = "ALTER TABLE";
                $sql .= " ".$tblName." ";
                $sql .= implode(',', $this->cGenerator($scheme, 'columnCreate'));

                if(!$this->query($sql)){
                    return false;
                } else {
                    return true;
                }

            }catch (Exception $e){
                return false;
            }
        }

        return false;
    }

    /**
     * Delete database.
     *
     * @param $dbName
     * @return bool
     */
    public function dbDelete($dbName){

        $dbNames = array();

        if(is_array($dbName)){
            foreach ($dbName as $key => $value) {
                $dbNames[] = $value;
            }
        } else {
            $dbNames[] = $dbName;
        }
        foreach ($dbNames as $dbName) {

            if(!$this->is_db($dbName)){

                return false;

            }

            try{

                $sql = "DROP DATABASE";
                $sql .= " ".$dbName;

                $query = $this->query($sql);
                if(!$query){
                    return false;
                }
            }catch (Exception $e){
                return false;
            }

        }
        return true;
    }

    /**
     * Table delete.
     *
     * @param $tblName
     * @return bool
     */
    public function tableDelete($tblName){

        $tblNames = array();

        if(is_array($tblName)){
            foreach ($tblName as $key => $value) {
                $tblNames[] = $value;
            }
        } else {
            $tblNames[] = $tblName;
        }
        foreach ($tblNames as $tblName) {

            if(!$this->is_table($tblName)){

                return false;

            }

            try{

                $sql = "DROP TABLE";
                $sql .=" ".$tblName;

                $query = $this->query($sql);
                if(!$query){
                    return false;
                }
            }catch (Exception $e){
                return false;
            }
        }
        return true;
    }

    /**
     * Column delete.
     *
     * @param $tblName
     * @param $column
     * @return bool
     */
    public function columnDelete($tblName, $column){

        $columns = array();

        if(is_array($column)){
            foreach ($column as $col) {
                $columns[] = $col;
            }
        } else {
            $columns[] = $column;
        }
        foreach ($columns as $column) {

            if(!$this->is_column($tblName, $column)){

                return false;

            }

            try{

                $sql = "ALTER TABLE";
                $sql .= " ".$tblName." DROP COLUMN ".$column;

                $query = $this->query($sql);
                if(!$query){
                    return false;
                }
            }catch (Exception $e){
                return false;
            }
        }
        return true;
    }

    /**
     * Clear database.
     *
     * @param mixed   $dbName
     * @return bool
     * */
    public function dbClear($dbName){

        $dbNames = array();

        if(is_array($dbName)){
            foreach ($dbName as $db) {
                $dbNames[] = $db;
            }
        } else {
            $dbNames[] = $dbName;
        }

        foreach ( $dbNames as $dbName ) {

            $this->selectDB($dbName);
            foreach ($this->tableList($dbName) as $tblName){
                if(!$this->tableClear($tblName)){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Clear table.
     *
     * @param $tblName
     * @return bool
     */
    public function tableClear($tblName){

        $tblNames = array();

        if(is_array($tblName)){
            foreach ($tblName as $value) {
                $tblNames[] = $value;
            }
        } else {
            $tblNames[] = $tblName;
        }

        foreach ($tblNames as $tblName) {

            $sql = 'TRUNCATE '.$tblName;

            try{
                if($this->query($sql)){
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e){
                return false;
            }

        }
        return true;
    }

    /**
     * Clear column.
     *
     * @param $tblName
     * @param null $column
     * @return bool
     */
    public function columnClear($tblName, $column=null){

        if(empty($column)){
            return false;
        }

        $columns = array();

        if(is_array($column)){
            foreach ($column as $col) {
                $columns[] = $col;
            }
        } else {
            $columns[] = $column;
        }

        $columns = array_intersect($columns, $this->columnList($tblName));

        foreach ($columns as $column) {

            $id   = $this->increments($tblName);
            $data = $this->getData($tblName);

            foreach ($data as $row) {
                $values = array(
                    $column => ''
                );
                $this->update($tblName, $values, $row[$id]);
            }
        }

        return true;

    }

    /**
     * Add new record.
     *
     * @param $tblName
     * @param $values
     * @return bool
     */
    public function insert($tblName, $values){

        if(!is_array($values)){
            return false;
        }

        if(!empty($values[0])){
            foreach ($values as $key => $row){
                if(!$this->insert($tblName, $row)){
                    return false;
                }
            }
        } else {

            $xColumns = array_keys($values);

            $columns = $this->columnList($tblName);

            $prepareArray = array();
            foreach ( $xColumns as $col ) {

                if(!in_array($col, $columns)){
                    return false;
                }

                $prepareArray[] = $col.'=?';
            }

            $values = array_values($values);

            $sql = implode(',', $prepareArray);

            try{

                $query = $this->prepare("INSERT INTO".' '.$tblName.' SET '.$sql);
                $query->execute($values);
                return true;

            }catch (Exception $e){
                echo $e->getMessage();
                return false;
            }

        }

        return true;
    }

    /**
     * Record update.
     *
     * @param $tblName
     * @param $values
     * @param $needle
     * @param null $column
     * @return bool
     */
    public function update($tblName, $values, $needle, $column=null){

        if(empty($column)){

            $column = $this->increments($tblName);

            if(empty($column)){
                return false;
            }

        }

        $xColumns = array_keys($values);

        $columns = $this->columnList($tblName);

        $prepareArray = array();
        foreach ( $xColumns as $col ) {

            if(!in_array($col, $columns)){
                return false;
            }

            $prepareArray[] = $col.'=?';
        }

        $values[$column] = $needle;

        $values = array_values($values);

        $sql = implode(',', $prepareArray);
        $sql .= ' WHERE '.$column.'=?';
        try{
            if($this->do_have($tblName, $needle, $column)){

                $query = $this->prepare("UPDATE".' '.$tblName.' SET '.$sql);
                $query->execute($values);
                return true;
            } else {
                return false;
            }

        }catch (Exception $e){
            echo $e->getMessage();
            return false;
        }

    }

    /**
     * Record delete.
     *
     * @param $tblName
     * @param $needle
     * @param null $column
     * @return bool
     */
    public function delete($tblName, $needle, $column=null){

        if(empty($column)){

            $column = $this->increments($tblName);

            if(empty($column)){
                return false;
            }

        }

        if(is_array($needle)){

            foreach ($needle as $value) {
                if(!$this->delete($tblName, $value, $column)){
                    return false;
                }
            }

            return true;

        } else {

            $sql = 'WHERE '.$column.'=?';
            try{
                if($this->do_have($tblName, $needle, $column)){

                    $query = $this->prepare("DELETE FROM".' '.$tblName.' '.$sql);
                    $query->execute(array($needle));
                    return true;
                } else {
                    return false;
                }

            }catch (Exception $e){
                return false;
            }
        }
    }

    /**
     * Record reading.
     *
     * @param $tblName
     * @param null $options
     * @return  mixed
     */
    public function getData($tblName, $options=null){

        $sql = '';
        $columns = $this->columnList($tblName);

        if(!empty($options['column'])){

            if(!is_array($options['column'])){
                $options['column']= array($options['column']);
            }

            $options['column'] = array_intersect($options['column'], $columns);
            $columns = array_values($options['column']);

            $sqlColumns = $tblName.'.'.implode(', '.$tblName.'.', $columns);

        } else {
            $sqlColumns = $tblName.'.'.implode(', '.$tblName.'.', $columns);
        }

        $prepareArray = array();
        $executeArray = array();

        if(!empty($options['search']['keyword'])){

            if ( !is_array($options['search']['keyword']) ) {
                $keyword = array($options['search']['keyword']);
            } else {
                $keyword = $options['search']['keyword'];
            }

            $searchColumns = $columns;
            if(!empty($options['search']['column'])){

                if(!is_array($options['search']['column'])){
                    $searchColumns = array($options['search']['column']);
                }

                $searchColumns = array_intersect($searchColumns, $columns);
            }

            foreach ( $searchColumns as $column ) {

                foreach ( $keyword as $value ) {
                    $prepareArray[] = $column.' LIKE ?';
                    $executeArray[] = $value;
                }

            }

            $sql = 'WHERE '.implode(' OR ', $prepareArray);
        }


        $searchType = ' OR ';
        if(!empty($options['search']['or']) AND is_array($options['search']['or'])){
            $searchType = ' OR ';

            foreach ($options['search']['or'] as $column => $value) {

                $prepareArray[] = $column.' LIKE ?';
                $executeArray[] = $value;
            }

        }

        if(!empty($options['search']['and']) AND is_array($options['search']['and'])){
            $searchType = ' AND ';

            foreach ($options['search']['and'] as $column => $value) {

                $prepareArray[] = $column.' LIKE ?';
                $executeArray[] = $value;
            }

        }

        if(
            !empty($options['search']['or']) AND is_array($options['search']['or']) OR
            !empty($options['search']['and']) AND is_array($options['search']['and'])
        ){

            $sql = 'WHERE '.implode($searchType, $prepareArray);
        }

        if(!empty($options['sort'])){

            list($columnName, $sort) = explode(':', $options['sort']);
            if(in_array($sort, array('asc','desc'))){
                $sql .= ' ORDER BY '.$columnName.' '.strtoupper($sort);
            }

        }

        if(!empty($options['limit'])){

            if(!empty($options['limit']['start']) AND $options['limit']['start']>0){
                $start = $options['limit']['start'].',';
            } else {
                $start = '0,';
            }

            if(!empty($options['limit']['end']) AND $options['limit']['end']>0){
                $end = $options['limit']['end'];
            } else {
                $end     = $this->newId($tblName)-1;
            }

            $sql .= ' LIMIT '.$start.$end;

        }

        $result = array();
        try{

            $query = $this->prepare('SELECT '.$sqlColumns.' FROM '.$tblName.' '.$sql);
            $query->execute($executeArray);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if(isset($options['format'])){
                switch ($options['format']) {

                    case 'json':
                        $result = json_encode($result);
                        break;
                }
            }

            return $result;

        }catch (Exception $e){
            return $result;
        }

    }

    /**
     * Research assistant.
     *
     * @param $tblName
     * @param $map
     * @param null $column
     * @return mixed
     */
    public function samantha($tblName, $map, $column=null)
    {

        $scheme['search']['and'] = $map;

        if (!empty($column)) {
            $scheme['column'] = $column;
        }

        $output = $this->getData($tblName, $scheme);

        if (count($output) > 1) {
            return $output;
        } else {
            $columns = array_keys($output[0]);

            if(count($columns) > 1){
                return $output[0];
            } else {
                $column = $columns[0];
                return $output[0][$column];
            }
        }

    }

    /**
     * Entity verification.
     *
     * @param $tblName
     * @param $value
     * @param null $column
     * @return bool
     */
    public function do_have($tblName, $value, $column=null){

        if(!empty($tblName) AND !empty($value)){

            if(!is_array($value)){
                $options = array(
                    'search'=> array(
                        'keyword' => $value
                    )
                );
                if(!empty($column)){
                    $options = array(
                        'search' =>array(
                            'keyword' => $value,
                            'column' => $column
                        )
                    );
                }
            } else {
                $options = array(
                    'search' =>array(
                        'and'=> $value
                    )
                );
            }

            $data = $this->getData($tblName, $options);

            if(!empty($data)){
                return true;
            }
        }
        return false;
    }

    /**
     * New id parameter.
     *
     * @param $tblName
     * @return int
     */
    public function newId($tblName){

        $sql = 'SHOW TABLE STATUS LIKE \''.$tblName.'\'';

        try{

            $query = $this->query($sql, PDO::FETCH_ASSOC);

            $result = 0;
            foreach ( $query as $item ) {
                $result = $item['Auto_increment'];
            }

            if(empty($result)){
                return 0;
            } else {
                return $result+1;
            }
        }catch (Exception $e){
            return 0;
        }

    }

    /**
     * Auto increment column.
     *
     * @param string   $tblName
     * @return string
     * */
    public function increments($tblName){

        $columns = '';
        $sql = 'SHOW COLUMNS FROM ' . $tblName;

        try{
            $query = $this->query($sql, PDO::FETCH_ASSOC);

            foreach ( $query as $column ) {

                if($column['Extra'] == 'auto_increment'){
                    $columns = $column['Field'];
                }
            }

            return $columns;

        } catch (Exception $e){
            return $columns;
        }

    }

    /**
     * Database verification.
     *
     * @param string   $dbName
     * @return  bool
     * */
    public function is_db($dbName){

        $sql     = 'SHOW DATABASES';

        try{
            $query = $this->query($sql, PDO::FETCH_ASSOC);

            $dbNames = array();

            if ( $query->rowCount() ){
                foreach ( $query as $item ) {
                    $dbNames[] = $item['Database'];
                }
            }

            return in_array($dbName, $dbNames) ? true : false;

        } catch (Exception $e){
            return false;
        }

    }

    /**
     * Table verification.
     *
     * @param $tblName
     * @return  bool
     */
    public function is_table($tblName){

        $sql     = 'DESCRIBE '.$tblName;

        try{
            return $this->query($sql, PDO::FETCH_NUM);
        } catch (Exception $e){
            return false;
        }

    }

    /**
     * Column verification.
     *
     * @param string   $tblName
     * @param string   $column
     * @return  bool
     * */
    public function is_column($tblName, $column){

        $sql = 'SHOW COLUMNS FROM ' . $tblName;

        try{
            $query = $this->query($sql, PDO::FETCH_NAMED);

            $columns = array();

            foreach ( $query as $item ) {
                $columns[] = $item['Field'];
            }

            return in_array($column, $columns) ? true : false;

        } catch (Exception $e){
            return false;
        }
    }

    /**
     * Phone verification.
     *
     * @param string   $str
     * @return  bool
     * */
    public function is_phone($str){

        return preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', implode('', explode(' ', $str))) ? true : false;

    }

    /**
     * Date verification.
     *
     * @param string   $date
     * @param string   $format
     * @return  bool
     * */
    public function is_date($date, $format = 'd-m-Y H:i:s'){

        $d = DateTime::createFromFormat($format, $date);

        return $d->format($format) == $date AND $d ? true : false;
    }

    /**
     * Mail verification.
     *
     * @param $email
     * @return  bool
     */
    public function is_email($email){

        if ( filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Type verification.
     *
     * @param $fileName
     * @param mixed $type
     * @return  bool
     */
    public function is_type($fileName, $type){

        if( !empty($type) AND !is_array($fileName) ){

            $exc = $this->info($fileName, 'extension');

            if(!is_array($type)){
                $type = array($type);
            }

            return in_array($exc, $type) ? true : false;
        }
        return false;
    }

    /**
     * Size verification.
     *
     * @param mixed   $str
     * @param mixed   $size
     * @return  bool
     * */
    public function is_size($str, $size){

        $byte = 1024;
        $sizeLibrary = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

        if( ctype_digit($str) AND !is_array($str) ){
            $str = array("size"=>$str);
        }

        if(is_array($str) AND !empty($size) AND strstr($size, ' ')){

            if(count(explode(' ', $size))!=2){
                return false;
            }

            list($number, $format) = explode(' ', $size);

            if(in_array($format, $sizeLibrary)){

                $id = array_search($format, $sizeLibrary);
                $calc = $number*pow($byte, $id);

                if($str['size']<$calc){
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Color verification.
     *
     * @param string   $color
     * @return  bool
     * */
    public function is_color($color){

        $colorArray = json_decode('["AliceBlue","AntiqueWhite","Aqua","Aquamarine","Azure","Beige","Bisque","Black","BlanchedAlmond","Blue","BlueViolet","Brown","BurlyWood","CadetBlue","Chartreuse","Chocolate","Coral","CornflowerBlue","Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed ","Indigo ","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","RebeccaPurple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen"]', true);

        if(in_array($color, $colorArray)){
            return true;
        }

        if($color == 'transparent'){
            return true;
        }

        if(preg_match('/^#[a-f0-9]{6}$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        if(preg_match('/^rgb\((?:\s*\d+\s*,){2}\s*[\d]+\)$/', mb_strtolower($color, 'utf-8'))) {
            return true;
        }

        if(preg_match('/^rgba\((\s*\d+\s*,){3}[\d\.]+\)$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        if(preg_match('/^hsl\(\s*\d+\s*(\s*\,\s*\d+\%){2}\)$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        if(preg_match('/^hsla\(\s*\d+(\s*,\s*\d+\s*\%){2}\s*\,\s*[\d\.]+\)$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        return false;
    }

    /**
     * URL verification.
     *
     * @param string   $url
     * @return  bool
     * */
    public function is_url($url){

        if(!strstr($url, '://') AND !strstr($url, 'www.')){
            $url = 'http://www.'.$url;
        }

        if(!strstr($url, '://') AND strstr($url, 'www.')){
            $url = 'http://'.$url;
        }

        if(strstr($url, '://') AND !strstr($url, 'www')){
            list($left, $right) = explode('://', $url);
            $url = $left.'://www.'.$right;
        }

        return preg_match('/^(http|https|www):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $url) ? true : false;

    }

    /**
     * Json control of a string
     *
     * @param $scheme
     * @return bool
     */
    public function is_json($scheme){

        if(is_null($scheme) OR is_array($scheme)) {
            return false;
        }

        if(json_decode($scheme)){
            return true;
        }

        return false;
    }

    /**
     * Path information.
     *
     * @param $fileName
     * @param string $type
     * @return  string
     */
    public function info($fileName, $type){

        $object = pathinfo($fileName);

        if($type == 'extension'){
            return strtolower($object[$type]);
        }

        return $object[$type];
    }

    /**
     * Protection from pests.
     *
     * @param mixed   $str
     * @return  mixed
     * */
    public function filter($str){

        if(is_array($str)){
            $x = array();
            foreach ($str as $key => $value) {
                $x[] = $this->filter($value);
            }
            return $x;
        } else {

            $str = filter_var($str,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\\$0', $str);
        }

    }

    /**
     * Request collector
     *
     * @return mixed
     */
    public function request(){

        if(isset($_POST) OR isset($_GET) OR isset($_FILES)){

            foreach (array_merge($_POST, $_GET, $_FILES) as $name => $value) {

                if(is_array($value)){
                    foreach($value as $key => $all ){

                        if(is_array($all)){
                            foreach($all as $i => $val ){
                                $this->post[$name][$i][$key] = $this->filter($val);
                            }
                        } else {
                            $this->post[$name][$key] = $this->filter($all);
                        }
                    }
                } else {
                    $this->post[$name] = $this->filter($value);
                }
            }
        }

        return $this->post;
    }

    /**
     * Redirect
     *
     * @param null $url
     */
    public function redirect($url=null){

        if(empty($url)){
            $url = $this->base_url;
        } else {
            if(!$this->is_url($url)){
                $url = $this->base_url.$url;
            }
        }

        header('Location: '.$url);
        exit();
    }

    /**
     * Permanent connection.
     *
     * @param $str
     * @param array $options
     * @return mixed|string|string[]|null
     */
    public function permalink($str, $options = array()){

        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true
        );

        $char_map = [

            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ğ' => 'g',

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 'Ū' => 'u',
            'ā' => 'a', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n', 'ū' => 'u',
        ];

        $replacements = array();

        if(!empty($options['replacements']) AND is_array($options['replacements'])){
            $replacements = $options['replacements'];
        }

        if(!empty($options['transliterate']) AND !$options['transliterate']){
            $char_map = array();
        }

        $options['replacements'] = array_merge($replacements, $char_map);

        if(!empty($options['replacements']) AND is_array($options['replacements'])){
            foreach ($options['replacements'] as $objName => $val) {

                $str = str_replace($objName, $val, $str);

            }
        }

        $options = array_merge($defaults, $options);

        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
        $str = trim($str, $options['delimiter']);
        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;

    }

    /**
     * Time zones.
     *
     * @return array|false
     */
    public function timezones(){
        return timezone_identifiers_list();
    }

    /**
     * Session checking.
     *
     * @return bool
     */
    public function session_check(){

        if($this->sess_set['status_session']){

            if($this->sess_set['path_status']){

                if(!is_dir($this->sess_set['path'])){

                    mkdir($this->sess_set['path']); chmod($this->sess_set['path'], 755);
                    $this->write('deny from all', $this->sess_set['path'].'/.htaccess');
                    chmod($this->sess_set['path'].'/.htaccess', 644);
                }

                ini_set(
                    'session.save_path',
                    realpath(
                        dirname(__FILE__)
                    ).'/'.$this->sess_set['path']
                );
            }

            if(!isset($_SESSION)){
                session_start();
            }

        }

        return false;
    }

    /**
     * Learns the size of the remote file.
     *
     * @param $url
     * @return int|mixed
     */
    public function remoteFileSize($url){
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);

        curl_exec($ch);

        $response_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        curl_close($ch);

        if(!in_array($response_code, array('200'))){
            return -1;
        }
        return $size;
    }

    /**
     * Layer installer.
     *
     * @param $file
     * @param null $cache
     */
    public function mindLoad($file, $cache=null){

        $fileExt = '.php';

        if (!empty($cache) AND !is_array($cache)) {
            $cache = array($cache);
        }

        if (!empty($cache)) {
            foreach ($cache as $cacheFile) {

                $cacheExplode = $this->pGenerator($cacheFile);
                if (!empty($cacheExplode['name'])){

                    $cacheFile = $cacheExplode['name'];
                    $fileName = basename($cacheExplode['name']);

                    if (empty($cacheFile)){
                        $cacheFile = '';
                    }

                    if (file_exists($cacheFile . $fileExt)) {

                        /*
                         * PHPSTORM: In Settings search for 'unresolved include' which is under
                         * Editor > Inspections; PHP > General > Unresolved include and uncheck the box.
                         * */
                        require_once($cacheFile . $fileExt);

                        if (class_exists($fileName)){
                            if (!empty($cacheExplode['params'])){

                                $ClassName = new $fileName();
                                $funcList = get_class_methods($fileName);

                                foreach ($cacheExplode['params'] as $param) {

                                    if (in_array($param, $funcList)){
                                        $ClassName->$param();
                                    }

                                }
                            }
                        }
                    }
                }
            }
        }

        if(!empty($file)){

            if(!is_array($file)){
                $files = array($file);
            } else {
                $files = $file;
            }

            foreach ($files as $file){

                if (file_exists($file . $fileExt)) {
                    require_once($file . $fileExt);
                }
            }
        }
    }

    /**
     * Column sql syntax creator.
     *
     * @param $scheme
     * @param null $funcName
     * @return array
     */
    public function cGenerator($scheme, $funcName=null){

        $sql = array();

        foreach (array_values($scheme) as $array_value) {

            $colonParse = array();
            if(strstr($array_value, ':')){
                $colonParse = array_filter(explode(':', trim($array_value, ':')));
            }

            $columnValue = null;
            $columnType = null;

            if(count($colonParse)==3){
                list($columnName, $columnType, $columnValue) = $colonParse;
            }elseif (count($colonParse)==2){
                list($columnName, $columnType) = $colonParse;
            } else {
                $columnName = $array_value;
                $columnType = 'small';
            }

            if(is_null($columnValue) AND $columnType =='string'){ $columnValue = 255; }
            if(is_null($columnValue) AND $columnType =='decimal') { $columnValue = 6.2; }
            if(is_null($columnValue) AND $columnType =='int' OR $columnType =='increments'){ $columnValue = 11; }

            $first = '';
            $prefix = '';
            if(!is_null($funcName) AND $funcName == 'columnCreate'){
                $first = 'FIRST';
                $prefix = 'ADD COLUMN ';
            }

            switch ($columnType){
                case 'int':
                    $sql[] = $prefix.$columnName.' int('.$columnValue.')';
                    break;
                case 'decimal':
                    $sql[] = $prefix.$columnName.' DECIMAL('.$columnValue.')';
                    break;
                case 'string':
                    $sql[] = $prefix.$columnName.' VARCHAR('.$columnValue.')';
                    break;
                case 'small':
                    $sql[] = $prefix.$columnName.' TEXT';
                    break;
                case 'medium':
                    $sql[] = $prefix.$columnName.' MEDIUMTEXT';
                    break;
                case 'large':
                    $sql[] = $prefix.$columnName.' LONGTEXT';
                    break;
                case 'increments':
                    $sql[] = $prefix.$columnName.' int('.$columnValue.') UNSIGNED AUTO_INCREMENT PRIMARY KEY '.$first;
                    break;
            }
        }

        return $sql;
    }

    /**
     * Parameter parser.
     *
     * @param null $str
     * @return array
     */
    public function pGenerator($str=null){

        $Result = array();
        if(!is_null($str)){

            if(strstr($str, ':')){
                $strExplode = array_filter(explode(':', trim($str, ':')));
                if(count($strExplode) == 2){
                    list($filePath, $funcPar) = $strExplode;
                    $Result['name'] = $filePath;

                    if(strstr($funcPar, '@')){
                        $funcExplode = array_filter(explode('@', trim($funcPar, '@')));
                    } else {
                        $funcExplode = array($funcPar);
                    }
                    if(!empty($funcExplode)){
                        $Result['params'] = $funcExplode;
                    }
                }
            } else {
                $Result['name'] = $str;
            }
        }
        return $Result;
    }

    /**
     * Routing manager.
     *
     * @param $uri
     * @param $file
     * @param null $cache
     * @return bool
     */
    public function route($uri, $file, $cache=null){
        $public_htaccess = implode("\n", array(
            'RewriteEngine On',
            'RewriteCond %{REQUEST_FILENAME} -s [OR]',
            'RewriteCond %{REQUEST_FILENAME} -l [OR]',
            'RewriteCond %{REQUEST_FILENAME} -d',
            'RewriteRule ^.*$ - [NC,L]',
            'RewriteRule ^.*$ index.php [NC,L]'
        ));

        $private_htaccess = "Deny from all";
        $htaccess_file = '.htaccess';

        if(!file_exists($htaccess_file)){
            $this->write($public_htaccess, $htaccess_file);
        }

        $dirs = array_filter(glob('*'), 'is_dir');

        if(!empty($dirs)){
            foreach ($dirs as $dir){

                if(!file_exists($dir.'/'.$htaccess_file)){
                    $this->write($private_htaccess, $dir.'/'.$htaccess_file);
                }

            }
        }

        if(empty($file)){
            return false;
        }

        $request = str_replace($this->base_url, '', $_SERVER['REQUEST_URI']);
        $fields     = array();

        if(!empty($uri)){

            $uriData = $this->pGenerator($uri);
            if(!empty($uriData['name'])){
                $uri = $uriData['name'];
            }
            if(!empty($uriData['params'])){
                $fields = $uriData['params'];
            }
        }

        if($uri == '/'){
            $uri = $this->base_url;
        }

        $params = array();

        if(strstr($request, '/')){

            $step1 = str_replace($uri, '', $request);
            $step2 = explode('/', trim($step1,'/'));
            $step3 = array_filter($step2, 'is_string');
            $params = array_values($step3);
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            $this->post = array();

            if(!empty($fields)){

                foreach ($fields as $key => $field) {

                    if(!empty($params[$key]) OR $params[$key] == '0'){
                        $this->post[$field] = $params[$key];
                    }
                }
            } else {
                $this->post = array_diff($params, array('', ' '));
            }
        }

        if(!empty($request)){

            if(!empty($params)){
                $uri .='/'.implode('/', $params);
            }

            if($request == $uri OR trim($request, '/') == trim($uri, '/')){
                $this->error_status = false;
                $this->mindLoad($file, $cache);
                exit();
            }

            $this->error_status = true;

        } else {
            if($uri == $this->base_url) {
                $this->error_status = false;
                $this->mindLoad($file, $cache);
                exit();
            }

        }
        return false;
    }

    /**
     * File writer.
     *
     * @param $data
     * @param $filePath
     * @param string $delimiter
     * @return bool
     */
    public function write($data, $filePath, $delimiter=':') {

        if(is_array($data)){
            $content    = implode($delimiter, $data);
        } else {
            $content    = $data;
        }

        if(isset($content)){

            $fileName        = fopen($filePath, "a+");
            fwrite($fileName, $content."\r\n");
            fclose($fileName);

            return true;
        }

        return false;
    }

    /**
     * File uploader.
     *
     * @param $files
     * @param $path
     * @return array
     */
    public function upload($files, $path){

        $result = array();

        if(isset($files['name'])){
            $files = array($files);
        }

        foreach ($files as $file) {

            #Path syntax correction for Windows.
            $tmp_name = str_replace('\\\\', '\\', $file['tmp_name']);
            $file['tmp_name'] = $tmp_name;

            $xtime      = gettimeofday();
            $xdat       = date('d-m-Y g:i:s').$xtime['usec'];
            $ext        = $this->info($file['name'], 'extension');
            $newpath    = $path.'/'.md5($xdat).'.'.$ext;

            move_uploaded_file($file['tmp_name'], $newpath);

            $result[]   = $newpath;

        }

        return $result;
    }

    /**
     * File downloader.
     *
     * @param $links
     * @param null $opt
     * @return array
     */
    public function download($links, $opt = null)
    {

        $result = array();
        $nLinks = array();

        if(empty($links)){
            return $result;
        }

        if(!is_array($links)){
            $links = array($links);
        }

        foreach($links as $link) {

            if($this->is_url($link)){
                if($this->remoteFileSize($link)>1){
                    $nLinks[] = $link;
                }
            }

            if(!$this->is_url($link)){
                if(!strstr($link, '://')){

                    if(file_exists($link)){
                        $nLinks[] = $link;
                    }

                }
            }

        }

        if(count($nLinks) != count($links)){
            return $result;
        }

        $path = '';
        if(!empty($opt['path'])){
            $path .= $opt['path'];

            if(!is_dir($path)){
                mkdir($path, 0777, true);
            }
        } else {
            $path .= './download';
        }

        foreach ($nLinks as $nLink) {
            $link_path = parse_url($this->info($nLink, 'dirname'));

            $destination = $path;

            if(isset($link_path['path'])){
                $destination .= urldecode($link_path['path']);
            }

            $other_path = urldecode($this->info($nLink, 'basename'));

            if(!is_null($this->remoteFileSize($destination.'/'.$other_path))){

                if(!is_dir($destination)){
                    mkdir($destination, 0777, true);
                }

                copy($nLink, $destination.'/'.$other_path);

            } else {
                return $result;
            }

            if(file_exists($destination.'/'.$other_path)){

                $remote_file = $this->remoteFileSize($nLink);
                $local_file = filesize($destination.'/'.$other_path);
    
                if($remote_file != $local_file){
                    unlink($destination.'/'.$other_path);
                    copy($nLink, $destination.'/'.$other_path);

                }
            }

            $result[] = $destination.'/'.$other_path;
        }

    return $result;
    }

    /**
     * Content researcher.
     *
     * @param $left
     * @param $right
     * @param $url
     * @return array
     */
    public function get_contents($left, $right, $url){

        $result = array();

        if($this->is_url($url)) {

            $arrContextOptions = stream_context_create(array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                )
            ));

            $data = file_get_contents($url, false, $arrContextOptions);
        } else {

            $data = $url;
        }

        $content = str_replace(array("\n", "\r", "\t"), '', $data);

        if(preg_match_all('/'.preg_quote($left, '/').'(.*?)'.preg_quote($right, '/').'/i', $content, $result)){

            if(!empty($result)){
                return array_unique($result[1]);
            } else {
                return $result;
            }
        }

        return $result;
    }

}
