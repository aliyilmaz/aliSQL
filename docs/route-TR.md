<h2>Rota nedir?</h2>
Özelleştirilebilir rotalar tanımlamak, zihinleri yüklemek için kullanılan bir fonksiyondur.
<h2>Kullanım</h2>
Mind.php dosyasıyla aynı dizinde bir index.php dosyası oluşturmanız gerekir. Sonra, oluşturduğunuz index.php dosyasına Mind'i eklemeniz gerekir. 3 alan gönderilebilir (url, file, cache). Cache alanı zorunlu değildir ve bir dizi olarak da gönderilebilir.
<h4>Örnek</h4>

<pre>
$db->route('/', 'view/home');
</pre>

<h5>yada</h5>

<pre>
$db->route('/', 'view/home', 'middleware/home');
</pre>

<h5>yada</h5>

<pre>
$db->route('/', 'view/home', array('modal/home','middleware/home');
</pre>

<h2>Parametreler</h2>
Parametre ismini (/) dışındaki rota tanımları için tanımlamak mümkündür.
<h4>Örnek</h4>

<pre>
$db->route('delete:id', 'view/home');
</pre>

<h5>yada</h5>
<pre>
$db->route('delete:table@id', 'view/home');
</pre>