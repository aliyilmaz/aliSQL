
# What is Mind?

In projects developed with `PHP` and `MySQL`; Database and route operations, `$_GET`, `$_POST`, `$_FILES` requests, PHP code framework that simplifies the management of various control layers such as `Model`, `View`, `Controller`, `Middleware`.

To create new design patterns and frameworks, Mind offers great tools. Because it is easy to create a custom design pattern for your needs, the features that will always remain small remain small. It enables controlled and safe growth for a growing project.

---------- 

## Download

You can download the Mind class from [GitHub page](https://github.com/aliyilmaz/Mind/archive/master.zip) or proceed to the next step by running the `composer require mind/mind` command from the command client.

---------- 

## Database settings

To use the class, you must define the database information in the `Mind.php` file or when calling the class.

#### Example

    private $host        = 'localhost';
    private $dbname      = 'mydb';
    private $username    = 'root';
    private $password    = '';
    
or

    $conf = array(
        'host'      =>  'localhost',
        'dbname'    =>  'mydb',
        'username'  =>  'root',
        'password'  =>  ''
    );
    $Mind = new Mind($conf);

----------

## Installation

After adding `Mind.php` to the project with a method like `require_once`, it is possible to get the class ready for use with the command `extends` or `new Mind()`.

#### Example

    require_once('./Mind.php');
    use Mind\Mind;
    $Mind = new Mind();

or

    require_once('./Mind.php');
    class ClassName extends Mind\Mind{
    
    }

----------

## Session settings

This is the part used to customize or close sessions created for users. To close sessions, simply set the session_status parameter to `false`. To change the folder path where the sessions are stored, the `path` parameter must be updated. To keep sessions on the specified path, the `path_status` parameter must be set to `true`. By default, the server is configured according to the session settings.

#### Example

    private $sessset    = array(
        'path'              =>  './session/',
        'path_status'       =>  false,
        'status_session'    =>  true
    );

----------


## Time zones settings

It is possible to personalize the time zone to mark the content with the correct time zone. By default `Europe/Istanbul` is defined. The `public` property is defined to allow access from outside the class. See the [List of Supported Timezones](https://secure.php.net/manual/en/timezones.php) section.

**Info:** Servers that are not as personalized as required may use different time periods from the project timeframe. Editing in this section allows you to have the correct timestamp on different servers. 

#### Example

    public $timezone    = 'Europe/Istanbul';

----------

## Active Methods

Methods that meet requirements such as session management, database connectivity, `$_GET`, `$_POST`, and `$_FILES` requests are enabled by running the `__construct()` method in the `Mind.php` file.

-   [session_check()](#session_check)
-   [connection()](#connection)
-   [request()](#request)

----------

## Active variables

##### private $ conn

The database connection is held in `$this->conn`. To prevent access from outside the class `private` property is defined.

##### public $ post

The `$_GET`,`$_POST` and `$_FILES` requests made in the project where the class is included are kept in `$this-> post`. To allow access from outside the classroom, the `public` property is defined.

##### public $ baseurl

The path of the folder where `Mind.php` is located is kept in `$this->baseurl`, and `public` is defined to allow access from outside the class.

----------

## Methods

##### Database

-   [connection](#connection)
-   [prepare](#prepare)
-   [cGeneration](#cGeneration)
-   [pGeneration](#pGeneration)
-   [createdb](#createdb)
-   [createtable](#createtable)
-   [createcolumn](#createcolumn)
-   [deletedb](#deletedb)
-   [deletetable](#deletetable)
-   [deletecolumn](#deletecolumn)
-   [cleardb](#cleardb)
-   [cleartable](#cleartable)
-   [clearcolumn](#clearcolumn)
-   [insert](#insert)
-   [update](#update)
-   [delete](#delete)
-   [get](#get)
-   [do_have](#do_have)
-   [newid](#newid)
-   [increments](#increments)

##### Validator

-   [is_db](#is_db)
-   [is_table](#is_table)
-   [is_column](#is_column)
-   [is_phone](#is_phone)
-   [is_date](#is_date)
-   [is_email](#is_email)
-   [is_type](#is_type)
-   [is_size](#is_size)
-   [is_color](#is_color)
-   [is_url](#is_url)
-   [is_json](#is_json)

##### Helper

-   [info](#info)
-   [filter](#filter)
-   [request](#request)
-   [redirect](#redirect)
-   [mindload](#mindload)
-   [permalink](#permalink)
-   [timezones](#timezones)
-   [session_check](#session_check)

##### System

-   [route](#route)
-   [write](#write)
-   [upload](#upload)
-   [get_contents](#get_contents)

----------

## connection()

It is used to provide database connection in the light of the information specified in the [installation](#installation) phase. It was run in `__construct()` method in `Mind.php` file.

----------

## prepare()

It is used to run SQL queries, it has `public` definition to send `SQL` query from outside the class. The `SQL` query can be sent as `string`.
   
##### Example

    $Mind->prepare($sql);

----------

## cGeneration()
This function is used to create the syntax of the `sql`, which should be written when creating a database table or column. The syntax of `sql` is generated by the interpretation of the schema that is sent to the `createtable` and `createcolumn` methods.

----------

## pGeneration()
This function is used to parse the parameterized address sent to `route` and `mindload`.

----------

## createdb()

Used to create new one or more databases. `mydb0` and` mydb1` represent the database names. Database creation occurs when the database names to be created are sent as `string` or `array`. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $this->createdb('mydb0');

or

    $this->createdb(array('mydb0','mydb1'));
    
----------
    
## createtable()

Used to create a new database table. If the operation is successful, `true`, otherwise `false` is returned.

##### Features

-   int - (`int`)
-   decimal - (`decimal`)
-   string - (`varchar`)
-   small - (`text`)
-   medium - (`mediumtext`)
-   large - (`longtext`)
-   increments - (`auto_increment`)

##### Example

    $scheme = array(
        'id:increments',
        'username:small',
        'password',
        'address:medium',
        'about:large',
        'amount:decimal:6,2',
        'title:string:120',
        'age:int'
    );
    $this->createtable('phonebook', $scheme);
    
****Info:**** For more information about creating a column, see the [createcolumn](#createcolumn) method.

----------

## createcolumn()

Used to create one or more columns in a database table. Column name and property can be sent as `array`. If the operation succeeds, it is returned `true`, otherwise `false`.

##### Features

-   int - (`int`)
-   decimal - (`decimal`)
-   string - (`varchar`)
-   small - (`text`)
-   medium - (`mediumtext`)
-   large - (`longtext`)
-   increments - (`auto_increment`)

#### Example

    $scheme = array(
        'id:increments',
        'username:small',
        'password',
        'address:medium',
        'about:large',
        'amount:decimal:6,2',
        'title:string:120',
        'age:int'
    );
    $this->createcolumn('phonebook', $scheme);


#### int

Used to hold numbers. It takes 3 parameters. `number`:`int`:`11` is the name of the first parameter column. The second parameter is the column type. The third parameter is the maximum limit of the column values. The third parameter is not mandatory, if not specified it defaults to `11`.

##### Example

    $scheme = array(
        'number:int:12'
    );
    $this->createtable('phonebook', $scheme);
    
or

    $scheme = array(
        'number:int'
    );
    $this->createtable('phonebook', $scheme);
 
 
 #### decimal
 
 Used to hold monetary values, takes 3 parameters. `amount`:`decimal`:`6,2` The first parameter is the column name. The second parameter is the column type. The third parameter is the value that the column takes. The third parameter is not mandatory, if not specified it defaults to `6,2`.
 
 ##### Example
 
     $scheme = array(
         'amount:decimal:6,2'
     );
     $this->createtable('phonebook', $scheme);
     
or

 
     $scheme = array(
         'amount:decimal'
     );
     $this->createtable('phonebook', $scheme);
     
#### string (varchar)

Used to hold string data with the specified character length. It takes 3 parameters. `title`:`string`:`120` is the name of the first parameter column. The second parameter is the column type. The third parameter represents the maximum number of characters of the string that the column moves. The third parameter is not mandatory, if not specified it defaults to `11`.

  ##### Example
   
   $scheme = array(
       'title:string:120'
   );
   $this->createtable('phonebook', $scheme);
       
  or
  
   
       $scheme = array(
           'title:string'
       );
       $this->createtable('phonebook', $scheme);
     
#### small (text)

It is used to hold the string data which is `65535` characters long. It takes 2 parameters. `content`:`small` is the name of the first parameter column, the second parameter is the type of the column. The second parameter is not mandatory. If the second parameter is not specified, the column defaults to `small`.

 ##### Example
   
       $scheme = array(
           'content:small'
       );
       $this->createtable('phonebook', $scheme);
       
  or
  
   
       $scheme = array(
           'content'
       );
       $this->createtable('phonebook', $scheme);
       
#### medium (mediumtext)

It is used to hold the string data which is `16777215` characters long. It takes 2 parameters. `description`:`medium` is the first parameter column name, the second parameter is the column type. Both parameters have to be specified.

 ##### Example
   
       $scheme = array(
           'description:medium'
       );
       $this->createtable('phonebook', $scheme);
  
#### large (longtext)

It is used to hold the string data which is `4294967295` characters long. It takes 2 parameters. `content`:`large` is the first parameter column name, the second parameter is the column type. Both parameters have to be specified.

 ##### Example
   
       $scheme = array(
           'content:large'
       );
       $this->createtable('phonebook', $scheme);     

#### increments (auto_increment)

It is used to have an automatically incrementing number of entries added to the database table. It takes 3 parameters. `id`:`increments`:`11` is the name of the first parameter column. The second parameter is the column type. The third parameter represents the maximum limit of the increase. The third parameter is not mandatory, if not specified it defaults to `11`.

 ##### Example
   
       $scheme = array(
           'id:increments:12'
       );
       $this->createtable('phonebook', $scheme);
       
  or
  
   
       $scheme = array(
           'id:increments'
       );
       $this->createtable('phonebook', $scheme);

----------

## deletedb()

Used to delete one or more databases, `mydb0` and` mydb1` represent the database names, `string` or `array` database names are sent as the database deletion occurs. If the operation is successful, `true`, otherwise` false' is returned.

##### Example

    $this->deletedb('mydb0');

or

    $this->deletedb(array('mydb0','mydb1'));

----------

## deletetable()

It is used to delete one or more database tables, `my_table0` and `my_table1` represent the database table names, deletion is performed when table names are sent as `string` or `array`. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $this->deletetable('my_table0');

or

    $this->deletetable(array('my_table0', 'my_table1'));

----------

## deletecolumn()

Used to delete one or more columns in the database table. `users` represents the table name, `username` and `password` the columns that are to be deleted. When the column names are sent as `string` or `array`, deletion is performed. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $this->deletecolumn('users', 'username');

or

    $this->deletecolumn('users', array('username', 'password'));

----------

## cleardb()

Used to delete one or more database contents (including auto_increment values), `mydb0` and `mydb1` represent the database names. Deletes when database names are sent as `string` or `array`. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $this->cleardb('mydb0');

or

    $this->cleardb(array('mydb0','mydb1'));
    
----------

## cleartable()

Used to delete all records (including auto_increment values) in one or more database tables. Database table names can be sent as `string` or `array` . `my_table0` and `my_table1` represent the database table names. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $this->cleartable('my_table0');

or

    $this->cleartable(array('my_table0', 'my_table1'));

----------

## clearcolumn()

Used to delete all records belonging to one or more columns in a database table. Column names can be sent as `string` or `array`. `username` and `password` represent column names. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $this->clearcolumn('username');

or

    $this->clearcolumn(array('username', 'password'));
    
----------

## insert()

Used to add one or more records to a database table. `my_table` represents the database table name,`title`, `content` and `tag` represents columns in the table `my_table`. When the values are sent in `array`, the recording is performed. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $query = $this->insert('my_table', array(
    	'title' => 'test user',
    	'content' => '123456',
    	'tag' => 'test@mail.com'
    ));

or

    $query = $this->insert('my_table', array(
            array(
                'name'          => 'Ali Yılmaz',
                'phone'         => '10101010101',
                'email'         => 'aliyilmaz.work@gmail.com',
                'created_at'    =>  date('d-m-Y H:i:s')
            ),
            array(
                'name'          => 'Deniz Yılmaz',
                'phone'         => '20202020202',
                'email'         => 'deniz@gmail.com',
                'created_at'    =>  date('d-m-Y H:i:s')
            ),
            array(
                'name'          => 'Hasan Yılmaz',
                'phone'         => '30303030303',
                'email'         => 'hasan@gmail.com',
                'created_at'    =>  date('d-m-Y H:i:s')
            )
        )
    );

----------

## update()

Used to update a record in the database table. `my_table` represents the database table name. `title`, `content` and `tag` represent columns in `my_table` table. The `17` represents the `id` of the record to be updated. When the new values are sent as `array`, the update process takes place. To search the `id` parameter in a column whose `auto_increment` property is not defined, it is necessary to specify the column name in parameter 4. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $query = $this->update('my_table', array(
    	'title' => 'test user',
    	'content' => '123456',
    	'tag' => 'example@mail.com'
    ),17);

or

    $query = $this->update('my_table', array(
    	'title' => 'test user',
    	'content' => '123456',
    	'tag' => 'example@mail.com'
    ),'test user', 'title');

----------

## delete()

Used to delete one or more records in the database table. `my_table` represents the database table name,`14` is a record that is to be deleted, `15` and `16` represent the id of the records to be deleted. Deleting records occurs when the ids are sent as `string` or `array`. To search the `id` parameter in a column whose `auto_increment` property is not defined, it is necessary to specify the column name in parameter 3. If the operation is successful, `true`, otherwise `false` is returned.

##### Example

    $this->delete('my_table',14);

or

    $this->delete('my_table',array(15,16));

or

    $this->delete('my_table',14, 'age');

or

    $this->delete('my_table',array(15,16), 'age');

----------

## get()

Used to obtain records in a database table as they are or by filtering. `my_table0` shows the table name, `$arr` parameters and usage examples are given below.

#### Access all records

Used to obtain all records of a database table. It is possible to use it without the need for an extra parameter, but obtaining a large number of data at one time can reduce project performance by creating a load on the server and user side.


##### Example

    print_r($this->get('my_table0'));



#### column: Reach the table columns

It is used to obtain the specified column data in a database table. Because it does not retrieve all column data, it allows a lighter query. `column` represents the name of the property, `title` and `tag`, representing the column names.

##### Example

    $arr = array(
    	'column' => array(
    	      'title',
    	      'tag'
    	)
    );
    print_r($this->get('my_table0',$arr));

or

    $arr = array(
    	'column' => 'title'
    );
    print_r($this->get('my_table0',$arr));


#### limit: Reach record range

It is used to retrieve the records in the database according to the specified limits. `limit` represents the name of the feature, `start` and `end` represents the sub-feature names. In order to obtain the recording interval, `start` and `end` must be specified.

##### Example

    $arr = array(
    	'limit' => array('start'=>'1', 'end'=>'10')
    );
    print_r($this->get('my_table',$arr));
    

#### limit:start Ignoring first records

Used to ignore the specified number of old records.`limit` represents the name of the feature, `start` represents the amount of record to be ignored.

##### Example

    $arr = array(
    	'limit' => array('start'=>'2')
    );
    print_r($this->get('my_table',$arr));


#### limit:end Recording up to the specified amount

Used to obtain the specified number of records in the database. `limit` represents the name of the feature, `end` represents the desired amount of recording.

##### Example

    $arr = array(
    	'limit' => array('end'=>'10')
    );
    print_r($this->get('my_table',$arr));




#### sort: Sort records

Used to sort records in database table from small to large or from small to small according to specified column content. `sort` represents the name of the property, `columnname` represents the column name for sorting, `ASC` represents the request for sorting from small to large, `DESC` represents the request for sorting from large to small.

##### Example

    $arr = array(
    	'sort' => 'columnname:ASC'
    );
    print_r($this->get('my_table',$arr));

or

    $arr = array(
    	'sort' => 'columnname:DESC'
    );
    print_r($this->get('my_table',$arr));


#### search: Searching

Used to search for keywords in a database table. Keywords can be sent as `string` or `array`. `search` represents the name of the feature, `keyword` represents the searched keywords.

##### Example

    $arr = array(
        'search' => array(
            'keyword'=> array(
                'hello world!',
                'merhaba dünya'
            )
        )
    );
    print_r($this->get('my_table0',$arr));

or

    $arr = array(
    	'search' => array(
    		'keyword'=> 'merhaba dünya'
    	)
    );
    print_r($this->get('my_table0',$arr));


#### search:where Broad match search

Used to search for keywords in the database table as broad match. Words can be sent as `string` or` array`. `where` represents the name of the feature,`keyword` represents the searched words. To use this feature, the `all` parameter must be specified.

##### Example

    $arr = array(
    	'search' => array(
    		'keyword'=>array(
    			'hello world!',
    			'merhaba dünya'
    		),
    		'where'=>'all'
    	)
    );
    print_r($this->get('my_table',$arr));

or

    $arr = array(
    	'search' => array(
    		'keyword'=>'merhaba dünya',
    		'where'=>'all'
    	)
    );
    print_r($this->get('my_table',$arr));


#### search:column Search columns

Used to search the specified columns of a database table with a full or global mapping policy, words and columns can be sent as `string` or `array`. `column` represents the name of the feature,`id`, `title`, `content` and `tag` represents the column names.

##### Example

    $arr = array(
    	'search' => array(
    		'column'=>array('id', 'title', 'content', 'tag'),
    		'keyword'=>array(
    			'hello world!',
    			'merhaba dünya'
    		)
    	)
    );
    print_r($this->get('my_table',$arr));

or

    $arr = array(
    	'search' => array(
    		'column'=>'title',
    		'keyword'=>array(
    			'hello world!',
    			'merhaba dünya'
    		)
    	)
    );
    print_r($this->get('my_table',$arr));
