<h2>Route()</h2>
Route fonksiyonu özelleştirilebilir rotalar tanımlamak ve bu rotalara özel zihinler yüklemek için kullanılır. Zihin kelimesi, Modal, View, Controller, Middleware gibi çeşitli katmanları tanımlamak amacıyla kullanılmıştır. Böylelikle geliştirici, katmanların hangi rotaya tanımlandığını açıkça görebilir, yönetilebilir ve proje ihtiyacına özel tasarım deseni oluşturabilir. 
<br>
<br>

<h4>Giriş</h4>
<code>url</code>, <code>file</code> ve <code>cache</code> parametreleri alabilen <code>route()</code> fonksiyonu, <code>url</code> parametresini <code>string</code> olarak kabul eder, <code>file</code> ve <code>cache</code> parametreleriniyse <code>string</code> ve <code>array</code> olarak kabul etmektedir. Bu üç parametreden sadece <code>cache</code> parametresinin belirtilme zorunluluğu yoktur. <code>file</code> ve <code>cache</code> parametreleri, uzantısı belirtilmeyen <code>php</code> dosyalarının yollarından meydana gelir.


<h4>Url</h4>
<code>/</code> slash işareti dışında ki rotalara parametre isimleri tanımlamak mümkündür, eğer adres satırına <code>edit/users/1</code> yazılırsa ve <code>users</code> parametresini <code>table</code> ismiyle, <code>1</code> parametresini ise <code>id</code> ismiyle isimlendirmek istenirse, aşağıda ki yolu izlemek gerekir.

<pre>
$db->route('edit:table@id', 'app/view/edit');
</pre>

Kontrolü sağlamak için <code>app/view/edit</code> yolunda ki <code>edit.php</code> dosyası içine

<pre>
print_r($this->post);
</pre>

kodu eklendikten sonra, adres satırına <code>edit/users/1</code> yazarak, parametre isimlerinin <code>url</code> de tanımlanan parametre isimlerine pay edildiği görülebilir.  

<pre>
Array ( 
    [table] => users 
    [id] => 1 
)
</pre>

Ayrıca adres satırına <code>edit/users/1/2/diger</code> gibi rota da isimlendirilmemiş parametreler yazılırsa bunlar görmezden gelinir. 

 Eğer <code>url</code> parametresine aşağıda ki gibi parametre isimleri tanımlanmamışsa

<pre>
$db->route('edit', 'app/view/edit');
</pre> 

ve ulaşılmak istenen rota adresi <code>edit/users/1</code> ise, <code>app/view/edit</code> yolunda ki <code>edit.php</code> dosyası içine
<pre>
print_r($this->post);
</pre>

kodu eklendiğinde, isimlendirilmemiş parametreler aşağıda ki şekilde görünecektir.

<pre>
Array ( 
    [0] => users 
    [1] => 1 
)
</pre>



<h4>File</h4>
<code>cache</code> parametresinde belirtilen dosya veya dosyalar projeye dahil edildikten sonra projeye <code>file</code> parametresinde tanımlanan dosya(lar) dahil edilir.
 <h5>Örnekler</h5>
<pre>
$db->route('/', 'app/view/home');
</pre>

<strong>yada</strong>

<pre>
$arr = array(
    'app/view/layout/header', 
    'app/view/home', 
    'app/view/layout/footer'
    );
$db->route('/', $arr);
</pre>

<h4>Cache</h4>
Eğer <code>cache</code> parametresi belirtilirse, belirtilen <code>cache</code> dosyaları, <code>file</code> parametresinde belirtilen dosya(lar) henüz projeye dahil edilmeden önce, ilk eklenenden son eklenene doğru tek tek varlık kontrolünden geçirilerek projeye dahil edilir.
 
 <h5>Örnekler</h5>
<pre>
$db->route('/', 'app/view/home', 'database/CreateTable');
</pre>

<h5>yada</h5>

<pre>
$arr = array(
    'database/CreateTable,
    'modal/home'
);
$db->route('/', 'view/home', $arr);
</pre>

<h4>.htaccess</h4>
<code>route()</code> fonksiyonu kullanıldığı zaman, eğer <code>Mind.php</code> dosyasının bulunduğu dizinde ve o dizinde ki klasörlerde <code>.htaccess</code> dosyası yoksa oluşturulur.
<br><br>
Klasörlerin içinde oluşturulan <code>.htaccess</code> dosyası direkt erişimi engelleyen <code>Deny from all</code> komutu içerir. <code>Mind.php</code> ile aynı dizinde oluşturulan <code>.htaccess</code> dosyası ise anlamlı <code>url</code> rotalarını elde etmeyi sağlayan aşağıda ki komutları içerir.

<pre>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]
</pre>