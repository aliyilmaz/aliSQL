
# Mind nedir?

`PHP` ve `MySQL` ile geliştirilen projelerde; Veritabanı ve Rota işlemleri, `$_GET`, `$_POST`, `$_FILES` istekleri, Model, View, Controller, Middleware gibi katmanların yönetimi ve çeşitli kontrol işlemlerini kolaylıkla gerçekleştirmeye olanak tanıyan`PHP` sınıfıdır.

---------- 

## İndirmeler
Mind sınıfını [GitHub sayfasından](https://github.com/aliyilmaz/Mind/archive/master.zip) indirebilir veya komut istemcinizden `composer require mind/mind` komutunu çalıştırarak bir sonraki aşamaya geçebilirsiniz. 

---------- 

## Veritabanı Ayarları

Sınıfı kullanmak için veritabanı bilgilerini `Mind.php` dosyasında veya sınıf çağrılırken tanımlamak gerekir.

#### Örnek

    private $host        = 'localhost';
    private $dbname      = 'mydb';
    private $username    = 'root';
    private $password    = '';
    
veya

    $conf = array(
        'host'      =>  'localhost',
        'dbname'    =>  'mydb',
        'username'  =>  'root',
        'password'  =>  ''
    );
    $Mind = new Mind($conf);

----------

## Kurulum

`Mind.php` dosyasını projeye `require_once` gibi bir yöntemle dahil ettikten sonra, `extends` veya `new Mind()` komutu yardımıyla sınıfı kullanıma hazır hale getirmek mümkündür.

#### Örnek

    require_once('./Mind.php');
    use Mind\Mind;
    $Mind = new Mind();

veya

    require_once('./Mind.php');
    class ClassName extends Mind\Mind{
    
    }

----------

## Oturum Ayarları

Kullanıcılar için oluşturulan oturumları özelleştirmek veya kapatmak için kullanılan kısımdır. Oturumlara izin vermemek için, `session_status` parametresini `false` olarak ayarlamak, Oturumların depolandığı klasör yolunu değiştirmek için `path` parametresini güncellemek gerekir. Belirttilen yolda oturumları tutmak için `path_status` parametresi `true` olarak ayarlanmalıdır. Varsayılan olarak sunucu oturum ayarlarına göre yapılandırılmıştır.

#### Örnek

    private $sessset    = array(
        'path'              =>  './session/',
        'path_status'       =>  false,
        'status_session'    =>  true
    );

----------

## Zaman Dilimi Ayarı

İçeriğin doğru zaman damgasıyla işaretlenebilmesi için zaman dilimini kişiselleştirmek mümkündür. Varsayılan olarak `Europe/Istanbul` tanımlanmıştır. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır. [Desteklenen zaman dilimlerinin listesi](https://secure.php.net/manual/tr/timezones.php) bölümüne bakın.

**Bilgi:** Gerektiği kadar kişiselleştirilmemiş sunucular proje zaman diliminden farklı zaman dilimi kullanabilmektedir, bu kısımda ki yapılan düzenleme farklı sunucularda doğru zaman damgasına sahip olmanızı sağlar. 

#### Örnek

    public $timezone    = 'Europe/Istanbul';

----------

## Etkin Metodlar

Oturum yönetimi, Veritabanı bağlantısı, `$_GET`, `$_POST` ve `$_FILES` isteklerinin yönetimi gibi ihtiyaçları karşılayan metodlar `Mind.php` dosyasında bulunan `__construct()` metodu içinde çalıştırılarak etkin hale getirilmiştir, bu metodlar aşağıda ki gibidir.

-   [session_check()](#session_check)
-   [connection()](#connection)
-   [request()](#request)

----------

## Etkin Değişkenler

##### private $conn

Veritabanı bağlantısı `$this->conn` değişkeninde tutulur, bu değişkene sınıf dışından erişimi engellemek için `private` özelliği tanımlanmıştır.

##### public $post

Sınıfın dahil edildiği projede, gerçekleşen `$_GET`, `$_POST` ve `$_FILES` istekleri, `$this->post` değişkeninde tutulur, sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $baseurl

`Mind.php` dosyasının içinde bulunduğu klasörün yolu `$this->baseurl` değişkeninde tutulur, sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

## Metodlar

##### Veritabanı

-   [connection](#connection)
-   [prepare](#prepare)
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
-   [increment](#increment)

##### Denetleyici

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

##### Yardımcı

-   [info](#info)
-   [filter](#filter)
-   [request](#request)
-   [redirect](#redirect)
-   [mindload](#mindload)
-   [permalink](#permalink)
-   [timezones](#timezones)
-   [session_check](#session_check)

##### Sistem

-   [route](#route)
-   [write](#write)
-   [upload](#upload)
-   [get_contents](#get_contents)

----------

## connection()

[Kurulum](#kurulum) aşamasında belirtilen bilgiler ışığında veritabanı bağlantısı sağlamak amacıyla kullanılır, `Mind.php` dosyasında bulunan `__construct()` metodu içinde çalıştırılarak etkin hale getirilmiştir.

----------

## prepare()

SQL sorgularını çalıştırmak amacıyla kullanılır, sınıf dışından `SQL` sorgusunun gönderilmesi için `public` tanımlamasına sahiptir. `string` olarak `SQL` sorgusu gönderilebilir.  İçinde bulunan metodlar aşağıda ki gibidir.

-   `mysqli_query`
-   `filter_var`
    -   `FILTER_SANITIZE_FULL_SPECIAL_CHARS`
-   `mysqli_escape_string`   

##### Örnek

    $Mind->prepare($sql);

----------

## createdb()

Yeni bir veya daha fazla veritabanı oluşturmak amacıyla kullanılır, `mydb0` ve `mydb1` veritabanı adlarını temsil etmektedir, oluşturulacak veritabanı isimleri `string` veya `dizi` olarak gönderildiğinde veritabanı oluşturma işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->createdb('mydb0');

veya

    $this->createdb(array('mydb0','mydb1'));

## createtable()

Yeni bir veritabanı tablosu oluşturmak amacıyla kullanılır, `:` sembolünün solunda ki parametre sütun adını, sağında ki parametre sütun özelliğini temsil etmektedir. Eğer sütun özellik alanı boş bırakılırsa varsayılan olarak sütun özelliği `small` kabul edilir. Kullanılabilir özellik listesi aşağıdadır. Sütun içerikleri varsayılan olarak `NULL` olarak tanımlanmıştır. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Özellikler

-   increments - (`AUTO_INCREMENT`)
-   small - (`TEXT`)
-   medium - (`MEDIUMTEXT`)
-   large - (`LONGTEXT`)

##### Örnek

    $arr = array(
        'id:increments',
        'username:small',
        'password',
        'address:medium',
        'about:large'
    );
    $this->createtable('users', $arr);

----------

## createcolumn()

Veritabanı tablosunda bir veya daha fazla sütun oluşturmak amacıyla kullanılır, `:` sembolünün solunda ki parametre sütun adını, sağında ki parametre sütun özelliğini temsil etmektedir. Eğer sütun özellik alanı boş bırakılırsa varsayılan olarak sütun özelliği `small` kabul edilir. Kullanılabilir özellik listesi aşağıdadır. Sütun içerikleri varsayılan olarak `NULL` olarak tanımlanmıştır. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Özellikler

-   increments - (`AUTO_INCREMENT`)
-   small - (`TEXT`)
-   medium - (`MEDIUMTEXT`)
-   large - (`LONGTEXT`)

##### Örnek

    $arr = array(
        'id:increments',
        'username:small',
        'password',
        'address:medium',
        'about:large'
    );
    $this->createcolumn('users', $arr);

----------

## deletedb()

Bir veya daha fazla veritabanını silmek amacıyla kullanılır, `mydb0` ve `mydb1` veritabanı adlarını temsil etmektedir, `string` veya `dizi` olarak veritabanı isimleri gönderildiğinde veritabanı silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->deletedb('mydb0');

veya

    $this->deletedb(array('mydb0','mydb1'));

----------

## deletetable()

Bir veya daha fazla veritabanını tablosunu silmek amacıyla kullanılır, `my_table0` ve `my_table1` veritabanı tablo isimlerini temsil etmektedir, `string` veya `dizi` olarak tablo isimleri gönderildiğinde silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->deletetable('my_table0');

veya

    $this->deletetable(array('my_table0', 'my_table1'));

----------

## deletecolumn()

Veritabanı tablosunda bulunan bir veya daha fazla sütunu silmek amacıyla kullanılır, `users` tablo adını, `username` ve `password` silinmesi istenen sütunları temsil etmektedir, `string` veya `dizi` olarak sütun isimleri gönderildiğinde silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->deletecolumn('users', 'username');

veya

    $this->deletecolumn('users', array('username', 'password'));

----------

## cleardb()

Bir veya daha fazla veritabanı içeriğini (auto_increment değerleri dahil) silmek amacıyla kullanılır, `mydb0` ve `mydb1` veritabanı adlarını temsil etmektedir, `string` veya `dizi` olarak veritabanı isimleri gönderildiğinde silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->cleardb('mydb0');

veya

    $this->cleardb(array('mydb0','mydb1'));

----------

## cleartable()

Bir veya daha fazla veritabanı tablosu içindeki kayıtların tamamını(auto_increment değerleri dahil) silmek amacıyla kullanılır, `string` veya `dizi` olarak veritabanı tablo isimleri gönderilebilir, `my_table0` ve `my_table1` veritabanı tablo isimlerini temsil etmektedir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->cleartable('my_table0');

veya

    $this->cleartable(array('my_table0', 'my_table1'));

----------

## clearcolumn()

Bir veritabanı tablosunda bulunan bir veya daha fazla sütuna ait kayıtların tamamını silmek amacıyla kullanılır, `string` veya `dizi` olarak sütun isimleri gönderilebilir, `username` ve `password` sütun isimlerini temsil etmektedir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->clearcolumn('username');

veya

    $this->clearcolumn(array('username', 'password'));

## insert()

Veritabanı tablosuna veri eklemek amacıyla kullanılır, `my_table` veritabanı tablo adını, `title`, `content` ve `tag` ise `my_table` tablosu içinde ki sütunları temsil etmektedir, değerler `dizi` şeklinde gönderildiğinde kayıt gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $query = $this->insert('my_table', array(
    	'title' => 'test user',
    	'content' => '123456',
    	'tag' => 'test@mail.com'
    ));

----------

## update()

Veritabanı tablosunda bulunan herhangi bir kaydı güncellemek amacıyla kullanılır, `my_table` veritabanı tablo adını, `title`, `content` ve `tag`, `my_table` tablosu içinde ki sütunları, `17` güncellenmesi istenen kaydın `id`'sini temsil etmektedir, yeni değerler `dizi` şeklinde gönderildiğinde güncelleme işlemi gerçekleşir. `id` parametresini `auto_increment` özelliği tanımlanmayan bir sütunda aramak için sütun adını 4'ncü parametre de belirtmek gerekir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $query = $this->update('my_table', array(
    	'title' => 'test user',
    	'content' => '123456',
    	'tag' => 'example@mail.com'
    ),17);

veya

    $query = $this->update('my_table', array(
    	'title' => 'test user',
    	'content' => '123456',
    	'tag' => 'example@mail.com'
    ),'test user', 'title');

----------

## delete()

Veritabanı tablosunda bulunan bir veya daha fazla kaydı silmek amacıyla kullanılır, `my_table` veritabanı tablo adını, `14` değeri silinmesi istenen bir kaydı, `15` ve `16` değerleri silinmesi istenen kayıtların id'sini temsil etmektedir, id'ler `string` veya `dizi` olarak gönderildiğinde kayıtları silme işlemi gerçekleşir. `id` parametresini `auto_increment` özelliği tanımlanmayan bir sütunda aramak için sütun adını 3'ncü parametre de belirtmek gerekir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->delete('my_table',14);

veya

    $this->delete('my_table',array(15,16));

veya

    $this->delete('my_table',14, 'age');

veya

    $this->delete('my_table',array(15,16), 'age');

----------

## get()

Bir veritabanı tablosunda ki kayıtları olduğu gibi yada belirli kriterlere göre filtreleyerek elde etmek amacıyla kullanılır, `my_table0` veritabanı tablo adını temsil etmekte olup, `$arr` parametreleri ve kullanım örneklerine aşağıda yer verilmiştir.

----------

#### Tüm kayıtlara ulaşmak

Bir veritabanı tablosunun tüm kayıtlarını elde etmek amacıyla kullanılır, ekstra bir parametreye ihtiyaç duymadan kullanılması mümkündür, fakat çok sayıda verinin tek seferde elde edilmesi, sunucu ve kullanıcı tarafında yük oluşturarak proje performansını düşürebilir.

##### Örnek

    print_r($this->get('my_table0'));

----------

#### column: Tablo sütunlarına ulaşmak

Bir veritabanı tablosunda bulunan kayıtların belirtilen sütun verilerini elde etmek amacıyla kullanılır, tüm sütun verilerini elde etmediği için daha hafif bir sorgu yapılmasına olanak tanır, `column` özelliğin adını, `title` ve `tag` sütun isimlerini temsil etmektedir.

##### Örnek

    $arr = array(
    	'column' => array(
    	      'title',
    	      'tag'
    	)
    );
    print_r($this->get('my_table0',$arr));

veya

    $arr = array(
    	'column' => 'title'
    );
    print_r($this->get('my_table0',$arr));

----------

#### limit: Kayıt aralığına ulaşmak

Veritabanı tablosunda bulunan kayıtları belirtilen limitler doğrultusunda elde etmek amacıyla kullanılır, `limit` özelliğin adını, `start` ve `end` alt özellikleri temsil etmekte olup, tablo da ki kayıt aralığını elde etmek için `start` özelliğine başlangıç değeri, `end` özelliğine ise bitiş değeri tanımlamak gerekir.

##### Örnek

    $arr = array(
    	'limit' => array('start'=>'1', 'end'=>'10')
    );
    print_r($this->get('my_table',$arr));

----------

#### limit:start Belirtilen miktarda ilk kaydı gözardı etmek

Veritabanı tablosunda bulunan kayıtların ilk eklenenden son eklenene doğru belirtilen sayı kadarının gözardı edilmesi amacıyla kullanılır, `limit` özelliğin adını, `start` gözardı edilecek kayıt miktarını temsil etmektedir.

##### Örnek

    $arr = array(
    	'limit' => array('start'=>'2')
    );
    print_r($this->get('my_table',$arr));

----------

#### limit:end Belirtilen miktar kadar kayda ulaşmak

Veritabanı tablosunda, belirtilen sayı kadar kaydı elde etmek amacıyla kullanılır, `limit` özelliğin adını, `end` elde edilmek istenen kayıt miktarını temsil etmektedir.

##### Örnek

    $arr = array(
    	'limit' => array('end'=>'10')
    );
    print_r($this->get('my_table',$arr));

----------

#### sort: Kayıtları sıralamak

Veritabanı tablosundaki kayıtları belirtilen sütun içeriğine göre küçükten büyüğe veya büyükten küçüğe doğru sıralamak amacıyla kullanılır, `sort` özelliğin adını, `columnname` sıralamanın yapılacağı sütun adını, `ASC` küçükten büyüğe sıralama talebini, `DESC` ise büyükten küçüğe doğru sıralama talebini temsil etmektedir.

##### Örnek

    $arr = array(
    	'sort' => 'columnname:ASC'
    );
    print_r($this->get('my_table',$arr));

veya

    $arr = array(
    	'sort' => 'columnname:DESC'
    );
    print_r($this->get('my_table',$arr));

----------

#### search: Arama yapmak

Veritabanı tablosunun tamamında tam eşleme prensibiyle arama yapmak amacıyla kullanılır, `string` veya `dizi` olarak kelimeler gönderilebilir, `search` özelliğin adını, `keyword` aranan kelimeleri temsil etmektedir.

##### Örnek

    $arr = array(
    	'search' => array(
    		'keyword'=> array(
    			'hello world!',
    			'merhaba dünya'
    		)
    	)
    );
    print_r($this->get('my_table0',$arr));

veya

    $arr = array(
    	'search' => array(
    		'keyword'=> 'merhaba dünya'
    	)
    );
    print_r($this->get('my_table0',$arr));

----------

#### search:where Heryerde aramak

Veritabanı tablosunun tamamında genel eşmele prensibiyle arama yapmak amacıyla kullanılır, `string` veya `dizi` olarak kelimeler gönderilebilir, `where` özelliğin adını, `keyword` aranan kelimeleri temsil etmektedir, bu özelliği kullanmak için `all` parametresi belirtilmelidir.

##### Örnek

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

veya

    $arr = array(
    	'search' => array(
    		'keyword'=>'merhaba dünya',
    		'where'=>'all'
    	)
    );
    print_r($this->get('my_table',$arr));

----------

#### search:column Sütunlarda aramak

Veritabanı tablosunun belirtilen sütunlarında tam veya genel eşleme prensibiyle arama yapmak amacıyla kullanılır, `string` veya `dizi` olarak kelime ve sütunlar gönderilebilir, `column` özelliğin adını, `id`, `title`, `content` ve `tag` hangi sütunlarda arama yapılacağını temsil etmektedir.

##### Örnek

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

veya

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

veya

    $arr = array(
    	'search' => array(
    		'column'=>array('id', 'title', 'content', 'tag'),
    		'keyword'=>'merhaba dünya'
    	)
    );
    print_r($this->get('my_table',$arr));

veya

    $arr = array(
    	'search' => array(
    		'column'=>'title',
    		'keyword'=>'merhaba dünya'
    	)
    );
    print_r($this->get('my_table',$arr));

----------

#### format: Sonuçların formatı

Veritabanı tablosundan elde edilen verilerin çıktı formatını belirlemek amacıyla kullanılır, şuan için `dizi` formatı dışında `json` formatını desteklemektedir.

##### Örnek

    $arr = array(
    	'format' => 'json'
    );
    print_r($this->get('my_table',$arr));

----------

#### Özelliklerin bir arada kullanımı

Şimdiye kadar anlatılan tüm `get()` özellikleri birarada kullanılabilir, bu kullanım şekli herhangi bir yük oluşturmayacağı gibi, yüksek performansa ihtiyaç duyan projeler için hayat kurtarıcıdır.

##### Örnek

    $arr = array(
    	'search'=>array(
    		'column'=>array(
    			'id',
    			'title',
    			'content',
    			'tag'
    		),
    		'keyword'=>array(
    			'merhaba',
    			'hello'
    		),
    		'where'=>'all'
    	),
    	'format'=>'json',
    	'sort'=>'id:ASC',
    	'limit'=>array(
    		'start'=>'1',
    		'end'=>'5'
    	),
    	'column'=>array(
    		'id',
    		'title'
    		)
    );
    print_r($this->get('my_table',$arr));

----------

## do_have()

Bir verinin, tam eşleşme prensibiyle veritabanı tablosunda bulunup bulunmadığını kontrol etmek amacıyla kullanılır, bu tür bir kontrolü, Aynı üye bilgileriyle tekrar kayıt olunmasını istemediğimiz durumlarda veya Select box'dan gönderilen verilerin gerçekten select box'ın edindiği kaynakla aynılığını kontrol etmemiz gereken durumlarda kullanırız. `$tblname` tablo adını, `$str` veriyi, `$column` verinin olup olmadığına bakılan sütunu temsil etmektedir, eğer `$column` değişkeni boş bırakılırsa veri, tablo'nun tüm sütunlarında aranır. Arama sonucunda eşleşen kayıt bulunursa yanıt olarak `true` değeri döndürülür, bulunmazsa da `false` değeri döndürülür.

##### Örnek

    $tblname = 'users';
    $str = 'aliyilmaz.work@gmail.com';
    $column = 'email_address';
    if($this->do_have($tblname, $str, $column)){
    	echo 'Bu E-Posta adresi kullanılmaktadır';
    } else {
    	echo 'Bu E-Posta adresi kullanılmamaktadır.';
    }

veya

    $tblname = 'users';
    $str = 'aliyilmaz.work@gmail.com';
    if($this->do_have($tblname, $str)){
    	echo 'Bu E-Posta adresi kullanılmaktadır';
    } else {
    	echo 'Bu E-Posta adresi kullanılmamaktadır.';
    }

veya

    if($this->do_have('users', 'aliyilmaz.work@gmail.com', 'email_address')){
    	echo 'Bu E-Posta adresi kullanılmaktadır';
    } else {
    	echo 'Bu E-Posta adresi kullanılmamaktadır.';
    }

veya

    if($this->do_have('users', 'aliyilmaz.work@gmail.com')){
    	echo 'Bu E-Posta adresi kullanılmaktadır';
    } else {
    	echo 'Bu E-Posta adresi kullanılmamaktadır.';
    }

----------

## lastid()

Bir veritabanı tablosuna eklenmesi planlanan kayda tahsis edilecek `auto_increment` değerini göstermeye yarar. `$tblname` tablo adını temsil etmektedir.
##### Örnek
    $tblname  = 'users';
    echo $this->lastid($tblname);

----------

## increment()

Veritabanı tablosunda ki `auto_increment` görevine sahip sütun adını göstermek amacıyla kullanılır. `$tblname` veritabanı tablo adını temsil etmektedir.
##### Örnek

    $tblname = 'users';
    echo $this->increment($tblname);

----------

## is_db()

Bu fonksiyon veritabanının varlığını sorgulamak amacıyla kullanır,`mydb` veritabanı adını temsil etmektedir. Veritabanı ismi `string` olarak gönderilebilir. Eğer veritabanı varsa `true` değeri döndürülür, yoksa `false` değeri döndürülür.

##### Örnek

    if($this->is_db('mydb')){
        echo 'Veritabanı var';
    } else {
        echo 'Veritabanı yok';
    }

----------

## is_table()

Bu fonksiyon veritabanı tablosunun varlığını sorgulamak amacıyla kullanır, `users` veritabanı tablo adını temsil etmektedir. Tablo ismi `string` olarak gönderilebilir. Eğer söz konusu tablo varsa `true` değeri döndürülür, yoksa `false` değeri döndürülür.

##### Örnek

    if($this->is_table('users')){
        echo 'Tablo var';
    } else {
        echo 'Tablo yok';
    }

----------

## is_column()

Bu fonksiyon veritabanı tablosunda belirtilen sütunun varlığını sorgulamak amacıyla kullanır, `users` tablo adını, `username` sütun adını temsil etmektedir. Sütun ismi `string` olarak gönderilebilir. Eğer söz konusu sütun varsa `true` değeri döndürülür, yoksa `false` değeri döndürülür.

##### Örnek

    if($this->is_column('users', 'username)){
        echo 'Tablo var';
    } else {
        echo 'Tablo yok';
    }

----------

## is_phone()

Bu fonksiyon kendisiyle paylaşılan verinin geçerli bir telefon numarası söz diziminde yazılıp yazılmadığını kontrol etmek amacıyla kullanılır, telefon numarası `string` olarak gönderilebilir. Eğer söz konusu veri geçerli bir numaraysa yanıt olarak `true` değeri döndürülür, değilse `false` değeri döndürülür, `$str` kendisiyle paylaşılan veriyi temsil etmektedir.
##### Örnek
    $str = '05555555555';
    if($this->is_phone($str)){
    	echo 'Bu numara geçerli bir telefon numarasıdır.';
    } else {
    	echo 'Bu numara geçerli bir telefon numarası değildir.';
    }

veya

    $str = '0555 555 55 55';
    if($this->is_phone($str)){
    	echo 'Bu numara geçerli bir telefon numarasıdır.';
    } else {
    	echo 'Bu numara geçerli bir telefon numarası değildir.';
    }

veya

    $str = '+905555555555';
    if($this->is_phone($str)){
    	echo 'Bu numara geçerli bir telefon numarasıdır.';
    } else {
    	echo 'Bu numara geçerli bir telefon numarası değildir.';
    }

veya

    $str = '905555555555';
    if($this->is_phone($str)){
    	echo 'Bu numara geçerli bir telefon numarasıdır.';
    } else {
    	echo 'Bu numara geçerli bir telefon numarası değildir.';
    }

----------

## is_date()

Bu fonksiyon kendisiyle paylaşılan tarih biçiminin gerçek olup olmadığını kontrol etmek amacıyla kullanılır, tarih ve formak `string` olarak gönderilebilir. `$date` ve `01.02.1987` tarihi, `$format` ve `d.m.Y` tarihin hangi formatta kontrol edilmesi gerektiği bilgisini temsil etmektedir. Format parametresinin belirtilmesi isteğe bağlıdır, belirtilmediğinde tarih formatının varsayılan olarak `d-m-Y H:i:s` olduğu varsayılır. Eğer tarih geçerliyse yanıt olarak `true` değeri döndürülür, geçerli değilse `false` değeri döndürülür.
##### Örnek

    $date = '01.02.1987';
    $format = 'd.m.Y';
    if($this->is_date($date, $format)){
    	echo 'Bu tarih bir doğum tarihidir';
    } else {
    	echo 'Bu tarih bir doğum tarihi değildir.';
    }

veya

    if($this->is_date('01.02.1987', 'd.m.Y')){
    	echo 'Bu tarih bir doğum tarihidir';
    } else {
    	echo 'Bu tarih bir doğum tarihi değildir.';
    }

----------

## is_email()

Bu fonksiyon kendisiyle paylaşılan verinin e-mail adresi söz dizimine sahip olup olmadığını kontrol etmek amacıyla kullanılır, veri `string` olarak gönderilebilir. Eğer veri e-mail adresi söz dizimine sahip ise yanıt olarak `true` değeri döndürülür, geçerli değilse `false` değeri döndürülür.
##### Örnek
    $str = 'aliyilmaz.work@gmail.com';
    if($this->is_email($str)){
    	echo 'Bu bir email adresidir.';
    } else {
    	echo 'Bu bir email adresi değildir.';
    }

----------

## is_type()

Bu fonksiyon özellikle dosya yükleme işlemleri sırasında yüklenmek istenen dosyanın formatını kontrol etmek amacıyla kullanılır, Dosya adı `string` olarak belirtilmelidir, Dosya uzantıları ise `string` veya `dizi` olarak belirtilebilir. `$this->post['photo']['name']` dosya adını, `$list` müsade edilen dosya uzantılarını temsil etmektedir. Eğer dosya müsade edilen uzantıya sahip ise yanıt olarak `true` değeri döndürülür, değilse `false` değeri döndürülür.
##### Örnek

    $list = 'jpg';
    if($this->is_type($this->post['photo']['name'], $list)){
    	echo 'Yüklemek istediğiniz dosya müsade edilen bir uzantıya sahiptir.';
    } else {
    	echo 'Yüklemek istediğiniz dosya müsade edilen bir uzantıya sahip değildir.';
    }

veya

    $list = array('jpg', 'jpeg', 'png', 'gif');
    if($this->is_type($this->post['photo']['name'], $list)){
    	echo 'Yüklemek istediğiniz dosya müsade edilen bir uzantıya sahiptir.';
    } else {
    	echo 'Yüklemek istediğiniz dosya müsade edilen bir uzantıya sahip değildir.';
    }

----------

## is_size()

Bu fonksiyon, dosya dizisinde bulunan `size` değerinin veya `string` yapıda belirtilen `byte` cinsinden  değerin kontrol edilmesi amacıyla kullanılır, `$this->post['photo']` dosya dizisini, `$manuelsize` string yapıda ki değeri, `$size` ise müsade edilen boyut bilgisini temsil etmektedir. Eğer dosya veya belirtilen değer müsade edilen boyutun altındaysa yanıt olarak `true` değeri döndürülür, değilse `false` değeri döndürülür.
 
 **Bilgi:** Dosyalarla çalışırken `php.ini` ayarlarında bulunan `upload_max_filesize` parametresine en az `$size` değişkeninde belirtilen miktar kadar boyutun belirtilmesi gereklidir.
##### Örnek

    $size = '35 KB';
    if($this->is_size($this->post['photo'], $size)){
    	echo 'Dosya belirtilen boyuttan küçüktür';
    } else {
    	echo 'Dosya belirtilen boyuttan büyüktür.';
    }

veya

    if($this->is_size($this->post['photo'], '35 MB')){
    	echo 'Dosya belirtilen boyuttan küçüktür';
    } else {
    	echo 'Dosya belirtilen boyuttan büyüktür.';
    }

veya

    if($this->is_size($this->post['photo'], '35 GB')){
    	echo 'Dosya belirtilen boyuttan küçüktür';
    } else {
    	echo 'Dosya belirtilen boyuttan büyüktür.';
    }

veya

    if($this->is_size($this->post['photo'], '1 TB')){
    	echo 'Dosya belirtilen boyuttan küçüktür';
    } else {
    	echo 'Dosya belirtilen boyuttan büyüktür.';
    }

veya

    if($this->is_size($this->post['photo'], '1 PB')){
    	echo 'Dosya belirtilen boyuttan küçüktür';
    } else {
    	echo 'Dosya belirtilen boyuttan büyüktür.';
    }
veya

    $size = '35 KB';
    $manuelsize = '35839';
    if($this->is_size($manuelsize, $size)){
    	echo 'Değer belirtilen boyuttan küçüktür';
    } else {
    	echo 'Değer belirtilen boyuttan büyüktür.';
    }
veya

    $size = '35 KB';
    $manuelsize = '35840';
    if($this->is_size($manuelsize, $size)){
    	echo 'Değer belirtilen boyuttan küçüktür';
    } else {
    	echo 'Değer belirtilen boyuttan büyüktür.';
    }


----------

## is_color()

Bu fonksiyon kendisiyle paylaşılan değerin geçerli bir renk olup olmadığını kontrol etmeye yarar, eğer söz konusu değer transparent veya tüm tarayıcılar ile uyumlu olan 148 renk isminden biriyse yada HEX, RGB, RGBA, HLS, HLSA ise yanıt olarak `true` değeri döndürülür, değilse `false` değeri döndürülür. `$color` renk değerini temsil etmektedir.
##### Örnek
##### TRANSPARENT

      $color = 'transparent';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

##### COLOR NAME

     $color = 'AliceBlue';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

##### HEX

      $color = '#000000';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

##### RGB

     $color = 'rgb(10, 10, 20)';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

##### RGBA

      $color = 'rgba(100,100,100,0.9)';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

##### HLS

      $color = 'hsl(10,30%,40%)';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

##### HLSA

      $color = 'hsla(120, 60%, 70%, 0.3)';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

----------

## is_url()

Kendisiyle paylaşılan verinin bir bağlantı olup olmadığını kontrol etmek amacıyla kullanılır, `$url` bağlantı verisini temsil etmekte olup `string` olarak belirtilmelidir. Eğer söz konusu veri bir bağlantıysa `true` değeri döndürülür, değilse `false` değeri döndürülür.

##### Örnek

    $str = 'example.com';
    if($this->is_url($str)){
        echo 'Bu bir bağlantıdır.';
    } else {
        echo 'Bu bir bağlantı değildir.';
    }

veya

    $str = 'www.example.com';
    if($this->is_url($str)){
        echo 'Bu bir bağlantıdır.';
    } else {
        echo 'Bu bir bağlantı değildir.';
    }

veya

    $str = 'http://example.com/';
    if($this->is_url($str)){
        echo 'Bu bir bağlantıdır.';
    } else {
        echo 'Bu bir bağlantı değildir.';
    }

veya

    $str = 'http://www.example.com/';
    if($this->is_url($str)){
        echo 'Bu bir bağlantıdır.';
    } else {
        echo 'Bu bir bağlantı değildir.';
    }

----------

## info()

Bu fonksiyon dosya barındıran bir yola ait bilgilere ulaşmak amacıyla kullanılır. Aldığı her iki parametre `string` olarak belirtilmelidir. `$str` yolu, `$type` bilgi türü parametresini temsil etmektedir.

#### Parametreler

-   dirname
-   basename
-   extension
-   filename

##### dirname: Dosyanın bulunduğu dizini öğrenmek

    $str  = $this->post['logo']['name'];
    $type = 'dirname';
    
    echo $this->info($str, $type);

##### basename: Uzantısıyla birlikte dosyanın adını öğrenmek

    $str  = $this->post['logo']['name'];
    $type = 'basename';
    
    echo $this->info($str, $type);

##### extension: Yalnız dosya uzantısını öğrenmek

    $str  = $this->post['logo']['name'];
    $type = 'extension';
    
    echo $this->info($str, $type);

##### filename: Yalnız dosya adını öğrenmek

    $str  = $this->post['logo']['name'];
    $type = 'filename';
    
    echo $this->info($str, $type);

----------

## filter()

Bu metod özel karakterleri, `sql_injection`, `xss` gibi istismar kodlarını etkisiz hale getirmek amacıyla kullanılır. `string` olarak gönderilen veriyi güvenli hale getirip geri döndürür. İçinde bulunan metodlar aşağıda ki gibidir.

-   `filter_var`
    -   `FILTER_SANITIZE_FULL_SPECIAL_CHARS`
-   `preg_replace`
    -   `~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u`

##### Örnek

    $content = "%&%()' OR 1=1 karakterleri etkisizleştirilmiştir.";
    echo $this->filter($content);

veya


    $content = "<script>alert('XSS Açığı var'); </script>";
    echo $this->filter($content);

----------

## request()

`$_GET`, `$_POST` ve `$_FILES` isteklerini güvenli ve düzenli bir yapıya kavuşturmak amacıyla kullanılır, Verilere `$this->post` dizi değişkeni içinden erişilir,`Mind.php` dosyasında bulunan `__construct()` metodu içinde çalıştırılarak etkin hale getirilmiştir.

##### type="text" kullanımı

    <form method="post">  
	    <input type="text" name="username"> 
	    <input type="password" name="password"> 
	    <button type="submit">Send!</button>
     </form>

    print_r($this->post);
    echo $this->post['username'];
    echo $this->post['password'];

##### type="text" ve type="file" (Dosya) kullanımı

    <form method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="singlefile"> 
    	<button type="submit">Send!</button>
     </form>

    print_r($this->post);
    echo $this->post['username'];
    echo $this->post['password'];
    echo $this->post['singlefile']['name'];

##### type="text" ve type="file" (Dosyalar) kullanımı

    <form method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="multifile[]" multiple="multiple"> 
    	<button type="submit">Send!</button>
     </form>

    print_r($this->post);
    echo $this->post['username'];
    echo $this->post['password'];
    print_r($this->post['multifile']);

----------

## redirect()

Belirtilen adrese yönlendirme yapmak amacıyla kullanılır, boş bırakılırsa `Mind.php` dosyasının bulunduğu klasör'e yönlendirme yapar. Adres `string` olarak belirtilmelidir.

##### Örnek

    $this->redirect();

veya

    $this->redirect('contact');

veya

    $this->redirect('https://www.google.com');

----------

## mindload()

Belirtilen dosya veya dosyaları projeye dahil etmek amacıyla kullanılır. `$file` ve `$cache`, dosyalara ait yollarının tutulduğu değişkenleri temsil etmektedir. 

Her iki değişkene de `string` veya `dizi` olarak dosya yolları gönderilebilir, eğer dosyalar varsa projeye `require_once` yöntemiyle dahil edilirler. 

Öncelikle `$cache` dosyaları, ardından `$file` değişkenlerinde bulunan dosyalar projeye dahil edilir. `$cache` değişkeni isteğe bağlı olup, belirtilme zorunluluğu bulunmamaktadır. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

#####Örnek

    $this->mindload('app/views/home');

veya

    $file = array(
        'app/views/header',
        'app/views/content',
        'app/views/footer'
    );
    $this->mindload($file);

veya

    $this->mindload('app/views/home', 'app/modal/home');

veya

    $file = array(
        'app/views/layout/header',
        'app/views/home',
        'app/views/layout/footer
    );
    $cache = array(
        'app/middleware/auth',
        'app/database/install',
        'app/modal/home'
    );
    $this->mindload($file, $cache);
----------

## permalink()

Kendisiyle paylaşılan veriyi arama motoru dostu bir link yapısına dönüştürmek amacıyla kullanılır. İki parametre alabilir, ikinci parametre isteğe bağlı olup belirtilme zorunluluğu bulunmamaktadır. İlk parametre de link yapısına dönüştürülmek istenen veri `string` olarak, ikinci parametre de ise veri içinde değiştirilmesi istenen kelimeler `dizi` olarak tutulur.

##### Örnek

    $str = 'Merhaba dünya';
    echo $this->permalink($str);

veya

    $str = 'Merhaba dünya';
    $arr = array(
        'replacements' => array(
            'dünya'=>'dostum'
        )
    );
    echo $this->permalink($str, $arr);

----------

## timezones()

Bu fonksiyon, zaman damgasını isabetli kılmak amacıyla tercih edilen `date_default_timezone_set()` fonksiyonunda kullanılabilen bölge kodlarını dizi halinde sunar. Daha fazla bilgi için [Desteklenen Zaman Dilimlerinin Listesi](https://secure.php.net/manual/tr/timezones.php) sayfasını inceleyebilirsiniz.

    print_r($this->timezones());

----------

## session_check()

`session_start()` komutunun kişiselleştirilmiş şekilde uygulanmasını sağlamak amacıyla kullanılır, Oturum Ayarları kısmında bulunan ayarlar ışığında oturumun akıbetini belirlemeye yarar,`Mind.php` dosyasında bulunan `__construct()` metodu içinde çalıştırılarak etkin hale getirilmiştir.

    $this->session_check();

----------

## route()

Route fonksiyonu özelleştirilebilir rotalar tanımlamak ve bu rotalara özel zihinler yüklemek için kullanılır. Zihin kelimesi, Modal, View, Controller, Middleware gibi çeşitli katmanları tanımlamak amacıyla kullanılmıştır. Böylelikle geliştirici, katmanların hangi rotaya tanımlandığını açıkça görebilir, yönetilebilir ve proje ihtiyacına özel tasarım deseni oluşturabilir.  
  

#### Giriş

`url`, `file` ve `cache` parametreleri alabilen `route()` fonksiyonu, `url` parametresini `string` olarak kabul eder, `file` ve `cache` parametreleriniyse `string` ve `dizi` olarak kabul etmektedir. Bu üç parametreden sadece `cache` parametresinin belirtilme zorunluluğu yoktur. `file` ve `cache` parametreleri, uzantısı belirtilmeyen `php` dosyalarının yollarından meydana gelir.

#### Url

`/` slaş sembolü dışında ki rotalara parametre isimleri tanımlamak mümkündür, eğer adres satırına `edit/users/1` yazılırsa ve `users` parametresini `table` ismiyle, `1` parametresini ise `id` ismiyle isimlendirmek istenirse, aşağıda ki yolu izlemek gerekir.

    $this->route('edit:table@id', 'app/view/edit');

Kontrolü sağlamak için `app/view/edit` yolunda ki `edit.php` dosyası içine

    print_r($this->post);

kodu eklendikten sonra, adres satırına `edit/users/1` yazarak, parametre isimlerinin `url` de tanımlanan parametre isimlerine pay edildiği görülebilir.

    Array (
        [table] => users
        [id] => 1
    )

Ayrıca adres satırına `edit/users/1/2/diger` gibi rota da isimlendirilmemiş parametreler yazılırsa bunlar görmezden gelinir. Eğer `url` parametresine aşağıda ki gibi parametre isimleri tanımlanmamışsa

    $this->route('edit', 'app/view/edit');

ve ulaşılmak istenen rota adresi `edit/users/1` ise, `app/view/edit` yolunda ki `edit.php` dosyası içine

    print_r($this->post);

kodu eklendiğinde, isimlendirilmemiş parametreler aşağıda ki şekilde görünecektir.

    Array (
        [0] => users
        [1] => 1
    )

#### File

`cache` parametresinde belirtilen dosya veya dosyalar projeye dahil edildikten sonra projeye `file` parametresinde tanımlanan dosya(lar) dahil edilir.

##### Örnek

    $this->route('/', 'app/view/home');

veya

    $arr = array(
        'app/view/layout/header',
        'app/view/home',
        'app/view/layout/footer'
        );
    $this->route('/', $arr);

#### Cache

Eğer `cache` parametresi belirtilirse, belirtilen `cache` dosyaları, `file` parametresinde belirtilen dosya(lar) henüz projeye dahil edilmeden önce, ilk eklenenden son eklenene doğru tek tek varlık kontrolünden geçirilerek projeye dahil edilir.

##### Örnek

    $this->route('/', 'app/view/home', 'database/CreateTable');

veya

    $arr = array(
        'database/CreateTable,
        'modal/home'
    );
    $this->route('/', 'view/home', $arr);

#### .htaccess

`route()` fonksiyonu kullanıldığı zaman, eğer `Mind.php` dosyasının bulunduğu dizinde ve o dizinde ki klasörlerde `.htaccess` dosyası yoksa oluşturulur. Klasörlerin içinde oluşturulan `.htaccess` dosyası direkt erişimi engelleyen komut içerir. `Mind.php` ile aynı dizinde oluşturulan `.htaccess` dosyası ise anlamlı `url` rotalarını elde etmeyi sağlayan aşağıda ki komutları içerir.

##### Örnek

    Deny from all

veya

    RewriteEngine On  
    RewriteCond %{REQUEST_FILENAME} -s [OR]  
    RewriteCond %{REQUEST_FILENAME} -l [OR]  
    RewriteCond %{REQUEST_FILENAME} -d  
    RewriteRule ^.*$ - [NC,L]  
    RewriteRule ^.*$ index.php [NC,L]

----------

## write()

Belirtilen içeriği, belirtilen isimde ki dosyaya yazmak amacıyla kullanılır, eğer işlem başarılıysa `true`, değilse `false`  değeri döndürülür. İki parametre alır;

##### ilk parametre

içeriği temsil etmekte olup `string` veya `dizi` türünde gönderilebilir, dizi olarak gönderilmesi halinde dizi elemanları aralarına `:` sembolü eklenerek `string`'e dönüştürülmüş şekilde dosyaya yazılır.

##### ikinci parametre

Dosya yolunu temsil etmektedir, eğer dosya varsa söz konusu veri dosyanın sonuna eklenir, eğer dosya yoksa yolda belirtilen isimde bir dosyayı oluşturulur ve bu dosyaya yazılır.

    $str = 'Merhaba dünya';
    $this->write($str, 'yeni.txt');

veya

    $str = array('Merhaba', 'Dünya');
    $this->write($str, 'yeni.txt');

----------

## upload()

Belirtilen dosya veya dosyaları, belirtilen klasöre yüklemek amacıyla kullanır, `$this->post['singlefile']` ve `$this->post['multifile']` dosyaların tutulduğu değişkenleri `$path` ise dosyaların yükleneceği klasör yolunu temsil etmektedir.

##### Örnek

    <form method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="singlefile"> 
    	<button type="submit">Send!</button>
     </form>

    $path = './upload';
    $u = $this->upload($this->post['singlefile'], $path);
    print_r($u);

veya 

    <form method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="multifile[]" multiple="multiple"> 
    	<button type="submit">Send!</button>
     </form>

    $path = './upload';
    $u = $this->upload($this->post['multifile'], $path);
    print_r($u);

## get_contents()

Kendisiyle paylaşılan `string` yapıda ki veri de veya bir  url'nin varış noktasında bulunan sayfanın kaynak kodunda, `$left` ve `$right` değişkenlerinde belirtilen değerlerin arasında ki içeriği elde etmeye yarar. `$left` sol tarafta ki, `$right` sağ tarafta ki kapsayıcı parametresini temsil etmektedir. Bir veya birden fazla öğe bulunuyorsa hepsini bir `dizi` olarak sunar. 

##### Örnek

    $url 	= 'https://www.cloudflare.com/';
    $left 	= '<title>';
    $right	= '</title>';
    $data 	= $this->get_contents($left, $right, $url);
    print_r($data);

veya

    $url 	= 'https://www.cloudflare.com/';
    $left 	= '<h1 class="header-h1">';
    $right	= '</h1>';
    $data 	= $this->get_contents($left, $right, $url);
    print_r($data);
    
veya

    $url 	= 'Örnek bir içeriktir. <title>Merhaba Dünya!</title>';
    $left 	= '<title>';
    $right	= '</title>';
    $data 	= $this->get_contents($left, $right, $url);
    print_r($data);




[]: https://github.com/aliyilmaz/Mind/archive/master.zip
