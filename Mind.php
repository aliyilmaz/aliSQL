<?php

/*
 * @author  :   Ali Yılmaz
 * @mail    :   aliyilmaz.work@gmail.com
 * @github  :   https://github.com/aliyilmaz
 *
 * */

class Mind {

    /*
     * The variable of the database connection.
     * */
    private $conn;

    /*
     * Database server address variable
     * */
    private $host        =  'localhost';

    /*
     * Database name variable
     * */
    private $dbname      =  'mydb';

    /*
     * Database username variable
     * */
    private $username    =  'root';

    /*
     * Database user's password variable
     * */
    private $password    =  '';

    /*
     * It is the variable in which session
     * settings are kept.
     * */
    private $sessset     =  array(
        'path'              =>  './session/',
        'path_status'       =>  false,
        'status_session'    =>  true
    );

    /*
     * It is the variable that is responsible for
     * handling http requests.
     * */
    public  $post;

    /*
     * This variable moves the path of the project
     * directory.
     * */
    public  $baseurl;

    /*
     * The time zone variable that should be valid
     * if the setting is not defined
     * */
    public  $timezone    =  'Europe/Istanbul';

    /*
     * Default language
     * */
    public  $language    =  'tr';

    /*
     * Function where dependencies
     * are executed.
     * */
    public function __construct(){

        /*
         * The project language is interpreted in a
         * universal encoding.
         * */
        header('Content-Type: text/html; charset=utf-8');

        /*
         * It is shown if there is an error.
         * */
        error_reporting(-1);

        /*
         * If there is no active session, the function
         * to start the session is running
         * */
        $this->session_check();

        /*
         * The function that provides the database
         * connection is executed
         * */
        $this->connection();

        /*
         * The function that evaluates $_GET, $_POST,
         * $FILES requests is executed.
         * */
        $this->request();

        /*
         * If the time zone variable is not empty, we
         * make sure that it has a valid time zone. If
         * it is empty, we tell it to use the time zone
         * defined in the $this->timezone variable.
         * */
        if(!empty($_SESSION['timezone'])){
            if(!in_array($_SESSION['timezone'], $this->timezones())){
                $_SESSION['timezone'] = $this->timezone;
            }
        } else {
            $_SESSION['timezone'] = $this->timezone;
        }

        /*
         * We apply the specified time zone option to
         * the project.
         * */
        date_default_timezone_set($_SESSION['timezone']);

        /*
         * The project directory path is obtained.
         * */
        $this->baseurl = dirname($_SERVER['SCRIPT_NAME']).'/';

    }

    /*
     * It is a function used to establish a database
     * connection and to make this connection available
     * with $this->conn.
     * */
    public function connection(){

        /*
         * The existence of an available database connection
         * is queried.
         * */
        if(!isset($this->conn)){

            /*
             * The database connection is provided with MySQLi
             * and $this->conn is assigned.
             * */
            $this->conn = mysqli_connect($this->host, $this->username, $this->password);

            /*
             * Checks the database connection.
             * */
            if(!$this->conn){
                die("Connection error: " . mysqli_connect_error());
            }

            /*
             * If the database variable is not empty, the process starts.
             * */
            if(!empty($this->dbname)){

                /*
                 * The existence of the database is queried. If the database
                 * does not exist, the database is created.
                 * */
                if(!$this->is_database($this->dbname)){
                    $this->createdb($this->dbname);
                }

                /*
                 * The database is selected.
                 * */
                mysqli_select_db($this->conn, $this->dbname);
            }


            /*
             * The database character set is defined as utf8.
             * */
            mysqli_set_charset($this->conn, 'utf8');
        }
    }

    /*
     * The sql syntax created by the methods is processed
     * with the help of this function.
     * --------------------------
     * string                   $sql
     * array                    return
     * --------------------------
     * */
    public function querySQL($sql){

        $query = array();

        /*
         * The mysqli_query query is executed and the
         * returned value is loaded into the $query variable.
         * */
        $query = mysqli_query($this->conn, $sql);

        /*
         * If the query is successful, the response returned
         * from the mysqli_query query is returned with the
         * help of the $query variable.
         * */
        return $query;
    }

    /*
     * It is a function used to create a database.
     * --------------------------
     * string, array            $dbname
     * boolean                  return
     * --------------------------
     * */
    public function createdb($dbname){
        $dbnames = array();

        if(is_array($dbname)){
            foreach ($dbname as $key => $value) {
                if(!$this->is_database($value)){
                    $dbnames[] = $value;
                } else {
                    return false;
                }
            }
        } else {
            if(!$this->is_database($dbname)){
                $dbnames[] = $dbname;
            } else {
                return false;
            }
        }

        foreach ($dbnames as $dbname) {

            $sql = 'CREATE DATABASE '.$dbname;
            $this->querySQL($sql);

        }
        return true;
    }

    /*
     * Database table creation function.
     * --------------------------
     * string                   $tblname
     * array                    $arr
     * boolean                  return
     * --------------------------
     *
     * */
    public function createtable($tblname, $arr){

        if($this->is_table($tblname)){
            return false;
        }

        $typeDefault = 'small';

        $typeLibrary = array(
            'small'         =>  'TEXT',
            'medium'        =>  'MEDIUMTEXT',
            'large'         =>  'LONGTEXT'
        );

        if(is_array($arr) AND preg_match('/^[A-Za-z0-9_]+$/', $tblname)){

            $sql = 'CREATE TABLE '.$tblname.'( ';

            foreach ($arr as $item) {

                if(strstr($item, ':')){

                    $symbolsTotal = count(explode(':', $item));

                    if($symbolsTotal != 2){
                        return false;
                    }

                    list($column, $type) = explode(':', $item);

                    if(!array_key_exists($type, $typeLibrary) AND $type == 'increments'){
                        $xsql[] = $column.' INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY';
                    }

                    if(array_key_exists($type, $typeLibrary) AND $type != 'increments'){
                        $xsql[] = $column.' '.$typeLibrary[$type].' NULL';
                    }
                } else {

                    $xsql[] = $item.' '.$typeLibrary[$typeDefault].' NULL';
                }
            }

            $sql .= implode(',', $xsql).')';

            $this->querySQL($sql);

            return true;
        }

        return false;

    }

