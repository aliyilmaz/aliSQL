##What is aliSQL?
$_GET, $_POST, $FILES requests, allows you to perform routing needs and database operations safely, and also has several important verification methods.
##How to install?
Installation is very simple, you can add the aliSQL.php file to your project with the extends method or with the help of the new aliSQL() command.
####Example
<pre>
require_once('./aliSQL.php');
$db = new aliSQL();
</pre>

#####or

<pre>
require_once('./aliSQL.php');
class ClassName extends aliSQL{

}
</pre>
##Database settings
For a successful database connection, you must update the database information in the aliSQL.php file. This allows you to use aliSQL effectively.
####Example
<pre>
private $host        = 'localhost';
private $dbname      = 'mydb';
private $username    = 'root';
private $password    = '';
</pre>
##Session Settings
You can customize or close sessions created for users. To not allow sessions, you can set the **session_status** parameter to _**false**_. You can update the path parameter to change the folder **path** where the sessions are stored. You can set the **path_status** parameter to **_true_** to keep sessions on the path you specify.
####Example
<pre>
private $sessset    = array(
    'path'              =>  './session/',
    'path_status'       =>  false,
    'status_session'    =>  true
);
</pre>
##Time Zones Settings
You can personalize the time zone so that you can mark the content with the correct time stamp. See the <a target="_blank" href="https://secure.php.net/manual/en/timezones.php">List of supported time zones</a>
####Example
<pre>
public $timezone    = 'Europe/Istanbul';
</pre>
##Language Settings
You can specify the default language that you want to use in your project.
####Example
<pre>
public $language    = 'en';
</pre>
##Error Visibility
You can customize the visibility of errors. You can use 0 to hide all errors or -1 to show all errors. You can also browse the <a target="_blank" href="https://secure.php.net/manual/en/function.error-reporting.php">error_reporting</a> page.
####Example
<pre>
error_reporting(0);
</pre>
#####or
<pre>
error_reporting(-1);
</pre>
