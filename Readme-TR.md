##aliSQL nedir?
$_GET, $_POST, $FILES istekleri, yönlendirme ihtiyaçlarını ve veritabanı işlemlerini güvenle gerçekleştirmenizi sağlar ve ayrıca birkaç önemli doğrulama yöntemine sahiptir.
##Nasıl kurulur?
Kurulum çok basittir, aliSQL.php dosyasını projenize extends yöntemi ile veya new aliSQL() komutunun yardımıyla ekleyebilirsiniz.
####Örnek
<pre>
require_once('./aliSQL.php');
$db = new aliSQL();
</pre>

#####yada

<pre>
require_once('./aliSQL.php');
class ClassName extends aliSQL{

}
</pre>
##Veritabanı Ayarları
Başarılı bir veritabanı bağlantısı için, veritabanı bilgilerini aliSQL.php dosyasında güncellemeniz gerekir. Bu, aliSQL'i etkili bir şekilde kullanmanıza izin verir.
####Örnek
<pre>
private $host        = 'localhost';
private $dbname      = 'mydb';
private $username    = 'root';
private $password    = '';
</pre>
##Database Settings
For a successful database connection, you must update the database information in the aliSQL.php file. This allows you to use aliSQL effectively.
####Example
<pre>
private $host        = 'localhost';
private $dbname      = 'mydb';
private $username    = 'root';
private $password    = '';
</pre>
##Oturum Ayarları
Kullanıcılar için oluşturulan oturumları özelleştirebilir veya kapatabilirsiniz. Oturumlara izin vermemek için, **session_status** parametresini **_false_** olarak ayarlayabilirsiniz. Oturumların depolandığı klasör yolunu değiştirmek için **path** parametresini güncelleyebilirsiniz. Belirttiğiniz yolda oturumları tutmak için **path_status** parametresini **_true_** olarak ayarlayabilirsiniz.
####Örnek
<pre>
private $sessset    = array(
    'path'              =>  './session/',
    'path_status'       =>  false,
    'status_session'    =>  true
);
</pre>
##Zaman Dilimi Ayarları
İçeriği doğru zaman damgasıyla işaretleyebilmek için zaman dilimini kişiselleştirebilirsiniz. <a target="_blank" href="https://secure.php.net/manual/tr/timezones.php"> Desteklenen zaman dilimlerinin listesi </a> bölümüne bakın.
####Örnek
<pre>
public $timezone    = 'Europe/Istanbul';
</pre>
##Dil Ayarları
Projenizde kullanmak istediğiniz varsayılan dili belirtebilirsiniz.
####Örnek
<pre>
public $language    = 'tr';
</pre>
##Hata Görünürlüğü
Hataların görünürlüğünü özelleştirebilirsiniz. Tüm hataları gizlemek için 0'ı veya tüm hataları göstermek için -1'i kullanabilirsiniz. Ayrıca <a target="_blank" href="https://secure.php.net/manual/tr/function.error-reporting.php"> error_reporting </a> sayfasına da göz atabilirsiniz.
####Örnek
<pre>
error_reporting(0);
</pre>
#####yada
<pre>
error_reporting(-1);
</pre>
