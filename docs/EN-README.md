
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
