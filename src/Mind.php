<?php
namespace Mind;

/**
 *
 * @package    Mind
 * @version    Release: 1.4
 * @license    GNU General Public License v3.0
 * @author     Ali YILMAZ <aliyilmaz.work@gmail.com>
 * @category   Php Framework, Design pattern builder for Php.
 * @url        https://github.com/aliyilmaz/Mind
 *
 */
class Mind {

    private $conn;
    private $host        =  'localhost';
    private $dbname      =  'mydb';
    private $username    =  'root';
    private $password    =  '';
    private $sessset     =  array(
        'path'              =>  './session/',
        'path_status'       =>  false,
        'status_session'    =>  true
    );

    public  $post;
    public  $baseurl;
    public  $timezone    =  'Europe/Istanbul';

    public function __construct($conf=array()){

        $this->session_check();

        $this->connection($conf);

        $this->request();

        if(
            empty(
                $_SESSION['timezone']
            ) OR in_array(
                $_SESSION['timezone'], $this->timezones()
            )
        ){
            $_SESSION['timezone'] = $this->timezone;
        }

        date_default_timezone_set($_SESSION['timezone']);

        $this->baseurl = dirname($_SERVER['SCRIPT_NAME']).'/';

    }

    /**
     * Connection method.
     *
     */
    public function connection($conf){

        if(!empty($conf['host'])){
            $this->host = $conf['host'];
        }

        if(!empty($conf['dbname'])){
            $this->dbname = $conf['dbname'];
        }

        if(!empty($conf['username'])){
            $this->username = $conf['username'];
        }

        if(!empty($conf['password'])){
            $this->password = $conf['password'];
        }

        $error          =   '<div style="background-color: #f3f3f3; padding:10px 20px 30px 20px;">';
        $class          =   '<br /> Class: '.__CLASS__;
        $function       =   '<br /> Function: '.__FUNCTION__;
        $line           =   '<br /> Line: '.(__LINE__+1);
        $this->conn = mysqli_connect($this->host, $this->username, $this->password);

        if (!$this->conn) {
            $description    =   mysqli_connect_error();
            $error .= $class.$function.$line."<br /> Error description: ".$description;

        } else {
            if(!mysqli_select_db($this->conn, $this->dbname)){
                $description    =   mysqli_error($this->conn);
                $error .= $class.$function.$line."<br /> Error description: ".$description;
            } else {
                $error = '';
                mysqli_set_charset($this->conn, 'utf8');
            }
        }

        if(!empty($error)) {
            exit($error.'</div>');
        }

        return true;
    }

    /**
     * Query method.
     *
     * @param string $sql
     * @return mixed
     */
    public function prepare($sql){

        return mysqli_query($this->conn, $sql);

    }

    /**
     * Creating a database.
     *
     * @param mixed $dbname
     * @return  bool
     * */
    public function createdb($dbname){

        $dbnames = array();

        if(is_array($dbname)){
            foreach ($dbname as $key => $value) {
                $dbnames[] = $value;
            }
        } else {
            $dbnames[] = $dbname;
        }

        foreach ($dbnames as $dbname) {

            if($this->is_db($dbname)){
                echo "Error: A database named (".$dbname.") already exists.\n";
                return false;
            }
            if(!preg_match('/^[A-Za-z0-9_]+$/', $dbname)){
                echo "Error: The database could not be created because (".$dbname.") is not alphanumeric.\n";
                return false;
            }

            $sql = 'CREATE DATABASE '.$dbname;
            $this->prepare($sql);
        }

        return true;
    }

