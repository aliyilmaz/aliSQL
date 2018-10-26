<h2>What is aliSQL?</h2>
$_GET, $_POST, $FILES requests, allows you to perform routing needs and database operations safely, and also has several important verification methods.
<h2>How to install?</h2>
Installation is very simple, you can add the aliSQL.php file to your project with the extends method or with the help of the new aliSQL() command.
<h4>Example</h4>
<pre>
require_once('./aliSQL.php');
$db = new aliSQL();
</pre>

<h5>or</h5>

<pre>
require_once('./aliSQL.php');
class ClassName extends aliSQL{

}
</pre>
<h2>Database settings</h2>
For a successful database connection, you must update the database information in the aliSQL.php file. This allows you to use aliSQL effectively.
<h4>Example</h4>
<pre>
private $host        = 'localhost';
private $dbname      = 'mydb';
private $username    = 'root';
private $password    = '';
</pre>
<h2>Session Settings</h2>
You can customize or close sessions created for users. To not allow sessions, you can set the <strong>session_status</strong> parameter to <strong><i>false</i></strong>. You can update the path parameter to change the folder <strong>path</strong> where the sessions are stored. You can set the <strong>path_status</strong> parameter to <strong><i>true</i></strong> to keep sessions on the path you specify.
<h4>Example</h4>
<pre>
private $sessset    = array(
    'path'              =>  './session/',
    'path_status'       =>  false,
    'status_session'    =>  true
);
</pre>
<h2>Time Zones Settings</h2>
You can personalize the time zone so that you can mark the content with the correct time stamp. See the <a target="_blank" href="https://secure.php.net/manual/en/timezones.php">List of supported time zones</a>
<h4>Example</h4>
<pre>
public $timezone    = 'Europe/Istanbul';
</pre>
<h2>Language Settings</h2>
You can specify the default language that you want to use in your project.
<h4>Example</h4>
<pre>
public $language    = 'en';
</pre>
<h2>Error Visibility</h2>
You can customize the visibility of errors. You can use 0 to hide all errors or -1 to show all errors. You can also browse the <a target="_blank" href="https://secure.php.net/manual/en/function.error-reporting.php">error_reporting</a> page.
<h4>Example</h4>
<pre>
error_reporting(0);
</pre>
<h5>or</h5>
<pre>
error_reporting(-1);
</pre>
