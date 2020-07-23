<?php

/**
 *
 * @package    Mind
 * @version    Release: 3.1.5
 * @license    GPL3
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
    public  $page_current   =   '';
    public  $page_back      =   '';
    public  $timezone       =  'Europe/Istanbul';
    public  $timestamp;
    public  $error_status   =  false;
    public  $error_file     =  'app/views/errors/404';
    public  $errors         =  array();

    /**
     * Mind constructor.
     * @param array $conf
     */
    public function __construct($conf=array()){
        ob_start();
        if(isset($conf['host'])){
            $this->host = $conf['host'];
        }

        if(isset($conf['dbname'])){
            $this->dbName = $conf['dbname'];
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

        if(strpos(ini_get('disable_functions'), 'set_time_limit') === false){
            set_time_limit(0);
        }

        ini_set('memory_limit', '-1');

        date_default_timezone_set($this->timezone);
        $this->timestamp = date("Y-m-d H:i:s");

        $baseDir = $this->get_absolute_path(dirname($_SERVER['SCRIPT_NAME']));

        if(empty($baseDir)){
            $this->base_url = '/';
        } else {
            $this->base_url = '/'.$baseDir.'/';
        }

        if(isset($_SERVER['HTTP_REFERER'])){
            $this->page_back = $_SERVER['HTTP_REFERER'];
        } else {
            $this->page_back = $this->page_current;
        }
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
     * @param string $dbName
     * @return bool
     */
    public function selectDB($dbName){
        if($this->is_db($dbName)){
            $this->exec("USE ".$dbName);
            return true;
        } else {
            return false;
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
     * @param string $dbName
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
     * @param string $tblName
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
     * @param mixed $dbName
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
     * @param string $tblName
     * @param array $scheme
     * @return bool
     */
    public function tableCreate($tblName, $scheme){

        if(is_array($scheme) AND !$this->is_table($tblName)){

            try{

                $sql = "CREATE TABLE `".$tblName."` ";
                $sql .= "(\n\t";
                $sql .= implode(",\n\t", $this->cGenerator($scheme));
                $sql .= "\n) ENGINE = INNODB;";

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
     * @param string $tblName
     * @param array $scheme
     * @return bool
     */
    public function columnCreate($tblName, $scheme){

        if($this->is_table($tblName)){

            try{

                $sql = "ALTER TABLE\n";
                $sql .= "\t`".$tblName."`\n";
                $sql .= implode(",\n\t", $this->cGenerator($scheme, 'columnCreate'));

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
     * @param mixed $dbName
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
     * @param mixed $tblName
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
     * @param string $tblName
     * @param mixed $column
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
     * @param mixed $dbName
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
     * @param mixed $tblName
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
     * @param string $tblName
     * @param mixed $column
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
     * @param string $tblName
     * @param array $values
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
     * @param string $tblName
     * @param array $values
     * @param string $needle
     * @param mixed $column
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
     * @param string $tblName
     * @param mixed $needle
     * @param mixed $column
     * @return bool
     */
    public function delete($tblName, $needle, $column=null){

        if(empty($column)){

            $column = $this->increments($tblName);

            if(empty($column)){
                return false;
            }

        }

        if(is_array($column) AND !empty($needle)){

            $colName = $this->increments($tblName);

            if(empty($colName)){
                return false;
            }

            if(!$this->delete($tblName, $needle, $colName)){
                return false;
            }

            foreach ($column as $table => $item) {
                if(!$this->delete($table, $needle, $item)){
                    return false;
                }
            }
            return true;
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
     * @param string $tblName
     * @param array $options
     * @return array
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
            if(in_array($sort, array('asc', 'ASC', 'desc', 'DESC'))){
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
     * @param string $tblName
     * @param array $map
     * @param mixed $column
     * @return array
     */
    public function samantha($tblName, $map, $column=null)
    {

        $scheme['search']['and'] = $map;

        if (!empty($column)) {
            $scheme['column'] = $column;
        }

        $output = $this->getData($tblName, $scheme);

        if(isset($output[0]) AND count($output)==1){
            if(!empty($column)){
                if($this->is_column($tblName, $column)){
                    $output = $output[0][$column];
                } else {
                    $output = $output[0];
                }
            } else {
                $output = $output[0];
            }
        }

        return $output;
    }

    /**
     * Entity verification.
     *
     * @param string $tblName
     * @param mixed $value
     * @param mixed $column
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
     * @param string $tblName
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
     * @param string $tblName
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
     * @param string $dbName
     * @return bool
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
     * @param string $tblName
     * @return bool
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
     * @param string $tblName
     * @param string $column
     * @return bool
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
     * @param string $str
     * @return bool
     * */
    public function is_phone($str){

        return preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', implode('', explode(' ', $str))) ? true : false;

    }

    /**
     * Date verification.
     *
     * @param string $date
     * @param string $format
     * @return bool
     * */
    public function is_date($date, $format = 'Y-m-d H:i:s'){

        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Mail verification.
     *
     * @param string $email
     * @return bool
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
     * @param string $fileName
     * @param mixed $type
     * @return bool
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
     * @param mixed $str
     * @param string $size
     * @return bool
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
     * @param string  $color
     * @return bool
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
     * @param string $url
     * @return bool
     */
    public function is_url($url=null){

        if(!is_string($url)){
            return false;
        }

        $temp_string = (!preg_match('#^(ht|f)tps?://#', $url)) // check if protocol not present
            ? 'http://' . $url // temporarily add one
            : $url; // use current

        if ( filter_var($temp_string, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * HTTP checking.
     *
     * @param string $url
     * @return bool
     */
    public function is_http($url){
        if (substr($url, 0, 7) == "http://"){
            return true;
        } else {
            return false;
        }
    }

    /**
     * HTTPS checking.
     * @param string $url
     * @return bool
     */
    public function is_https($url){
        if (substr($url, 0, 8) == "https://"){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Json control of a string
     *
     * @param string $scheme
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
     * is_age
     * @param $date
     * @param $age
     * 
     * @return bool
     * 
     */
    public function is_age($date, $age){
        
        $today = date("Y-m-d");
        $diff = date_diff(date_create($date), date_create($today));

        if($age >= $diff->format('%y')){
            return true;
        } else {
            return false;
        }
    }

    /**
     * International Bank Account Number verification
     *
     * @params string $iban
     * @param $iban
     * @return bool
     */
    public function is_iban($iban){
        // Normalize input (remove spaces and make upcase)
        $iban = strtoupper(str_replace(' ', '', $iban));

        if (preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/', $iban)) {
            $country = substr($iban, 0, 2);
            $check = intval(substr($iban, 2, 2));
            $account = substr($iban, 4);

            // To numeric representation
            $search = range('A','Z');
            foreach (range(10,35) as $tmp)
                $replace[]=strval($tmp);
            $numstr = str_replace($search, $replace, $account.$country.'00');

            // Calculate checksum
            $checksum = intval(substr($numstr, 0, 1));
            for ($pos = 1; $pos < strlen($numstr); $pos++) {
                $checksum *= 10;
                $checksum += intval(substr($numstr, $pos,1));
                $checksum %= 97;
            }

            return ((98-$checksum) == $check);
        } else
            return false;
    }

    /**
     * ipv4 verification
     *
     * @params string $ip
     * @return bool
     */
    public function is_ipv4($ip){
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * ipv6 verification
     *
     * @params string $ip
     * @return bool
     */
    public function is_ipv6($ip){
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Blood group verification
     *
     * @param $blood
     * @param string $needle
     * @return bool
     */
    public function is_blood($blood, $needle = null){

        $bloods = array(
            'AB+'=> array(
                'AB+', 'AB-', 'B+', 'B-', 'A+', 'A-', '0+', '0-'
            ),
            'AB-'=> array(
                'AB-', 'B-', 'A-', '0-'
            ),
            'B+'=> array(
                'B+', 'B2-', '0+', '0-'
            ),
            'B-'=> array(
                'B-', '0-'
            ),
            'A+'=> array(
                'A+', 'A-', '0+', '0-'
            ),
            'A-'=> array(
                'A-', '0-'
            ),
            '0+'=> array(
                '0+', '0-'
            ),
            '0-'=> array(
                '0-'
            )
        );

        $map = array_keys($bloods);

        //  hasta ve varsa donör parametreleri filtreden geçirilir
        $blood = str_replace(array('RH', ' '), '', mb_strtoupper($blood));
        if(!is_null($needle)) $needle = str_replace(array('RH', ' '), '', mb_strtoupper($needle));

        // Kan grubu kontrolü
        if(in_array($blood, $map) AND is_null($needle)){
            return true;
        }

        // Donör uyumu kontrolü
        if(in_array($blood, $map) AND in_array($needle, $bloods[$blood]) AND !is_null($needle)){
            return true;
        }

        return false;

    }

    /**
     *  Validates a given Latitude
     * @param float|int|string $latitude
     * @return bool
     */
    public function is_latitude($latitude){
        $lat_pattern  = '/\A[+-]?(?:90(?:\.0{1,18})?|\d(?(?<=9)|\d?)\.\d{1,18})\z/x';

        if (preg_match($lat_pattern, $latitude)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Validates a given longitude
     * @param float|int|string $longitude
     * @return bool
     */
    public function is_longitude($longitude){
        $long_pattern = '/\A[+-]?(?:180(?:\.0{1,18})?|(?:1[0-7]\d|\d{1,2})\.\d{1,18})\z/x';

        if (preg_match($long_pattern, $longitude)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validates a given coordinate
     *
     * @param float|int|string $lat Latitude
     * @param float|int|string $long Longitude
     * @return bool `true` if the coordinate is valid, `false` if not
     */
    public function is_coordinate($lat, $long) {

        if ($this->is_latitude($lat) AND $this->is_longitude($long)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Distance verification
     */
    public function is_distance($point1, $point2, $options){

        $symbols = array('m', 'km', 'mi', 'ft', 'yd');

        // Option variable control
       if(empty($options)){
           return false;
       }

       if(!strstr($options, ':')){
           return false;
       }

       $options = explode(':', trim($options, ':'));

       if(count($options) != 2){
           return false;
       }

       list($range, $symbol) = $options;

       if(!in_array(mb_strtolower($symbol), $symbols)){
           return false;
       }

       // Points control
        if(empty($point1) OR empty($point2)){
            return false;
        }
        if(!is_array($point1) OR !is_array($point2)){
            return false;
        }

        if(count($point1) != 2 OR count($point2) != 2){
            return false;
        }

        if(isset($point1[0]) AND isset($point1[1]) AND isset($point2[0]) AND isset($point2[1])){
            $distance_range = $this->distanceMeter($point1[0], $point1[1], $point2[0], $point2[1], $symbol);
            if($distance_range <= $range){
                return true;
            }
        }

        return false;
    }

    /**
     * Validation
     * 
     * @param array $rule
     * @param array $data
     * @param array $message
     * @return bool
     */
    public function validate($rule, $data, $message = array()){

        $extra = '';
        $rules = array();

        foreach($rule as $name => $value){
            
            if(strstr($value, '|')){
                foreach(explode('|', trim($value, '|')) as $val){
                    $rules[$name][] = $val;
                }
            } else {
                $rules[$name][] = $value;
            }

        }

        foreach($rules as $column => $rule){
            foreach($rule as $name){

                if(strstr($name, ':')){
                    $ruleData = explode(':', trim($name, ':'));
                    if(count($ruleData) == 2){
                        list($name, $extra) = $ruleData;
                    }
                    // farklı zaman damgaları kontrolüne müsaade edildi.
                    if(count($ruleData) > 2 AND strstr($name, ' ')){
                        $x = explode(' ', $name);
                        list($left, $right) = explode(' ', $name);
                        list($name, $date1) = explode(':', $left);
                        $extra = $date1.' '.$right;
                    }
                }

                // İlgili kuralın mesajı yoksa kural adı mesaj olarak belirtilir.
                if(empty($message[$name])){
                    $message[$name] = $name;
                }

                switch ($name) {
                    // minimum say kuralı
                    case 'min-num':
                        if(!is_numeric($data[$column])){
                            $this->errors[$column][$name] = 'Don\'t numeric.';
                        } else {
                            if($data[$column]<$extra){
                                $this->errors[$column][$name] = $message[$name];
                            }
                        }
                    break;
                    // maksimum sayı kuralı
                    case 'max-num':
                        if(!is_numeric($data[$column])){
                            $this->errors[$column][$name] = 'Don\'t numeric.';
                        } else {
                            if($data[$column]>$extra){
                                $this->errors[$column][$name] = $message[$name];
                            }
                        }
                    break;
                    // minimum karakter kuralı
                    case 'min-char':
                        if(strlen($data[$column])<$extra){
                            $this->errors[$column][$name] = $message[$name];
                        }
                        break;
                    // maksimum karakter kuralı
                    case 'max-char':
                        if(strlen($data[$column])>$extra){
                            $this->errors[$column][$name] = $message[$name];
                        }
                        break;
                    // E-Posta adresi kuralı
                    case 'email':
                        if(!$this->is_email($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Zorunlu alan kuralı
                    case 'required':
                        if(empty($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Telefon numarası kuralı
                    case 'phone':
                        if(!$this->is_phone($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Tarih kuralı
                    case 'date':
                        if(empty($extra)){
                            $extra = 'Y-m-d';
                        }
                        if(!$this->is_date($data[$column], $extra)){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // json kuralı 
                    case 'json':
                        if(!$this->is_json($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Renk kuralı 
                    case 'color':
                        if(!$this->is_color($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // URL kuralı 
                    case 'url':
                        if(!$this->is_url($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // https kuralı 
                    case 'https':
                        if(!$this->is_https($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // http kuralı 
                    case 'http':
                        if(!$this->is_http($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Numerik karakter kuralı 
                    case 'numeric':
                        if(!is_numeric($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Minumum yaş sınırlaması kuralı 
                    case 'min-age':
                        if(!is_numeric($extra) OR !$this->is_date($data[$column], 'Y-m-d')){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Maksimum yaş sınırlaması kuralı 
                    case 'max-age':
                        if(!is_numeric($extra) OR !$this->is_date($data[$column], 'Y-m-d')){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Benzersiz parametre kuralı 
                    case 'unique':

                        if(!$this->is_table($extra)){
                            $this->errors[$column][$name][] = 'Table not found.';
                        }
                        
                        if(!$this->is_column($extra, $column)){
                            $this->errors[$column][$name][] = 'Column not found.';
                        }

                        if($this->do_have($extra, $data[$column], $column)){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    
                    break;
                    // Doğrulama kuralı 
                    case 'bool':
                        // Geçerlilik kontrolü
                        $acceptable = array(true, false, 'true', 'false', 0, 1, '0', '1');

                        if(!in_array($data[$column], $acceptable, true) OR !in_array($extra, $acceptable, true)){
                            $this->errors[$column][$name] = 'True, false, 0 or 1 must be specified.';
                        } else {
                            if($data[$column] === 'true'){ $data[$column] = true; }
                            if($data[$column] === 'false'){ $data[$column] = false; }
                            if($extra === 'true'){ $extra = true; }
                            if($extra === 'false'){ $extra = false; }

                            if($data[$column] != $extra){
                                $this->errors[$column][$name] = $message[$name];
                            }
                        }

                        break;
                    // IBAN doğrulama kuralı
                    case 'iban':
                        if(!$this->is_iban($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // ipv4 doğrulama kuralı
                    case 'ipv4':
                        if(!$this->is_ipv4($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // ipv6 doğrulama kuralı
                    case 'ipv6':
                        if(!$this->is_ipv6($data[$column])){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // kan grubu ve uyumu kuralı
                    case 'blood':
                        if(!$this->is_blood($data[$column], $extra)){
                            $this->errors[$column][$name] = $message[$name];
                        }
                    break;
                    // Koordinat kuralı
                    case 'coordinate':

                        if(!strstr($data[$column], ',')){
                            $this->errors[$column][$name] = $message[$name];
                        } else {

                            $coordinates = explode(',', $data[$column]);
                            if(count($coordinates)==2){

                                list($lat, $long) = $coordinates;

                                if(!$this->is_coordinate($lat, $long)){
                                    $this->errors[$column][$name] = $message[$name];
                                }

                            } else {
                                $this->errors[$column][$name] = $message[$name];
                            }

                        }

                    break;
                    case 'distance':
                        //  $this->errors[$column][$name] = $message[$name];
                        //  echo $data[$column];
                        //  echo $extra;
                        if(strstr($data[$column], '@')){
                            $coordinates = explode('@', $data[$column]);
                            if(count($coordinates) == 2){

                                list($p1, $p2) = $coordinates;
                                $point1 = explode(',', $p1);
                                $point2 = explode(',', $p2);

                                if(strstr($extra, ' ')){
                                    $options = str_replace(' ', ':', $extra);
                                    if(!$this->is_distance($point1, $point2, $options)){
                                        $this->errors[$column][$name] = $message[$name];
                                    }
                                } else {
                                    $this->errors[$column][$name] = $message[$name];
                                }
                            } else {
                                $this->errors[$column][$name] = $message[$name];
                            }
                        } else {
                            $this->errors[$column][$name] = $message[$name];
                        }
                        break;
                    // Geçersiz kural engellendi.
                    default:
                        $this->errors[$column][$name] = 'Invalid rule has been blocked.';
                    break;
                }
                $extra = '';
            }
        }

       
        if(empty($this->errors)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Path information
     *
     * @param string $fileName
     * @param string $type
     * @return bool|string
     */
    public function info($fileName, $type){

        if(empty($fileName) AND isset($type)){
            return false;
        }

        $object = pathinfo($fileName);

        if($type == 'extension'){
            return strtolower($object[$type]);
        }

        return $object[$type];
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
     * Filter
     * 
     * @param string $str
     * @return string
     */
    public function filter($str){
        return htmlspecialchars($str);
    }

    /**
     * Redirect
     *
     * @param string $url
     * @param int $delay
     */
    public function redirect($url = '', $delay = 0){

        if(!$this->is_http($url) AND !$this->is_https($url) OR empty($url)){
            $url = 'http://'.$_SERVER['SERVER_NAME'].$this->base_url.$url;
        }

        if(0 !== $delay){
            header('refresh:'.$delay.'; url='.$url);
        } else {
            header('Location: '.$url);
        }
        ob_end_flush();
        exit();
    }

    /**
     * Permanent connection.
     *
     * @param string $str
     * @param array $options
     * @return string
     */
    public function permalink($str, $options = array()){

        $plainText = $str;
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true,
            'unique' => array(
                'delimiter' => '-',
                'linkColumn' => 'link',
                'titleColumn' => 'title'
            )
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

        if(isset($options['transliterate']) AND !$options['transliterate']){
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
        $link = $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;

        if(!empty($options['unique']['tableName'])){

            $tableName = $options['unique']['tableName'];
            $delimiter = $defaults['unique']['delimiter'];
            $titleColumn = $defaults['unique']['titleColumn'];
            $linkColumn = $defaults['unique']['linkColumn'];

            if(!$this->is_table($options['unique']['tableName'])){
                return $link;
            } else {

                if(!empty($options['unique']['delimiter'])){
                    $delimiter = $options['unique']['delimiter'];
                }
                if(!empty($options['unique']['titleColumn'])){
                    $titleColumn = $options['unique']['titleColumn'];
                }
                if(!empty($options['unique']['linkColumn'])){
                    $linkColumn = $options['unique']['linkColumn'];
                }

                $data = $this->samantha($tableName, array($titleColumn => $plainText));

                if(!empty($data)){
                    $num = count($data)+1;
                } else {
                    $num = 1;
                }

                for ($i = 1; $i<=$num; $i++){

                    if(!$this->do_have($tableName, $link, $linkColumn)){
                        return $link;
                    } else {
                        if(!$this->do_have($tableName, $link.$delimiter.$i, $linkColumn)){
                            return $link.$delimiter.$i;
                        }
                    }
                }
                return $link.$delimiter.$num;
            }
        }
        return $link;
    }

    /**
     * Time zones.
     *
     * @return array
     */
    public function timezones(){
        return timezone_identifiers_list();
    }

    /**
     * Session checking.
     *
     * @return array $_SESSSION
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

    }

    /**
     * Learns the size of the remote file.
     *
     * @param string $url
     * @return int
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
     * @param mixed $file
     * @param mixed $cache
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
     * @param array $scheme
     * @param string $funcName
     * @return array
     */
    public function cGenerator($scheme, $funcName=null){

        $sql = array();
        $column = '';

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
            if(is_null($columnValue) AND $columnType =='int'){ $columnValue = 11; }
            if(is_null($columnValue) AND $columnType =='increments'){ $columnValue= 11;}

            switch ($columnType){
                case 'int':

                    if(!is_null($funcName) AND $funcName == 'columnCreate'){

                        $sql[] = 'ADD `'.$columnName.'` INT('.$columnValue.') NULL DEFAULT NULL';
                    } else {

                        $sql[] = '`'.$columnName.'` INT('.$columnValue.') NULL DEFAULT NULL';
                    }
                    break;
                case 'decimal':

                    if(!is_null($funcName) AND $funcName == 'columnCreate'){

                        $sql[] = 'ADD `'.$columnName.'` DECIMAL('.$columnValue.') NULL DEFAULT NULL';
                    } else {

                        $sql[] = '`'.$columnName.'` DECIMAL('.$columnValue.') NULL DEFAULT NULL';
                    }
                    break;
                case 'string':

                    if(!is_null($funcName) AND $funcName == 'columnCreate'){

                        $sql[] = 'ADD `'.$columnName.'` VARCHAR('.$columnValue.') NULL DEFAULT NULL';
                    } else {

                        $sql[] = '`'.$columnName.'` VARCHAR('.$columnValue.') NULL DEFAULT NULL';
                    }
                    break;
                case 'small':

                    if(!is_null($funcName) AND $funcName == 'columnCreate'){

                        $sql[] = 'ADD `'.$columnName.'` TEXT NULL DEFAULT NULL';
                    } else {

                        $sql[] = '`'.$columnName.'` TEXT NULL DEFAULT NULL';
                    }
                    break;
                case 'medium':

                    if(!is_null($funcName) AND $funcName == 'columnCreate'){

                        $sql[] = 'ADD `'.$columnName.'` MEDIUMTEXT NULL DEFAULT NULL';
                    } else {

                        $sql[] = '`'.$columnName.'` MEDIUMTEXT NULL DEFAULT NULL';
                    }
                    break;
                case 'large':

                    if(!is_null($funcName) AND $funcName == 'columnCreate'){

                        $sql[] = 'ADD `'.$columnName.'` LONGTEXT NULL DEFAULT NULL';
                    } else {

                        $sql[] = '`'.$columnName.'` LONGTEXT NULL DEFAULT NULL';
                    }
                    break;
                case 'increments':

                    if(!is_null($funcName) AND $funcName == 'columnCreate'){

                        $sql[] = 'ADD `'.$columnName.'` INT('.$columnValue.') NOT NULL AUTO_INCREMENT FIRST';
                        $column = 'ADD PRIMARY KEY (`'.$columnName.'`)';
                    } else {

                        $sql[] = '`'.$columnName.'` INT('.$columnValue.') NOT NULL AUTO_INCREMENT';
                        $column = 'PRIMARY KEY (`'.$columnName.'`)';
                    }

                    break;
            }
        }
        if(!empty($column)){
            $sql[] = $column;
        }
        return $sql;
    }

    /**
     * Parameter parser.
     *
     * @param string $str
     * @return array
     */
    public function pGenerator($str=''){

        $Result = array();
        if(!empty($str)){

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
     * @param string $uri
     * @param mixed $file
     * @param mixed $cache
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

        if($this->base_url != '/'){
            $request = str_replace($this->base_url, '', $_SERVER['REQUEST_URI']);
        } else {
            $request = trim($_SERVER['REQUEST_URI'], '/');
        }

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

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            if(strstr($request, '/')){
                $params = explode('/', $request);
                $UriParams = explode('/', $uri);

                if(count($params) >= count($UriParams)){
                    for ($key = 0; count($UriParams) > $key; $key++){
                        unset($params[$key]);
                    }
                }

                $params = array_values($params);
            }

            $this->post = array();

            if(!empty($fields) AND !empty($params)){

                foreach ($fields as $key => $field) {

                    if(isset($params[$key])){

                        if(!empty($params[$key]) OR $params[$key] == '0'){
                            $this->post[$field] = $params[$key];
                        }

                    }
                }
            } else {
                $this->post = array_diff($params, array('', ' '));
            }
        }

        if(!empty($request)){

            if(!empty($params)){
                $uri .= '/'.implode('/', $params);
            }

            if($request == $uri){
                $this->error_status = false;
                $this->page_current = $uri;
                $this->mindLoad($file, $cache);
                exit();
            }

            $this->error_status = true;

        } else {
            if($uri == $this->base_url) {
                $this->error_status = false;
                $this->page_current = $uri;
                $this->mindLoad($file, $cache);
                exit();
            }

        }
    
    }

    /**
     * File writer.
     *
     * @param array $data
     * @param string $filePath
     * @param string $delimiter
     * @return bool
     */
    public function write($data, $filePath, $delimiter = ':') {

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
     * @param array $files
     * @param string $path
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
     * @param mixed $links
     * @param array $opt
     * @return array
     */
    public function download($links, $opt = array())
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

            $destination = $path;

            $other_path = urldecode($this->info($nLink, 'basename'));

            if(!is_dir($destination)){
                mkdir($destination, 0777, true);
            }

            if(file_exists($destination.'/'.$other_path)){

                $remote_file = $this->remoteFileSize($nLink);
                $local_file = filesize($destination.'/'.$other_path);

                if($remote_file != $local_file){
                    unlink($destination.'/'.$other_path);
                    copy($nLink, $destination.'/'.$other_path);

                }
            } else {
                copy($nLink, $destination.'/'.$other_path);
            }

            $result[] = $destination.'/'.$other_path;
        }

        return $result;
    }

    /**
     * Content researcher.
     *
     * @param string $left
     * @param string $right
     * @param string $url
     * @return array
     */
    public function get_contents($left, $right, $url){

        $result = array();

        if($this->is_url($url)) {
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            $data = curl_exec($ch);
            curl_close($ch);

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

    /**
     * Absolute path syntax
     *
     * @param string $path
     * @return string
     */
    public function get_absolute_path($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        $outputdir = implode(DIRECTORY_SEPARATOR, $absolutes);
        if(strstr($outputdir, '\\')){
            $outputdir = str_replace('\\', '/', $outputdir);
        }
        return $outputdir;
    }

    /**
     *
     * Calculates the distance between two points, given their
     * latitude and longitude, and returns an array of values
     * of the most common distance units
     * {m, km, mi, ft, yd}
     *
     * @param float|int|string $lat1 Latitude of the first point
     * @param float|int|string $lon1 Longitude of the first point
     * @param float|int|string $lat2 Latitude of the second point
     * @param float|int|string $lon2 Longitude of the second point
     * @return mixed {bool|array}
     */
    public function distanceMeter($lat1, $lon1, $lat2, $lon2, $type = '') {

        $output = array();

        // koordinat değillerse false yanıtı döndürülür.
        if(!$this->is_coordinate($lat1, $lon1) OR !$this->is_coordinate($lat2, $lon2)){ return false; }

        // aynı koordinatlar belirtilmiş ise false yanıtı döndürülür.
        if (($lat1 == $lat2) AND ($lon1 == $lon2)) { return false; }

        // dereceden radyana dönüştürme işlemi
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);

        $meters     = $angle * 6371000;
        $kilometers = $meters / 1000;
        $miles      = $meters * 0.00062137;
        $feet       = $meters * 3.2808399;
        $yards      = $meters * 1.0936;

        $data = array(
            'm'     =>  round($meters, 2),
            'km'    =>  round($kilometers, 2),
            'mi'    =>  round($miles, 2),
            'ft'    =>  round($feet, 2),
            'yd'    =>  round($yards, 2)
        );

        // eğer ölçü birimi boşsa tüm ölçülerle yanıt verilir
        if(empty($type)){
            return $data;
        }

        // eğer ölçü birimi string ise ve müsaade edilen bir ölçüyse diziye eklenir
        if(!is_array($type) AND in_array($type, array_keys($data))){
            $type = array($type);
        }

        // eğer ölçü birimi dizi değilse ve müsaade edilen bir ölçü değilse boş dizi geri döndürülür
        if(!is_array($type) AND !in_array($type, array_keys($data))){
            return $output;
        }

        // gönderilen tüm ölçü birimlerinin doğruluğu kontrol edilir
        foreach ($type as $name){
            if(!in_array($name, array_keys($data))){
                return $output;
            }
        }

        // gönderilen ölçü birimlerinin yanıtları hazırlanır
        foreach ($type as $name){
            $output[$name] = $data[$name];
        }

        // tek bir ölçü birimi gönderilmiş ise sadece onun değeri geri döndürülür
        if(count($type)==1){
            $name = implode('', $type);
            return $output[$name];
        }

        // birden çok ölçü birimi yanıtları geri döndürülür
        return $output;
    }
}
