<h2>What is Route?</h2>
Defining customizable routes is a function used to load minds.
<h2>Usage</h2>
You need to create an index.php file in the same directory as the Mind.php file. Then you need to include Mind into the index.php file that you created. 3 fields can be sent (url, file, cache). The Cache field is not mandatory and can also be sent as an array. 
<h4>Example</h4>

<pre>
$db->route('/', 'view/home');
</pre>

<h5>or</h5>

<pre>
$db->route('/', 'view/home', 'middleware/home');
</pre>

<h5>or</h5>

<pre>
$db->route('/', 'view/home', array('modal/home','middleware/home');
</pre>

<h2>Parameters</h2>
It is possible to define the parameter name for route definitions other than (/).
<h4>Example</h4>

<pre>
$db->route('delete:id', 'view/home');
</pre>

<h5>or</h5>

$db->route('delete:table@id', 'view/home');