    public function createcolumn($tblname, $arr){

        if(!$this->is_table($tblname)){
            return false;
        }

        $typeDefault = 'small';

        $typeLibrary = array(
            'small'         =>  'TEXT',
            'medium'        =>  'MEDIUMTEXT',
            'large'         =>  'LONGTEXT'
        );

        if(is_array($arr) AND preg_match('/^[A-Za-z0-9_]+$/', $tblname)){

            $sql = 'ALTER TABLE '.$tblname.' ';

            foreach ($arr as $item) {

                if(strstr($item, ':')){

                    $symbolsTotal = count(explode(':', $item));

                    if($symbolsTotal != 2){
                        return false;
                    }

                    list($column, $type) = explode(':', $item);

                    if($this->is_column($tblname, $column)){
                        return false;
                    }

                    if(!array_key_exists($type, $typeLibrary) AND $type == 'increments'){

                        $ainc = $this->autoincrement($tblname);

                        if(!empty($ainc)){
                            return false;
                        }

                        $xsql[] = 'ADD COLUMN '.$column.' INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY FIRST';
                    }

                    if(array_key_exists($type, $typeLibrary) AND $type != 'increments'){
                        $xsql[] = 'ADD COLUMN '.$column.' '.$typeLibrary[$type].' NULL';
                    }
                } else {

                    $xsql[] = 'ADD COLUMN '.$item.' '.$typeLibrary[$typeDefault].' NULL';
                }
            }

            $sql .= implode(',', $xsql);

            $this->querySQL($sql);

            return true;
        }

        return false;

    }


    /*
     * This function is used to delete database.
     * --------------------------
     * string, array            $dbname
     * boolean                  return
     * --------------------------
     * */
    public function deletedb($dbname){
        $dbnames = array();

        if(is_array($dbname)){
            foreach ($dbname as $key => $value) {
                if(!$this->is_database($value)){
                    return false;
                }
                $dbnames[] = $value;
            }
        } else {
            if(!$this->is_database($dbname)){
                return false;
            }
            $dbnames[] = $dbname;
        }
        foreach ($dbnames as $dbname) {
            $sql = 'DROP DATABASE '.$dbname;
            $this->querySQL($sql);
        }
        return true;
    }

    /*
     * This function is used to delete database
     * tables.
     * --------------------------
     * string, array            $tblname
     * boolean                  return
     * --------------------------
     * */
    public function deletetable($tblname){
        $tblnames = array();

        if(is_array($tblname)){
            foreach ($tblname as $key => $value) {
                if(!$this->is_table($value)){
                    return false;
                }
                $tblnames[] = $value;
            }
        } else {
            if(!$this->is_table($tblname)){
                return false;
            }
            $tblnames[] = $tblname;
        }
        foreach ($tblnames as $tblname) {
            $sql = 'DROP TABLE '.$tblname;
            $this->querySQL($sql);
        }
        return true;
    }

    /*
     * This function is used to delete column..
     * --------------------------
     * string                   $tblname
     * string, array            $column
     * boolean                  return
     * --------------------------
     * */
    public function deletecolumn($tblname, $column){
        $columns = array();

        if(is_array($column)){
            foreach ($column as $key => $value) {
                if(!$this->is_column($tblname, $value)){
                    return false;
                }
                $columns[] = $value;
            }
        } else {
            if(!$this->is_column($tblname, $column)){
                return false;
            }
            $columns[] = $column;
        }
        foreach ($columns as $column) {
            $sql = 'ALTER TABLE '.$tblname.' DROP COLUMN '.$column;
            $this->querySQL($sql);
        }
        return true;
    }

    /*
     * This function is used to clear database.
     * --------------------------
     * string, array            $dbname
     * boolean                  return
     * --------------------------
     * */
    public function cleardb($dbname){
        $dbnames = array();

        if(is_array($dbname)){
            foreach ($dbname as $key => $value) {
                if(!$this->is_database($value)){
                    return false;
                }
                $dbnames[] = $value;
            }
        } else {

            if(!$this->is_database($dbname)){
                return false;
            }
            $dbnames[] = $dbname;
        }
        foreach ($dbnames as $dbname) {
            $sql    = 'SHOW TABLES FROM '.$dbname;
            $query  = $this->querySQL($sql);
            while($cRow = mysqli_fetch_array($query)){
                mysqli_select_db($this->conn, $dbname);
                $this->cleartable($cRow[0]);
            }
            mysqli_select_db($this->conn, $this->dbname);
        }
        return true;
    }

    /*
     * This function is used to clear table.
     * --------------------------
     * string, array            $tblname
     * boolean                  return
     * --------------------------
     * */
    public function cleartable($tblname){
        $tblnames = array();

        if(is_array($tblname)){
            foreach ($tblname as $value) {

                if(!$this->is_table($value)){
                    return false;
                }
                $tblnames[] = $value;
            }
        } else {
            if(!$this->is_table($tblname)){
                return false;
            }
            $tblnames[] = $tblname;
        }
        foreach ($tblnames as $tblname) {
            $sql = 'TRUNCATE '.$tblname;
            $this->querySQL($sql);
        }
        return true;
    }