    /**
     * Creating a table.
     *
     * @param mixed   $tblname
     * @param mixed   $arr
     * @return  bool
     * */
    public function createtable($tblname, $arr){

        if($this->is_table($tblname)){
            echo "Error: A Table named (".$tblname.") already exists.\n";
            return false;
        }
        if(!preg_match('/^[A-Za-z0-9_]+$/', $tblname)){
            echo "Error: The database table could not be created because (".$tblname.") is not an alphanumeric name.\n";
            return false;
        }

        $xsql = array();
        $columns = array();
        $types  = array();
        $typeDefault = 'small';
        $typeLibrary = array(
            'small'         =>  'TEXT',
            'medium'        =>  'MEDIUMTEXT',
            'large'         =>  'LONGTEXT'
        );

        if(is_array($arr)){

            $sql = 'CREATE TABLE '.$tblname.'( ';

            foreach ($arr as $item) {

                if(strstr($item, ':')){

                    $symbolsTotal = count(explode(':', $item));

                    if($symbolsTotal != 2){
                        echo "Error: You can use the (:) symbol once.\n";
                        return false;
                    }

                    list($column, $type) = explode(':', $item);

                    $columns[] = $column;

                    if(!array_key_exists($type, $typeLibrary) AND $type == 'increments'){
                        $xsql[] = $column.' INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY';
                        $types[] = $type;
                    }

                    if(array_key_exists($type, $typeLibrary) AND $type != 'increments'){
                        $xsql[] = $column.' '.$typeLibrary[$type].' NULL';
                        $columns[] = $column;
                    }
                } else {

                    $xsql[] = $item.' '.$typeLibrary[$typeDefault].' NULL';
                    $columns[] = $item;
                }
            }

            if(count($types)>1){
                echo "Error: The auto_increment task cannot be defined in multiple columns.\n";
                return false;
            }

            $tcolumns = array_count_values($columns);
            foreach ($columns as $key => $column) {

                if($tcolumns[$column]>1){
                    echo "Error: The column named (".$column.") already exists.\n";
                    return false;
                }

                if(!preg_match('/^[A-Za-z0-9_]+$/', $column)){
                    echo "Error: The table column could not be created because (".$column.") is not an alphanumeric name.\n";
                    return false;
                }
            }

            $sql .= implode(',', $xsql).')';

            $this->prepare($sql);

            return true;
        }

        return false;

    }

    /**
     * Creating a column.
     *
     * @param mixed   $tblname
     * @param mixed   $arr
     * @return  bool
     * */
    public function createcolumn($tblname, $arr){

        if(!$this->is_table($tblname)){
            echo "Error: Since there is no table named (".$tblname."), a column cannot be created in a table with that name.\n";
            return false;
        }

        $xsql = array();
        $tcolumns = array();
        $columns = array();
        $types  = array();
        $typeDefault = 'small';
        $typeLibrary = array(
            'small'         =>  'TEXT',
            'medium'        =>  'MEDIUMTEXT',
            'large'         =>  'LONGTEXT'
        );

        if(is_array($arr)){

            $sql = 'ALTER TABLE '.$tblname.' ';

            foreach ($arr as $item) {

                if(strstr($item, ':')){

                    $symbolsTotal = count(explode(':', $item));

                    if($symbolsTotal != 2){
                        echo "Error: You can use the (:) symbol once.\n";
                        return false;
                    }

                    list($column, $type) = explode(':', $item);

                    if(!array_key_exists($type, $typeLibrary) AND $type == 'increments'){
                        $xsql[] = 'ADD COLUMN '.$column.' INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY FIRST';
                        $types[] = $type;
                    }

                    if(array_key_exists($type, $typeLibrary) AND $type != 'increments'){
                        $xsql[] = 'ADD COLUMN '.$column.' '.$typeLibrary[$type].' NULL';
                        $columns[] = $column;
                    }
                } else {

                    $xsql[] = 'ADD COLUMN '.$item.' '.$typeLibrary[$typeDefault].' NULL';
                    $columns[] = $item;
                }
            }

            if(count($types)>=1 AND !empty($this->increments($tblname))){
                echo "Error: The auto-increment feature can only be in one column.\n";
                return false;
            }

            $tcolumns = array_count_values($columns);
            foreach ($columns as $key => $column) {

                if($tcolumns[$column]>1 OR $this->is_column($tblname, $column)){
                    echo "Error: The column named (".$column.") already exists.\n";
                    return false;
                }

                if(!preg_match('/^[A-Za-z0-9_]+$/', $column)){
                    echo "Error: The table column could not be created because (".$column.") is not an alphanumeric name.\n";
                    return false;
                }
            }

            $sql .= implode(',', $xsql);

            $this->prepare($sql);

            return true;
        }

        return false;
    }

