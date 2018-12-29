
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