    /*
     * This function is used to clear table.
     * --------------------------
     * string                   $tblname
     * string, array            $column
     * boolean                  return
     * --------------------------
     * */
    public function clearcolumn($tblname, $column){
        $columns = array();

        if(!$this->is_table($tblname)){
            return false;
        }

        if(is_array($column)){
            foreach ($column as $key => $value) {
                if(!$this->is_column($tblname, $value)){
                    return false;
                }
                $columns[] = $value;
            }
        } else {
            if(!$this->is_column($tblname, $column)){
                return false;
            }
            $columns[] = $column;
        }

        foreach ($columns as $column) {

            $id   = $this->autoincrement($tblname);
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

    /*
     * It is a function used to insert data that is sent to the
     * database table in array format.
     * --------------------------
     * string                   $tblname
     * array                    $arr
     * boolean                  return
     * --------------------------
     * */
    public function insert($tblname, $arr){

        if(!$this->is_table($tblname)){
            return false;
        }

        if(!is_array($arr)){
            return false;
        }

        /*
         * Retrieving columns
         * */
        $columns = array_keys($arr);


        foreach ($columns as $column){

            /*
             * Negative response is returned if the column does not
             * exist in the table.
             * */
            if(!$this->is_column($tblname, $column)){
                return false;
            }
        }

        /*
        * Columns are converted to appropriate
        * syntax.
        * */
        $column = implode(',', $columns);

        /*
        * Data assigned to columns are converted to
        * appropriate syntax.
        * */
        $values = '\''.implode('\',\'', array_values($arr)).'\'';

        /*
        * Column and Data are converted to the appropriate
        * syntax for the sql query and assigned to the $sql
        * variable.
        * */
        $sql = 'INSERT INTO '.$tblname.'('.$column.') VALUES ('.$values.')';

        /*
        * By executing the prepared sql query.
        * */
        $this->querySQL($sql);

        return true;
    }

    /*
     * It is a function to update a record in the database
     * table with data that is sent as an array.
     * --------------------------
     * string                   $tblname
     * array                    $arr
     * int, string              $id
     * boolean                  return
     * --------------------------
     * */
    public function update($tblname, $arr, $id, $special=null){

        /*
         * Negative response is given if there is no table.
         * */
        if(!$this->is_table($tblname)){
          return false;
        }

        /*
         * If no special column name is specified, it starts
         * analysis.
         * */
        if(empty($special)){

            /*
            * The column name to which the auto_increment
            * property of the database table is assigned is
            * determined. Because in this column $id value
            * will be queried.
            * */
            $special = $this->autoincrement($tblname);

            /*
             * If there is no column with incremental feature,
             * negative response is given.
             * */
            if(empty($special)){
                return false;
            }

        }

        /*
         * If there are no records requested to be updated,
         * the negative response is returned.
         * */
        if(!$this->do_have($tblname, $id, $special)){
            return false;
        }

        /*
        * The array containing the new data is processed
        * with the foreach loop.
        * */
        foreach ($arr as $name => $value) {

            /*
             * Negative response is given if there is no
             * column.
             * */
            if(!$this->is_column($tblname, $name)){
              return false;
            }

            /*
            * New data being converted to an appropriate
            * syntax for an update query.
            * */
            $field = $name.'=\''.$value.'\'';

            /*
             * The old data is converted to an appropriate
             * syntax for an update query.
             * */
            $newfield = $special.'=\''.$id.'\'';

            /*
            * The data is inserted into the sql query and
            * assigned to the $sql variable.
            * */
            $sql = 'UPDATE '.$tblname.' SET '.$field.' WHERE '.$newfield;

            /*
            * By executing the prepared sql query.
            * */
            $this->querySQL($sql);

        }
        return true;
    }

    /*
     * A function used to delete records in the database
     * table. It is possible to send single or more
     * integers.
     * --------------------------
     * string                   $tblname
     * int, string, array       $id
     * boolean                  return
     * --------------------------
     * */
    public function delete($tblname, $id, $special=null){
        $ids = array();

        if(!$this->is_table($tblname)){
            return false;
        }

        /*
         * If no special column name is specified, it starts
         * analysis.
         * */
        if(empty($special)){

            /*
            * The column name to which the auto_increment
            * property of the database table is assigned is
            * determined. Because in this column $id value
            * will be queried.
            * */
            $special = $this->autoincrement($tblname);

            /*
             * If there is no column with incremental feature,
             * negative response is given.
             * */
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
          $this->querySQL($sql);
        }
        return true;
    }



    /*
     * This function is used to read data in a simple
     * and advanced way from the database table.
     * --------------------------
     * string                   $tblname
     * array, null              $arr
     * boolean, array, json     return
     * --------------------------
     * */
    public function get($tblname, $arr=null){

        /*
         * If the column name is not specified,
         * the entire table is queried.
         * */
        $column  = '*';

        /*
         * If properties such as limit, search, or
         * sort are not specified, no operation is
         * performed since this variable is left
         * blank.
         * */
        $special = '';

        /*
         * If the search feature is used and no word
         * is specified, it reads the records without
         * word filtering.
         * */
        $keyword = '';

        /*
         * The existence of the table name in the
         * database is queried, otherwise the $getdata
         * variable is left blank.
         * */
        if($this->is_table($tblname)){
            $getdata = array();
        } else {
            $getdata = '';
        }

        /*
         * The data is inserted into the sql query and
         * assigned to the $sql variable.
         * */
        $sql = 'SHOW COLUMNS FROM '.$tblname;

        /*
         * By executing the prepared sql query, the
         * returned response is returned.
         * */
        $query = $this->querySQL($sql);

        /*
         * If table column names are obtained, they are
         * loaded into the $columns variable.
         * */
        if(!empty($query)){
            while($row = $query->fetch_assoc()){
                $columns[] = $row['Field'];
            }

            /*
             * The column parameter is processed if sent
             * within the $arr variable.
             * */
            if(!empty($arr['column'])){

                /*
                 * If the column name is a string, it is converted
                 * to an array.
                 * */
                if(!is_array($arr['column'])){
                    $arr['column']= array($arr['column']);
                }

                /*
                 * The column names specified in the database table
                 * are being detected.
                 * */
                $arr['column'] = array_intersect($arr['column'], $columns);

                /*
                 * Column names that can be accessed from the desired
                 * columns are converted to the appropriate syntax.
                 * */
                $column = implode(',', array_values($arr['column']));

            }

            /*
             * Checking the sending of words using the search
             * feature.
             * */
            if(!empty($arr['search']['keyword'])){

                /*
                 * The word is being assigned to the $keyword variable.
                 * */
                $keyword = $arr['search']['keyword'];

                /*
                 * If the specified columns are present, they are
                 * prepared for the query process.
                 * */
                if(!empty($arr['search']['column'])){

                    /*
                     * If the columns to search are in string format, they
                     * are converted to the array.
                     * */
                    if(!is_array($arr['search']['column'])){
                        $arr['search']['column'] = array($arr['search']['column']);
                    }

                    /*
                     * The column names specified in the database table are
                     * being detected.
                     * */
                    $columns = array_intersect($arr['search']['column'], $columns);
                }

                /*
                 * If the "all" parameter used for the public search is
                 * specified, the searched word is placed between the
                 * "%" symbols.
                 * */
                if(!empty($arr['search']['where']) AND $arr['search']['where']=='all'){
                    $p = '%';
                } else {
                    $p = '';
                }

                /*
                 * If many words are specified, the foreach loop is
                 * executed. The word is combined with columns and
                 * converted into appropriate syntax.
                 * */
                if(is_array($keyword)){
                    foreach ($keyword as $key => $value) {

                        /*
                         * General or full search preference is applied.
                         * */
                        $xcontent = ' LIKE \''.$p.$value.$p.'\' OR ';
                        $ycontent = ' LIKE \''.$p.$value.$p.'\'';

                        /*
                         * Words are combined with columns and converted into
                         * appropriate syntax.
                         * */
                        $content[] = implode($xcontent, $columns).$ycontent;
                    }

                    /*
                     * The query syntax gets final.
                     * */
                    $special = 'WHERE '.implode(' OR ', $content);

                } else {

                    /*
                     * For questioning of a single word, the word is converted
                     * to the appropriate syntax.
                     * */
                    $content = implode(' LIKE \''.$p.$keyword.$p.'\' OR ', $columns);

                    /*
                     * The query syntax gets final.
                     * */
                    $special = 'WHERE '.$content.' LIKE \''.$p.$keyword.$p.'\'';
                }
            }

            /*
             * The sorting method of the obtained data
             * is checked.
             * */
            if(!empty($arr['sort'])){

                /*
                 * The column name and sort method are parsed.
                 * */
                list($columname, $sort) = explode(':', $arr['sort']);


                /*
                 * The validation of the ranking method is checked.
                 * */
                if(ctype_alpha($sort) AND in_array($sort, array('ASC','DESC'))){

                    /*
                     * The query syntax gets final.
                     * */
                    $special .= ' ORDER BY '.$columname.' '.$sort;
                }

            }

            /*
             * If customizable limit parameters are specified,
             * the necessary checks are started.
             * */
            if(!empty($arr['limit'])){

                /*
                 * If the initial value is not empty and is greater
                 * than zero, the value is written to the initial value
                 * and a comma is added. If the initial value is empty,
                 * the initial value is assumed to be zero and a comma
                 * is added.
                 * */
                if(!empty($arr['limit']['start']) AND $arr['limit']['start']>0){
                    $start = $arr['limit']['start'].',';
                } else {
                    $start = '0,';
                }

                /*
                 * If the end value is not empty and greater than zero,
                 * the value is added.
                 * */
                if(!empty($arr['limit']['end']) AND $arr['limit']['end']>0){
                    $end = $arr['limit']['end'];
                } else {

                    /*
                     * A query syntax is prepared for the sum of the records
                     * in the table.
                     * */
                    $sql     = 'SELECT * FROM '.$tblname;

                    /*
                     * The SQL syntax is executed.
                     * */
                    $query   = $this->querySQL($sql);

                    /*
                     * The total number of records obtained by the query is
                     * learned.
                     * */
                    $end     = $query->num_rows;
                }

                /*
                 * The start and end values are combined and
                 * converted to the appropriate syntax.
                 * */
                $special .= ' LIMIT '.$start.$end;

            }

            /*
             * The data is inserted into the sql query and
             * assigned to the $sql variable.
             * */
            $sql     = 'SELECT '.$column.' FROM '.$tblname.' '.$special;

            /*
             * By executing the prepared sql query, the
             * returned response is returned.
             * */
            $query   = $this->querySQL($sql);

            /*
             * If there is no data, the $query variable is
             * defined as an empty array.
             * */
            if(!$query){
                $query = array();
            }

            /*
             * It does not matter if the $query variable is
             * empty or full, it is taken into a foreach loop.
             * */
            foreach ($query as $name => $value) {
                $getdata[$name] = $value;
            }

            /*
             * If the output format of the data is specified,
             * the corresponding conversion is applied.
             * */
            if(isset($arr['format'])){
                switch ($arr['format']) {

                    /*
                     * If the output is requested as json
                     * */
                    case 'json':
                        $getdata = json_encode($getdata);
                        break;
                }
            }
        }

        /*
         * Obtained and processed data are
         * delivered.
         * */
        return $getdata;
    }

    /*
     * It is the function to query the existence of the
     * data in the database.
     * --------------------------
     * string                   $tblname
     * string                   $str
     * string, null             $column
     * boolean                  return
     * --------------------------
     * */
    public function do_have($tblname, $str, $column=null){

        /*
         * If the table name and the searched data variables
         * are not empty, the query operation starts.
         * */
        if(!empty($tblname) AND !empty($str)){

            /*
             * The keyword parameter is added to the syntax.
             * */
            $arr = array(
                'search'=> array(
                    'keyword' => $this->filter($str)
                )
            );

            /*
             * If the column value is not empty, the column name
             * is added to the query syntax, especially for
             * questioning in that column.
             * */
            if(!empty($column)){
                $arr = array(
                    'search' =>array(
                        'keyword' => $this->filter($str),
                        'column' => $this->filter($column)
                    )
                );
            }

            /*
             * The query results in returning results.
             * */
            $data = $this->get($tblname, $arr);

            /*
             * If the returned result is not empty, the
             * response will be positive, and if it is
             * empty, the response will be negative.
             * */

            if(!empty($data)){
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * A function that returns the auto_increment value
     * to be allocated for the record to be added to
     * the database table.
     * --------------------------
     * string             $tblname
     * string             return
     * --------------------------
     * */
    public function lastid($tblname){

        /*
         * In the database table, the column name with the auto-increment
         * property is defined in the column name field to be displayed in
         * the query syntax.
         * */
        $arr = array(
            'column'  =>  $this->autoincrement($tblname)
        );

        /*
         * The numbers defined by auto_increment are obtained.
         * */
        $q = $this->get($tblname, $arr);

        /*
         * If there is no record, the entire table is deleted and the
         * auto_increment value is also reset.
         * */
        if(empty($q)){

            /*
             * Resetting table.
             * */
            $this->cleartable($tblname);

            /*
             * Because the new element of the empty table is 1, 1
             * is returned.
             * */
            $id = 1;
            return $id;

        } else {

            /*
             * If the result of the query is not empty, the largest
             * of all numbers is collected with 1, and the result is
             * presented in response.
             * */
            foreach ($q as $id) {
                $d[] = $id;
            }
            return implode('', max($d))+1;

        }
    }

    /*
     * In the database table, the auto increment property is the
     * function to find the defined column name.
     * --------------------------
     * string             $tblname
     * string             return
     * --------------------------
     * */
    public function autoincrement($tblname){

        /*
         * Syntax that finds the name of the column with the ability
         * to automatically increase.
         * */
        $sql = "show columns from ".$tblname." where extra like '%auto_increment%'";

        /*
         * Running query.
         * */
        $query = $this->querySQL($sql);

        /*
         * The result is assigned to the variable.
         * */
        $row = $query->fetch_assoc();

        /*
         * The column name is returned.
         * */
        return $row['Field'];
    }

    /*
     * Queries the database entity. A positive value is returned if
     * the database exists. If the database does not exist, a
     * negative response is returned.
     * --------------------------
     * string                   $dbname
     * boolean                  return
     * --------------------------
     * */
    public function is_database($dbname){

        /*
         * Syntax is prepared.
         * */
        $sql    = 'SHOW DATABASES LIKE \''.$dbname.'\'';

        /*
         * The query is executed.
         * */
        $query  = $this->querySQL($sql);

        /*
         * A positive answer is given if the database is available. Otherwise,
         * a negative response is given.
         * */
        if($query->num_rows){
            return true;
        } else {
            return false;
        }

    }

    /*
     * It is a function used to query the entity status
     * of the database table.
     * --------------------------
     * string                   $tblname
     * boolean                  return
     * --------------------------
     * */
    public function is_table($tblname){

        /*
         * Preparing sql syntax.
         * */
        $sql     = 'DESCRIBE '.$tblname;

        /*
         * By executing the prepared sql query, the
         * returned response is returned.
         * */
        $query   = $this->querySQL($sql);

        /*
         * A true response is returned if the database
         * table exists.
         * */
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /*
     * Queries the specified column name in the specified
     * database table.
     * --------------------------
     * string                   $tblname
     * string                   $column
     * boolean                  return
     * --------------------------
     * */
    public function is_column($tblname, $column){

        /*
         * Column names in the table are obtained.
         * */
        $sql = 'SHOW COLUMNS FROM ' . $tblname;

        /*
         * By executing the prepared sql query, the
         * returned response is returned.
         * */
        $query = $this->querySQL($sql);

        /*
         * If there are column names, the columns are added to
         * the $column directory.
         * */
        if (!empty($query)) {
            while ($row = $query->fetch_assoc()) {
                $columns[] = $row['Field'];
            }
        }

        /*
         * The existence of the specified column is queried.
         * */
        if(in_array($column, $columns)){
            return true;
        } else {
            return false;
        }
    }

    /*
     * A function to check the validity of a phone number.
     * --------------------------
     * string             $str
     * boolean            return
     * --------------------------
     * */
    public function is_phone($str){

        /*
         * A positive response is returned if it is a valid phone
         * number. Negative response is given if it is not a valid
         * phone number.
         * */
        if(preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', implode('', explode(' ', $str)))) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * It is the function that checks the validity of the
     * specified date.
     * --------------------------
     * string             $date
     * string             $format
     * boolean            return
     * --------------------------
     * */
    public function is_date($date, $format = 'd-m-Y H:i:s'){

        /*
         * The time syntax is applied.
         * */
        $d = DateTime::createFromFormat($format, $date);

        /*
         * If the syntax is applied and the date is valid,
         * the response is positive. Otherwise, the response
         * is negative.
         * */
        if($d AND $d->format($format) == $date){
            return true;
        } else {
            return false;
        }
    }

    /*
     * It is the function that checks the validity of the
     * email address.
     * --------------------------
     * string             $str
     * boolean            return
     * --------------------------
     * */
    public function is_email($str){

        /*
         * If the e-mail address is valid, a positive response is
         * given, otherwise, a negative response is given.
         * */
        if(filter_var($str, FILTER_VALIDATE_EMAIL)){
            return true;
        } else {
            return false;
        }
    }

    /*
     * Checks whether the file has one of the allowed
     * extensions.
     * --------------------------
     * string               $str
     * string, array        $type
     * boolean              return
     * --------------------------
     * */
    public function is_type($str, $type){

        /*
         * If the file path is a string and the permitted file
         * extensions are not empty, the process starts.
         * */
        if(!is_array($str) AND !empty($type)){

            /*
             * The file extension is obtained from the specified
             * file path.
             * */
            $exc = $this->info($str, 'extension');

            /*
             * If the type variable is a string, it is converted
             * to an array.
             * */
            if(!is_array($type)){
                $type = array($type);
            }

            /*
             * A positive response is given if the file extension
             * is one of the allowed extensions, otherwise a
             * negative response is given.
             * */
            if(in_array($exc, $type)){
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * It is a function to check whether the file size is
     * at the specified limit.
     * --------------------------
     * array              $str
     * string             $size
     * boolean            return
     * --------------------------
     * */
    public function is_size($str, $size){

        /*
         * Byte value
         * */
        $byte = 1024;

        /*
         * Permitted dimension expressions
         * */
        $sizeLibrary = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

        /*
         * Parsing dimension expression with size.
         * */
        if(is_array($str) AND !empty($size) AND strstr($size, ' ')){

            /*
             * If there are problems with the dimension syntax,
             * return a negative response.
             * */
            if(count(explode(' ', $size))!=2){
                return false;
            }

            /*
             * Parsing dimension expression with size.
             * */
            list($number, $format) = explode(' ', $size);

            /*
             * The permission state of the dimension expression
             * is queried.
             * */
            if(in_array($format, $sizeLibrary)){

                /*
                 * The sequence number of the dimension expression
                 * is detected.
                 * */
                $id = array_search($format, $sizeLibrary);

                /*
                 * The size sequence number is also multiplied by
                 * representing the multiple of the number.
                 * */
                $calc = $number*pow($byte, $id);

                /*
                 * The size of the file in bytes is compared to the
                 * file size converted to byte. If the file size is
                 * small, the response will be positive, otherwise
                 * it will be negative.
                 * */
                if($str['size']<$calc){
                    return true;
                } else {
                    return false;
                }

            } else {

                /*
                 * If the permitted size types are not specified, the
                 * negative response is returned.
                 * */
                return false;
            }
        }
    }

    /*
     * This function checks if the specified parameter is
     * a valid color.
     * --------------------------
     * string             $color
     * boolean            return
     * --------------------------
     * */
    public function is_color($color){

        /*
         * All of the color names in the range of 0-147 working
         * in all browsers are taken into the array.
         * */
        $colorArray = json_decode('["AliceBlue","AntiqueWhite","Aqua","Aquamarine","Azure","Beige","Bisque","Black","BlanchedAlmond","Blue","BlueViolet","Brown","BurlyWood","CadetBlue","Chartreuse","Chocolate","Coral","CornflowerBlue","Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed ","Indigo ","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","RebeccaPurple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen"]', true);

        /*
         * If the specified color is one of the color names between
         * 0-147, the response is positive.
         * */
        if(in_array($color, $colorArray)){
            return true;
        }

        /*
         * transparent
         * If the specified value is transparent, the response
         * is positive.
         * */
        if($color == 'transparent'){
            return true;
        }

        /*
         * #000000
         * If the specified value is hex, the response is
         * positive.
         * */
        if(preg_match('/^#[a-f0-9]{6}$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        /*
         * rgb(10, 10, 20)
         * If the specified value is rgb, the response is
         * positive.
         * */
        if(preg_match('/^rgb\((?:\s*\d+\s*,){2}\s*[\d]+\)$/', mb_strtolower($color, 'utf-8'))) {
            return true;
        }

        /*
         * rgba(100,100,100,0.9)
         * If the specified value is rgba, the response is
         * positive.
         * */
        if(preg_match('/^rgba\((\s*\d+\s*,){3}[\d\.]+\)$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        /*
         * hsl(10,30%,40%)
         * If the specified value is hls, the response is
         * positive.
         * */
        if(preg_match('/^hsl\(\s*\d+\s*(\s*\,\s*\d+\%){2}\)$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        /*
         * hsla(120, 60%, 70%, 0.3)
         * If the specified value is hlsa, the response is
         * positive.
         * */
        if(preg_match('/^hsla\(\s*\d+(\s*,\s*\d+\s*\%){2}\s*\,\s*[\d\.]+\)$/i', mb_strtolower($color, 'utf-8'))){
            return true;
        }

        /*
         * Negative response is given if it is not a valid
         * color.
         * */
        return false;

    }

    /*
    * Checks if the specified value is a valid URL. It also
    * has the ability to edit the url syntax and present it
    * in response.
    * --------------------------
    * string                   $url
    * boolean, null            $fix
    * boolean, string          return
    * --------------------------
    */
    public function is_url($url){

        // example.com/ -> http://www.example.com/
        if(!strstr($url, '://') AND !strstr($url, 'www.')){
            $url = 'http://www.'.$url;
        }

        // www.example.com -> http://www.example.com
        if(!strstr($url, '://') AND strstr($url, 'www.')){
            $url = 'http://'.$url;
        }

        // http://example.com/ -> http|https://www.example.com/
        if(strstr($url, '://') AND !strstr($url, 'www')){
            list($left, $right) = explode('://', $url);
            $url = $left.'://www.'.$right;
        }

        /*
         * Negative response is given if it is not a valid URL.
         * A positive answer is given if it is a valid url.
         * */
        if(!preg_match( '/^(http|https|www):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$url)){
            return false;
        } else {
            return true;
        }
    }

    /*
     * It is a function that provides access to various
     * information in the file path.
     * --------------------------
     * string             $str
     * string             $type
     * string             return
     * --------------------------
     * */
    public function info($str, $type){

        /*
         * The information in the file path is collected.
         * */
        $object = pathinfo($str);

        /*
         * Specifically, the requested information is returned.
         * */
        return $object[$type];
    }

    /*
     * It is the function to disable the attack codes
     * targeting the database or users.
     * --------------------------
     * string                   $str
     * string, array            return
     * --------------------------
     * */
    public function filter($str){

        /*
         * If the data to be filtered is sent as an array,
         * all items are filtered individually and the
         * filtered array is returned.
         * */
        if(is_array($str)){
            foreach ($str as $key => $value) {
                $x[] = $this->filter($value);
            }
            return $x;
        } else {

            /*
             * The filter uses the mysqli_real_escape_string function
             * and the FILTER_SANITIZE_FULL_SPECIAL_CHARS property of
             * the filter_var function, and the filtered data is
             * returned.
             * */
            return mysqli_real_escape_string($this->conn, filter_var($str,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

    }

    /*
     * $_GET is a function that interprets $_POST,
     * $_FILES requests.
     * */
    public function request(){

        /*
         * $_GET, $_POST, $FILES requests are checked
         * for presence.
         * */
        if(isset($_POST) OR isset($_GET) OR isset($_FILES)){

            /*
             * All requests are put into the same cluster and
             * processed with the help of the foreach loop.
             * */
            foreach (array_merge($_POST, $_GET, $_FILES) as $name => $value) {

                /*
                 * If the request carries a parameter such as
                 * multiple files or multiple selections in an
                 * array format, the request is processed to
                 * become available.
                 * */
                if(is_array($value)){
                    foreach($value as $key => $all ){

                        /*
                         * If the request carries a large number of parameters,
                         * an arrangement is made for practical access to the
                         * parameters.
                         * */
                        if(is_array($all)){
                            foreach($all as $i => $val ){

                                /*
                                 * Multiple request parameters are controlled by
                                 * the filter method.
                                 * */
                                $this->post[$name][$i][$key] = $this->filter($val);
                            }
                        } else {

                            /*
                             * The request that carries the single parameter
                             * is controlled by the filter method.
                             * */
                            $this->post[$name][$key] = $this->filter($all);
                        }
                    }
                } else {

                    /*
                     * If the request parameter is not an array, it is
                     * controlled by the filter method.
                     * */
                    $this->post[$name] = $this->filter($value);
                }
            }
        }
    }

    /*
     * A function for routing.
     * --------------------------
     * string,null              $url
     * redirect                 return
     * --------------------------
     * */
    public function redirect($url=null){

        /*
         * If it is empty, a redirect occurs to the project directory.
         * */
        if(empty($url)){
            $url = $this->baseurl;
        }

        header('Location: '.$url);

        /*
         * In the tests performed, it was seen that the process is
         * continuing when this parameter is not specified.
         * */
        exit();
    }

    /*
     * It is the auxiliary function created for the route
     * function. The responsibility for this function is
     * to include the specified file or files if they were
     * created.
     --------------------------
     * string, array            $file
     * string, array, null      $cache
     * include                  return
     * --------------------------
     *
     * */
    private function mindload($file, $cache=null){

        /*
         * If the file or cache variable is not empty, the evaluations
         * are started.
         * */
        if(!empty($file) OR !empty($cache)){

            /*
             * If a file defined for the cache is specified in a string
             * type, it is converted to an array.
             * */
            if (!empty($cache) AND !is_array($cache)) {
                $cache = array($cache);
            }

            /*
             * If the cache variable is not empty, the boot starts.
             * */
            if (!empty($cache)) {
                foreach ($cache as $cachefile) {

                    /*
                     * The cache file is included if available.
                     * */
                    if (file_exists($cachefile . '.php')) {
                        require_once($cachefile . '.php');
                    }
                }
            }

            /*
             * If the file variable is not empty, the process is
             * started.
             * */
            if(!empty($file)){

                /*
                 * The variable in which the files are kept is defined as
                 * an array.
                 * */
                $files = array();

                /*
                 * If the incoming value is not in the array format, it is
                 * converted to the array format.Otherwise, the files are
                 * assigned to the variable as is.
                 * */
                if(!is_array($file)){
                    $files = array($file);
                } else {
                    $files = $file;
                }

                /*
                 * Files are uploaded to the project with the help of the foreach cycle.
                 * */
                foreach ($files as $file){

                    /*
                     * The file is loaded if available.
                     * */
                    if (file_exists($file . '.php')) {
                        /*
                         * The file is added to the page.
                         * */
                        require_once($file . '.php');
                    }
                }
            }
        }
    }

    /*
     * Converts the specified parameter to a seo-friendly
     * url structure.
     * --------------------------
     * string                   $str
     * array, null              $options
     * string                   return
     * --------------------------
     * */
    public function permalink($str, $options = array()){

        /*
         * Ensure that the data is UTF-8, and invalid UTF-8
         * characters are extracted.
         * */
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        /*
         * Default settings
         * */
        $defaults = array(
            /*
             * Separator parameter
             * */
            'delimiter' => '-',

            /*
             * Length of data to return
             * */
            'limit' => null,

            /*
             * It is used to convert the size of the rotating data
             * to small size or leave it as it is.
             * */
            'lowercase' => true,

            /*
             * Used for value change operation
             * */
            'replacements' => array(),

            /*
             * Use special alphabets characters
             * */
            'transliterate' => true
        );


        /*
         * Character sets of languages with special characters
         * */
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

        /*
         * If a value change request exists and the data is sent in
         * an array format, the value change is initiated.
         * */
        if(!empty($options['replacements']) AND is_array($options['replacements'])){
            foreach ($options['replacements'] as $objName => $val) {

                /*
                 * The value is changing
                 * */
                $str = str_replace($objName, $val, $str);

            }
        }


        /*
         * All settings are being merged.
         * */
        $options = array_merge($defaults, $options);

        /*
         * Non-alphanumeric characters are replaced by a separator
         * symbol.
         * */
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        /*
         * Repeated separator symbols are removed.
         * */
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        /*
         * The length of the output value is determined.
         * */
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        /*
         * The separator symbol is replaced by spaces.
         * */
        $str = trim($str, $options['delimiter']);

        /*
         * Optionally, all parameters are converted to lowercase or
         * allowed to remain the same size. It is then returned.
         * */
        if($options['lowercase']){
            return mb_strtolower($str, 'UTF-8');
        } else {
            return $str;
        }

    }

    /*
     * It is used to obtain a list of compatible time
     * zones as an array.
     * --------------------------
     * array                return
     * --------------------------
     * */
    public function timezones(){

        /*
         * The list of time zones is returned.
         * */
        return timezone_identifiers_list();
    }

    /*
     * It is the function that provides session control.
     * */
    public function session_check(){

        /*
         * If the session is allowed
         * */
        if($this->sessset['status_session']){

            /*
             * If customized session directory is enabled
             * */
            if($this->sessset['path_status']){

                /*
                 * It is created if the directory where the data is
                 * stored is not found.
                 * */
                if(!is_dir($this->sessset['path'])){

                    /*
                     * Create the Session folder and set permissions.
                     * */
                    mkdir($this->sessset['path']); chmod($this->sessset['path'], 755);

                    /*
                     * Create a .htaccess file to prevent direct access.
                     * */
                    $this->write('deny from all', $this->sessset['path'].'/.htaccess');

                    /*
                     * Set the permissions of the .htaccess file.
                     * */
                    chmod($this->sessset['path'].'/.htaccess', 644);
                }

                /*
                 * The session directory is introduced to php.
                 * */
                ini_set(
                    'session.save_path',
                    realpath(
                        dirname(__FILE__)
                    ).'/'.$this->sessset['path']
                );
            }

            /*
             * If the session is not started, a session is started.
             * */
            if(!isset($_SESSION)){
                session_start();
            }

        }
    }

    /*
    * It is an easy to use routing function.
    * --------------------------
    * string                   $uri
    * string                   $file
    * string, array, null      $cache
    * include, boolean         return
    * --------------------------
    */
    public function route($uri, $file, $cache=null){

        /*
         * The variable in which htaccess settings are required
         * for the route operation.
         * */
        $public_htaccess = implode("\n", array(
            'RewriteEngine On',
            'RewriteCond %{REQUEST_FILENAME} -s [OR]',
            'RewriteCond %{REQUEST_FILENAME} -l [OR]',
            'RewriteCond %{REQUEST_FILENAME} -d',
            'RewriteRule ^.*$ - [NC,L]',
            'RewriteRule ^.*$ index.php [NC,L]'
        ));

        /*
         * The code to be added to the htaccess file that prevents
         * access to the folder is specified.
         * */
        $private_htaccess = "Deny from all";

        /*
         * The exact location of the htaccess file
         * */
        $htaccess_file = '.htaccess';

        /*
         * If the htaccess file is not created, it is created.
         * */
        if(!file_exists($htaccess_file)){
            $this->write($public_htaccess, $htaccess_file);
        }

        /*
         * Folders in the directory are obtained.
         * */
        $dirs = array_filter(glob('*'), 'is_dir');

        /*
         * If a folder is detected, the process starts for each
         * folder name.
         * */
        if(!empty($dirs)){
            foreach ($dirs as $dir){

                /*
                 * If there is no htaccess file that prevents access to the
                 *  folder, it is created.
                 * */
                if(!file_exists($dir.'/'.$htaccess_file)){
                    $this->write($private_htaccess, $dir.'/'.$htaccess_file);
                }

            }
        }

        /*
         * If the file variable is empty, a negative response is
         * given.
         * */
        if(empty($file)){
            return false;
        }

        /*
         * The main directory is removed from the current address
         * to define the $request variable.
         * */
        $request = str_replace($this->baseurl, '', $_SERVER['REQUEST_URI']);

        /*
         * Temporary variables are predefined.
         * */
        $tfields    = array();
        $fields     = array();

        /*
         * If $uri is not empty, the process starts.
         * */
        if(!empty($uri)){

            /*
             * The address and parameter are parsed.
             * */
            if(strstr($uri, ':')){

                /*
                 * Decomposition is performed.
                 * */
                $tfields = array_filter(explode(':', $uri));

                /*
                 * A valid data is defined as uri, if any.
                 * */
                if(count($tfields)==1){
                    $uri = implode('', $tfields);
                }
            }

            /*
             * The resolved address and parameter are interpreted if
             * appropriate.
             * */
            if(!empty($tfields) AND count($tfields)==2){

                /*
                 * Address and parameter are parsing.
                 * */
                list($uri, $tfields) = $tfields;

                /*
                 * If there is a multi-parameter state, each parameter
                 * is added to array. If not, it is added to the array.
                 * */
                if(strstr($tfields, '@')){
                    $fields = array_filter(explode('@', $tfields));
                } else {
                    $fields = array($tfields);
                }
            }
        }

        /*
         * If the slash symbol is used, the main directory path
         * is defined as $uri.
         * */
        if($uri == '/'){
            $uri = $this->baseurl;
        }

        /*
         * The default parameter variable is set to array.
         * */
        $params = array();

        /*
         * If the parameter is present, the process is started.
         * */
        if(strstr($request, '/')){

            /*
             * The $uri is removed from the request parameter.
             * */
            $step1 = str_replace($uri, '', $request);

            /*
             * The parameters are parsed.
             * */
            $step2 = explode('/', $step1);

            /*
             * Invalid parameters are filtered.
             * */
            $step3 = array_filter($step2);

            /*
             * Sequence numbers are reset after filtering.
             * */
            $params = array_values($step3);
        }

        /*
         * If a form is not posted, the parameter is interpreted.
         * */
        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            /*
             * The variable is cleared.
             * */
            $this->post = array();

            /*
             * If there are parameter names, the process is started.
             * */
            if(!empty($fields)){

                /*
                 * Parameter names are executed with the help of foreach.
                 * */
                foreach ($fields as $key => $field) {

                    /*
                     * If there is a parameter with the specified sequence number
                     * and it is not empty, it is added to $this->post variable.
                     * */
                    if(!empty($params[$key])){
                        $this->post[$field] = $params[$key];
                    }
                }
            } else {

                /*
                 * If parameter names are not specified, the parameters are
                 * added to $this->post.
                 * */
                $this->post = $params;
            }
        }



        /*
         * If the request is not empty, the process is started.
         * */
        if(!empty($request)){

            /*
             * Searching $uri address in request.  If found, the mind of
             * that desire is being loaded.
             * */
            if(strstr($request, $uri)){
                $this->mindload($file, $cache);
                exit();
            }
        } else {

            /*
             * If the $uri address is the same as the main directory address,
             * the specified mind is loaded. If not, stops the operation.
             * */
            if($uri == $this->baseurl){
                $this->mindload($file, $cache);
                exit();
            } else {
                exit();
            }
        }
    }

    /*
     * A function that adds the specified content to the
     * file. If the file does not exist, it creates the
     * file and inserts the specified content into the
     * file.
     * --------------------------
     * string, array      $str
     * string             $path
     * --------------------------
     * */
    public function write($str, $path) {

        /*
         * If the data type is in the array structure, the array
         * elements are parsed. If the data type is not an array,
         * it is treated as is.
         * */
        if(is_array($str)){
            $content 	= implode(':', $str);
        } else {
            $content    = $str;
        }

        /*
         * If content exists, the process is started.
         * */
        if(isset($content)){

            /*
             * The specified file path is opened.
             * */
            $writedb 		= fopen($path, "a+");

            /*
             * The content is added to the file.
             * */
            fwrite($writedb, $content."\r\n");

            /*
             * The file that is opened for writing is closed
             * after the process is finished.
             * */
            fclose($writedb);
        }

    }

    /*
     * A function used to load file or files.
     * --------------------------
     * array              $files
     * string             $path
     * array, boolean     return
     * --------------------------
     * */
    public function upload($files, $path){

        $response = array();

        /*
         * If there is a path, the process is started.
         * */
        if(is_dir($path)){

            /*
             * If the file variable is not empty and carries a
             * single file, it is transferred to the array.
             * */
            if(!empty($files) AND !isset($files[0])){
                $files = array($files);
            }

            /*
             * Files are interpreted in the loop.
             * */
            foreach ($files as $file){

                /*
                 * The process starts if the file name exists.
                 * */
                if(!empty($file['name'])){

                    /*
                     * The file extension is retrieved.
                     * */
                    $ext        = $this->info($file['name'], 'extension');

                    /*
                     * The unique file name is created and combined with path.
                     * */
                    $newpath    = $path.'/'.md5(date('d-m-Y g:i:s').gettimeofday()['usec']).'.'.$ext;

                    /*
                     * File uploaded.
                     * */
                    move_uploaded_file($file['tmp_name'], $newpath);

                    /*
                     * Added file path to the array to be returned.
                     * */
                    $response[] = $newpath;

                }

            }

        }

        /*
         * An empty array is returned if the installation fails.
         * */
        return $response;
    }

    /*
    * This function is used to retrieve records that have
    * containers specified from the specified URL or content.
    * --------------------------
    * string                   $left
    * string                   $right
    * null, array              return
    * --------------------------
    * */
    public function get_contents($left, $right, $url){



        /*
         * The operation run time is made unlimited.
         * */
        set_time_limit(0);

        /*
         * The result variable default is defined as null.
         * */
        $result = array();

        /*
         * If the URL is specified, the source code of the
         * link page is retrieved and assigned to the data
         * variable.
         * */
        if($this->is_url($url)) {

            /*
             * Connection is provided without using SSL.
             * */
            $arrContextOptions = stream_context_create(array(
                'ssl' => array(
                    'verify_peer' 		=> false,
                    'verify_peer_name' 	=> false,
                )
            ));

            /*
             * If the URL does not have the proper syntax for the
             * connection and the second parameter is correctly
             * specified, the url syntax is corrected and the
             * connection is established.
             * */
            $data = file_get_contents($url, false, $arrContextOptions);
        } else {

            /*
             * If the specified value is not a url, it is assigned
             * to the data variable because it is a content.
             * */
            $data = $url;
        }

        /*
         * Some gaps are removed for easier processing of
         * the resulting content.
         * */
        $content = str_replace(array("\n", "\r", "\t"), '', $data);

        /*
         * Left and Right containers are searched.
         * */
        if(preg_match_all('/'.preg_quote($left, '/').'(.*?)'.preg_quote($right, '/').'/i', $content, $result)){

            /*
             * If a record is detected in the specified range.
             * */
            if(!empty($result)){

                /*
                 * The result is returned by ignoring the first record.
                 * */
                return array_unique($result[1]);
            } else {

                /*
                 * If there is no result, a blank answer is given.
                 * */
                return $result;
            }
        }
    }


}
new Mind;


?>