    /**
     * Delete database.
     *
     * @param mixed   $dbname
     * @return  bool
     * */
    public function deletedb($dbname){

        $dbnames = array();

        if(is_array($dbname)){
            foreach ($dbname as $key => $value) {
                $dbnames[] = $value;
            }
        } else {
            $dbnames[] = $dbname;
        }
        foreach ($dbnames as $dbname) {

            if(!preg_match('/^[A-Za-z0-9_]+$/', $dbname)){
                echo "Error: Only database with an alphanumeric name can be deleted. (".$dbname.") is not alphanumeric.\n";
                return false;
            }

            if(!$this->is_db($dbname)){
                echo "Error: Unable to delete because there is no database named  (".$dbname.").\n";
                return false;
            }

            $sql = 'DROP DATABASE '.$dbname;
            $this->prepare($sql);
        }
        return true;
    }

    /**
     * Delete table.
     *
     * @param mixed   $tblname
     * @return  bool
     * */
    public function deletetable($tblname){

        $tblnames = array();

        if(is_array($tblname)){
            foreach ($tblname as $key => $value) {
                $tblnames[] = $value;
            }
        } else {
            $tblnames[] = $tblname;
        }
        foreach ($tblnames as $tblname) {

            if(!preg_match('/^[A-Za-z0-9_]+$/', $tblname)){
                echo "Error: Only tables with an alphanumeric name can be deleted. (".$tblname.") is not alphanumeric.\n";
                return false;
            }

            if(!$this->is_table($tblname)){
                echo "Error: Unable to delete because there is no table named (".$tblname.").\n";
                return false;
            }

            $sql = 'DROP TABLE '.$tblname;
            $this->prepare($sql);
        }
        return true;
    }

    /**
     * Delete column.
     *
     * @param string   $tblname
     * @param mixed   $column
     * @return  bool
     * */
    public function deletecolumn($tblname, $column){

        if(!$this->is_table($tblname)){
            echo "Error: The request to delete the column resulted in a negative because there was no table named (".$tblname.").\n";
            return false;
        }

        $columns = array();

        if(is_array($column)){
            foreach ($column as $key => $value) {
                $columns[] = $value;
            }
        } else {
            $columns[] = $column;
        }
        foreach ($columns as $column) {

            if(!preg_match('/^[A-Za-z0-9_]+$/', $column)){
                echo "Error: The column named (".$column.") could not be delete because it is not alphanumeric.\n";
                return false;
            }

            if(!$this->is_column($tblname, $column)){
                echo "Error: You cannot delete the non-existing column named (".$column.").\n";
                return false;
            }

            $sql = 'ALTER TABLE '.$tblname.' DROP COLUMN '.$column;
            $this->prepare($sql);
        }
        return true;
    }

    /**
     * Clear database.
     *
     * @param mixed   $dbname
     * @return  bool
     * */
    public function cleardb($dbname){

        $dbnames = array();

        if(is_array($dbname)){
            foreach ($dbname as $key => $value) {
                $dbnames[] = $value;
            }
        } else {
            $dbnames[] = $dbname;
        }
        foreach ($dbnames as $dbname) {

            if(!preg_match('/^[A-Za-z0-9_]+$/', $dbname)){
                echo "Error: Only the database with the alphanumeric name can be cleared. (".$dbname.") is not alphanumeric.\n";
                return false;
            }

            if(!$this->is_db($dbname)){
                echo "Error: Unable to clear because there is no database named  (".$dbname.").\n";
                return false;
            }

            $sql    = 'SHOW TABLES FROM '.$dbname;
            $query  = $this->prepare($sql);
            while($cRow = mysqli_fetch_array($query)){
                mysqli_select_db($this->conn, $dbname);
                $this->cleartable($cRow[0]);
            }
            mysqli_select_db($this->conn, $this->dbname);
        }
        return true;
    }

    /**
     * Clear table.
     *
     * @param mixed   $tblname
     * @return  bool
     * */
    public function cleartable($tblname){

        $tblnames = array();

        if(is_array($tblname)){
            foreach ($tblname as $value) {
                $tblnames[] = $value;
            }
        } else {
            $tblnames[] = $tblname;
        }

        foreach ($tblnames as $tblname) {

            if(!preg_match('/^[A-Za-z0-9_]+$/', $tblname)){
                echo "Error: Only tables with an alphanumeric name can be cleared. (".$tblname.") is not alphanumeric.\n";
                return false;
            }

            if(!$this->is_table($tblname)){
                echo "Error: Unable to clear because there is no table named  (".$tblname.").\n";
                return false;
            }

            $sql = 'TRUNCATE '.$tblname;
            $this->prepare($sql);
        }
        return true;
    }

