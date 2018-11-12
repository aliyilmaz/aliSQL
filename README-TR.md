<h2>Mind nedir?</h2>
$_GET, $_POST, $_FILES istekleri, yönlendirme ihtiyaçlarını ve veritabanı işlemlerini güvenle gerçekleştirmenizi sağlar ve ayrıca birkaç önemli doğrulama yöntemine sahiptir.
<h2>Nasıl kurulur?</h2>
Kurulum çok basittir, Mind.php dosyasını projenize extends yöntemi ile veya new Mind() komutunun yardımıyla ekleyebilirsiniz.
<h4>Örnek</h4>
<pre>
require_once('./Mind.php');
$db = new Mind();
</pre>

<h4>yada</h4>

<pre>
require_once('./Mind.php');
class ClassName extends Mind{

}
</pre>
<h2>Veritabanı Ayarları</h2>
Başarılı bir veritabanı bağlantısı için, veritabanı bilgilerini Mind.php dosyasında güncellemeniz gerekir. Bu, Mind'i etkili bir şekilde kullanmanıza izin verir.
<h4>Örnek</h4>
<pre>
private $host        = 'localhost';
private $dbname      = 'mydb';
private $username    = 'root';
private $password    = '';
</pre>
<h2>Oturum Ayarları</h2>
Kullanıcılar için oluşturulan oturumları özelleştirebilir veya kapatabilirsiniz. Oturumlara izin vermemek için, <strong>session_status</strong> parametresini <strong><i>false</i></strong> olarak ayarlayabilirsiniz. Oturumların depolandığı klasör yolunu değiştirmek için <strong>path</strong> parametresini güncelleyebilirsiniz. Belirttiğiniz yolda oturumları tutmak için <strong>path_status</strong> parametresini <strong><i>true</i></strong> olarak ayarlayabilirsiniz.
<h4>Örnek</h4>
<pre>
private $sessset    = array(
    'path'              =>  './session/',
    'path_status'       =>  false,
    'status_session'    =>  true
);
</pre>
<h2>Zaman Dilimi Ayarları</h2>
İçeriği doğru zaman damgasıyla işaretleyebilmek için zaman dilimini kişiselleştirebilirsiniz. <a target="_blank" href="https://secure.php.net/manual/tr/timezones.php"> Desteklenen zaman dilimlerinin listesi </a> bölümüne bakın.
<h4>Örnek</h4>
<pre>
public $timezone    = 'Europe/Istanbul';
</pre>
<h2>Dil Ayarları</h2>
Projenizde kullanmak istediğiniz varsayılan dili belirtebilirsiniz.
<h4>Örnek</h4>
<pre>
public $language    = 'tr';
</pre>
<h2>Hata Görünürlüğü</h2>
Hataların görünürlüğünü özelleştirebilirsiniz. Tüm hataları gizlemek için 0'ı veya tüm hataları göstermek için -1'i kullanabilirsiniz. Ayrıca <a target="_blank" href="https://secure.php.net/manual/tr/function.error-reporting.php"> error_reporting </a> sayfasına da göz atabilirsiniz.
<h4>Örnek</h4>
<pre>
error_reporting(0);
</pre>
<h5>yada</h5>
<pre>
error_reporting(-1);
</pre>