    /**
     * Clear column.
     *
     * @param string   $tblname
     * @param mixed   $column
     * @return  bool
     * */
    public function clearcolumn($tblname, $column){

        $columns = array();

        if(!$this->is_table($tblname)){
            echo "Error: The request to clean the column resulted in a negative because there was no table named (".$tblname.").\n";
            return false;
        }

        if(is_array($column)){
            foreach ($column as $key => $value) {
                $columns[] = $value;
            }
        } else {
            $columns[] = $column;
        }

        foreach ($columns as $column) {


            if(!preg_match('/^[A-Za-z0-9_]+$/', $column)){
                echo "Error: The column named (".$column.") could not be created because it is not alphanumeric.\n";
                return false;
            }

            if(!$this->is_column($tblname, $column)){
                echo "Error: You cannot clear the non-existing column named (".$column.").\n";
                return false;
            }

            $id   = $this->increments($tblname);
            $data = $this->get($tblname);

            foreach ($data as $row) {
                $arr = array(
                    $column => ''
                );
                $this->update($tblname, $arr, $row[$id]);
            }
        }

        return true;

    }

    /**
     * Add new record.
     *
     * @param string   $tblname
     * @param mixed   $arr
     * @return  bool
     * */
    public function insert($tblname, $arr){

        if(!$this->is_table($tblname)){
            echo "Error: Failed to add data because (".$tblname.") table could not be found.\n";
            return false;
        }

        if(!is_array($arr)){
            return false;
        }

        $columns = array_keys($arr);


        foreach ($columns as $column){

            if(!preg_match('/^[A-Za-z0-9_]+$/', $column)){
                echo "Error: The column named (".$column.") could not be created because it is not alphanumeric.\n";
                return false;
            }

            if(!$this->is_column($tblname, $column)){
                echo "Error: You cannot add data to the non-existing column named (".$column.").\n";
                return false;
            }
        }

        $column = implode(',', $columns);
        $values = '\''.implode('\',\'', array_values($arr)).'\'';
        $sql = 'INSERT INTO '.$tblname.'('.$column.') VALUES ('.$values.')';

        $this->prepare($sql);

        return true;
    }

    /**
     * Record update.
     *
     * @param string   $tblname
     * @param mixed   $arr
     * @param mixed   $id
     * @param mixed   $special
     * @return  bool
     * */
    public function update($tblname, $arr, $id, $special=null){

        if(!$this->is_table($tblname)){
          return false;
        }

        if(empty($special)){

            $special = $this->increments($tblname);

            if(empty($special)){
                return false;
            }

        }

        if(!$this->do_have($tblname, $id, $special)){
            return false;
        }

        foreach ($arr as $name => $value) {

            if(!$this->is_column($tblname, $name)){
              return false;
            }

            $field = $name.'=\''.$value.'\'';
            $newfield = $special.'=\''.$id.'\'';
            $sql = 'UPDATE '.$tblname.' SET '.$field.' WHERE '.$newfield;
            $this->prepare($sql);
        }
        return true;
    }

    /**
     * Record delete.
     *
     * @param string   $tblname
     * @param mixed   $arr
     * @param mixed   $id
     * @param mixed   $special
     * @return  bool
     * */
    public function delete($tblname, $id, $special=null){

        $ids = array();

        if(!$this->is_table($tblname)){
            return false;
        }

        if(empty($special)){

            $special = $this->increments($tblname);

            if(empty($special)){
                return false;
            }

        }

        if(is_array($id)){

          foreach ($id as $key => $value) {
              if(!$this->do_have($tblname, $value, $special)){
                return false;
              }
              $ids[] = $value;
          }

        } else {

          if(!$this->do_have($tblname, $id, $special)){
            return false;
          }

          $ids[] = $id;

        }

        foreach ($ids as $id) {

          $sql = 'DELETE FROM '.$tblname.' WHERE '.$special.'='.$id;
          $this->prepare($sql);

        }

        return true;
    }

    /**
     * Record reading.
     *
     * @param string   $tblname
     * @param mixed   $arr
     * @return  mixed
     * */
    public function get($tblname, $arr=null){

        $column  = '*';
        $special = '';
        $keyword = '';

        if($this->is_table($tblname)){
            $getdata = array();
        } else {
            $getdata = '';
        }

        $sql = 'SHOW COLUMNS FROM '.$tblname;
        $query = $this->prepare($sql);

        if(!empty($query)){
            while($row = $query->fetch_assoc()){
                $columns[] = $row['Field'];
            }

            if(!empty($arr['column'])){

                if(!is_array($arr['column'])){
                    $arr['column']= array($arr['column']);
                }

                $arr['column'] = array_intersect($arr['column'], $columns);
                $column = implode(',', array_values($arr['column']));

            }

            if(!empty($arr['search']['keyword'])){

                $keyword = $arr['search']['keyword'];

                if(!empty($arr['search']['column'])){

                    if(!is_array($arr['search']['column'])){
                        $arr['search']['column'] = array($arr['search']['column']);
                    }

                    $columns = array_intersect($arr['search']['column'], $columns);
                }

                if(!empty($arr['search']['where']) AND $arr['search']['where']=='all'){
                    $p = '%';
                } else {
                    $p = '';
                }

                if(is_array($keyword)){
                    foreach ($keyword as $key => $value) {

                        $xcontent   = ' LIKE \''.$p.$value.$p.'\' OR ';
                        $ycontent   = ' LIKE \''.$p.$value.$p.'\'';
                        $content[]  = implode($xcontent, $columns).$ycontent;
                    }

                    $special = 'WHERE '.implode(' OR ', $content);

                } else {

                    $content = implode(' LIKE \''.$p.$keyword.$p.'\' OR ', $columns);
                    $special = 'WHERE '.$content.' LIKE \''.$p.$keyword.$p.'\'';
                }
            }

            if(!empty($arr['sort'])){

                list($columname, $sort) = explode(':', $arr['sort']);

                if(ctype_alpha($sort) AND in_array($sort, array('ASC','DESC'))){
                    $special .= ' ORDER BY '.$columname.' '.$sort;
                }

            }

            if(!empty($arr['limit'])){

                if(!empty($arr['limit']['start']) AND $arr['limit']['start']>0){
                    $start = $arr['limit']['start'].',';
                } else {
                    $start = '0,';
                }

                if(!empty($arr['limit']['end']) AND $arr['limit']['end']>0){
                    $end = $arr['limit']['end'];
                } else {

                    $sql     = 'SELECT * FROM '.$tblname;
                    $query   = $this->prepare($sql);
                    $end     = $query->num_rows;
                }

                $special .= ' LIMIT '.$start.$end;

            }

            $sql     = 'SELECT '.$column.' FROM '.$tblname.' '.$special;
            $query   = $this->prepare($sql);

            if(!$query){
                $query = array();
            }

            foreach ($query as $name => $value) {
                $getdata[$name] = $value;
            }

            if(isset($arr['format'])){
                switch ($arr['format']) {
                    case 'json':
                        $getdata = json_encode($getdata);
                        break;
                }
            }
        }

        return $getdata;
    }

    /**
     * Entity verification.
     *
     * @param string   $tblname
     * @param mixed   $str
     * @param mixed   $column
     * @return  bool
     * */
    public function do_have($tblname, $str, $column=null){

        if(!empty($tblname) AND !empty($str)){

            $arr = array(
                'search'=> array(
                    'keyword' => $this->filter($str)
                )
            );

            if(!empty($column)){
                $arr = array(
                    'search' =>array(
                        'keyword' => $this->filter($str),
                        'column' => $this->filter($column)
                    )
                );
            }

            $data = $this->get($tblname, $arr);

            if(!empty($data)){
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * New id parameter.
     *
     * @param string   $tblname
     * @return  int
     * */
    public function newid($tblname){

        $arr = array(
            'column'  =>  $this->increments($tblname)
        );

        $q = $this->get($tblname, $arr);

        if(empty($q)){

            $this->cleartable($tblname);

            $id = 1;
            return $id;

        } else {

            foreach ($q as $id) {
                $d[] = $id;
            }
            return implode('', max($d))+1;

        }
    }

    /**
     * Auto increment column.
     *
     * @param string   $tblname
     * @return  string
     * */
    public function increments($tblname){

        $sql = "SHOW COLUMNS FROM ".$tblname." WHERE EXTRA LIKE '%auto_increment%'";
        $query = $this->prepare($sql);
        $row = $query->fetch_assoc();
        return $row['Field'];
    }

    /**
     * Database verification.
     *
     * @param string   $dbname
     * @return  bool
     * */
    public function is_db($dbname){

        $sql    = 'SHOW DATABASES LIKE \''.$dbname.'\'';
        $query  = $this->prepare($sql);

        if($query->num_rows){
            return true;
        } else {
            return false;
        }

    }

    /**
     * Table verification.
     *
     * @param string   $tblname
     * @return  bool
     * */
    public function is_table($tblname){

        $sql     = 'DESCRIBE '.$tblname;
        $query   = $this->prepare($sql);

        if($query){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Column verification.
     *
     * @param string   $tblname
     * @param string   $column
     * @return  bool
     * */
    public function is_column($tblname, $column){

        $sql = 'SHOW COLUMNS FROM ' . $tblname;
        $query = $this->prepare($sql);

        if (!empty($query)) {
            while ($row = $query->fetch_assoc()) {
                $columns[] = $row['Field'];
            }
        }

        if(in_array($column, $columns)){
            return true;
        } else {
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

        if(preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', implode('', explode(' ', $str)))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Date verification.
     *
     * @param string   $str
     * @param string   $format
     * @return  bool
     * */
    public function is_date($date, $format = 'd-m-Y H:i:s'){

        $d = \DateTime::createFromFormat($format, $date);

        if($d AND $d->format($format) == $date){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Mail verification.
     *
     * @param mixed   $str
     * @return  bool
     * */
    public function is_email($str){

        if(filter_var($str, FILTER_VALIDATE_EMAIL)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Type verification.
     *
     * @param mixed   $str
     * @param mixed   $type
     * @return  bool
     * */
    public function is_type($str, $type){

        if(!is_array($str) AND !empty($type)){

            $exc = $this->info($str, 'extension');

            if(!is_array($type)){
                $type = array($type);
            }

            if(in_array($exc, $type)){
                return true;
            } else {
                return false;
            }
        }
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

        if(!is_array($str) AND ctype_digit($str)){
            $str = array('size'=>$str);
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
     * @param string   $str
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

        if(preg_match( '/^(http|https|www):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$url)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Path information.
     *
     * @param string   $str
     * @param string   $type
     * @return  string
     * */
    public function info($str, $type){

        $object = pathinfo($str);
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
     * Request collector.
     *
     * @param mixed   $_GET
     * @param mixed   $_POST
     * @param mixed   $_FILES
     * @return  mixed
     * */
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

        return true;
    }

    /**
     * Redirect.
     *
     * @param string   $url
     * @return  mixed
     * */
    public function redirect($url=null){

        if(empty($url)){
            $url = $this->baseurl;
        }

        header('Location: '.$url);
        exit();
    }

    /**
     * Layer installer.
     *
     * @param   mixed $file
     * @param   mixed $cache
     * */
    public function mindload($file, $cache=null){

        if(!empty($file) OR !empty($cache)){

            if (!empty($cache) AND !is_array($cache)) {
                $cache = array($cache);
            }

            if (!empty($cache)) {
                foreach ($cache as $cachefile) {

                    if (file_exists($cachefile . '.php')) {
                        require_once($cachefile . '.php');
                    }
                }
            }

            if(!empty($file)){

                $files = array();

                if(!is_array($file)){
                    $files = array($file);
                } else {
                    $files = $file;
                }

                foreach ($files as $file){

                    if (file_exists($file . '.php')) {
                        require_once($file . '.php');
                    }
                }
            }
        }
    }

    /**
     * Permanent connection.
     *
     * @param string   $str
     * @param mixed   $option
     * @return  string
     * */
    public function permalink($str, $options = array()){

        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true
        );

        $char_map = array(

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
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

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
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        $replacements = array();

        if(!empty($options['replacements']) AND is_array($options['replacements'])){
            $replacements = $options['replacements'];
        }

        if(!$defaults['transliterate']){
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
        if($options['lowercase']){
            return mb_strtolower($str, 'UTF-8');
        } else {
            return $str;
        }

    }

    /**
     * Time zones.
     *
     * @return  mixed
     * */
    public function timezones(){
        return timezone_identifiers_list();
    }

    /**
     * Sessions.
     *
     * @return  mixed
     * */
    public function session_check(){

        if($this->sessset['status_session']){

            if($this->sessset['path_status']){

                if(!is_dir($this->sessset['path'])){

                    mkdir($this->sessset['path']); chmod($this->sessset['path'], 755);
                    $this->write('deny from all', $this->sessset['path'].'/.htaccess');
                    chmod($this->sessset['path'].'/.htaccess', 644);
                }

                ini_set(
                    'session.save_path',
                    realpath(
                        dirname(__FILE__)
                    ).'/'.$this->sessset['path']
                );
            }

            if(!isset($_SESSION)){
                session_start();
            }

        }
    }

    /**
     * Routing manager.
     *
     * @param   string  $uri
     * @param   mixed  $file
     * @param   mixed  $cache
     * @return  mixed
     * */
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

        $request = str_replace($this->baseurl, '', $_SERVER['REQUEST_URI']);
        $tfields    = array();
        $fields     = array();

        if(!empty($uri)){

            if(strstr($uri, ':')){

                $tfields = array_filter(explode(':', $uri));

                if(count($tfields)==1){
                    $uri = implode('', $tfields);
                }
            }

            if(!empty($tfields) AND count($tfields)==2){

                list($uri, $tfields) = $tfields;
                if(strstr($tfields, '@')){
                    $fields = array_filter(explode('@', $tfields));
                } else {
                    $fields = array($tfields);
                }
            }
        }

        if($uri == '/'){
            $uri = $this->baseurl;
        }

        $params = array();

        if(strstr($request, '/')){

            $step1 = str_replace($uri, '', $request);
            $step2 = explode('/', $step1);
            $step3 = array_filter($step2);
            $params = array_values($step3);
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            $this->post = array();

            if(!empty($fields)){

                foreach ($fields as $key => $field) {

                    if(!empty($params[$key])){
                        $this->post[$field] = $params[$key];
                    }
                }
            } else {
                $this->post = $params;
            }
        }

        if(!empty($request)){

            if(strstr($request, $uri)){
                $this->mindload($file, $cache);
                exit();
            }
        } else {

            if($uri == $this->baseurl){
                $this->mindload($file, $cache);
                exit();
            } else {
                exit();
            }
        }
    }

    /**
     * File writer.
     *
     * @param   mixed   $str
     * @param   string   $path
     * @return  bool
     * */
    public function write($str, $path) {

        if(is_array($str)){
            $content 	= implode(':', $str);
        } else {
            $content    = $str;
        }

        if(isset($content)){

            $writedb 		= fopen($path, "a+");
            fwrite($writedb, $content."\r\n");
            fclose($writedb);

            return true;
        }

        return false;
    }

    /**
     * File uploader.
     *
     * @param   mixed   $files
     * @param   string   $path
     * @return  mixed
     * */
    public function upload($files, $path){

        $response = array();

        if(is_dir($path)){

            if(!empty($files) AND !isset($files[0])){
                $files = array($files);
            }

            foreach ($files as $file){

                if(!empty($file['name'])){

                    $ext        = $this->info($file['name'], 'extension');
                    $newpath    = $path.'/'.md5(date('d-m-Y g:i:s').gettimeofday()['usec']).'.'.$ext;
                    move_uploaded_file($file['tmp_name'], $newpath);
                    $response[] = $newpath;

                }

            }

            return $response;
        }

        return false;
    }

    /**
     * Content researcher.
     *
     * @param   string   $left
     * @param   string   $right
     * @param   string   $url
     * @return  mixed
     * */
    public function get_contents($left, $right, $url){

        set_time_limit(0);
        $result = array();

        if($this->is_url($url)) {

            $arrContextOptions = stream_context_create(array(
                'ssl' => array(
                    'verify_peer' 		=> false,
                    'verify_peer_name' 	=> false,
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
    }

}
?>
