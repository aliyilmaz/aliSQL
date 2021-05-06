# Mind nedir?

Mind, geliştiriciler için tasarlanmış PHP kod çerçevesidir. Tasarım desenleri, uygulamalar ve kod çerçeveleri oluşturmak için çeşitli çözümler sunar. 
 
---------- 

## Edinme

Mind sınıfını edinmenin iki yolu vardır;

- Mind [deposu](https://github.com/aliyilmaz/Mind/archive/master.zip)
- Project [deposu](https://github.com/aliyilmaz/project/archive/master.zip)

---------- 

## Kurulum

##### Mind deposu için:
* Yerel veya web sunucunuzda bulunan proje ana dizinine, edindiğiniz **Zip** dosyası içindeki **src** yolunda yeralan **Mind.php** dosyasını çıkarın.

* **Mind.php** dosyasını **include** ya da **require_once** gibi bir yöntemle projenizin **index.php** dosyasına dahil edin ve **extends** veya **new Mind()** komutu yardımıyla kurulum işlemini tamamlayın. 

###### Örnek
 
    require_once('./Mind.php');
    $Mind = new Mind();

veya

    require_once('./Mind.php');
    class ClassName extends Mind{
        public function __construct($conf = array())
        {
            parent::__construct($conf);
        }

    }
   

##### Project deposu için:
* Yerel veya web sunucunuzda bulunan proje ana dizinine, edindiğiniz **Zip** dosyası içeriğini olduğu gibi çıkarın.


----------

## Veritabanı Ayarları

Sınıfı kullanmak için veritabanı bilgilerini sınıf çağrılırken veya **Mind.php** dosyasında tanımlamak gerekir.

#### Örnek

    $conf = array(
        'host'      =>  'localhost',
        'dbname'    =>  'mydb',
        'username'  =>  'root',
        'password'  =>  ''
    );
    $Mind = new Mind($conf);

veya

    private $host        = 'localhost';
    private $dbname      = 'mydb';
    private $username    = 'root';
    private $password    = '';
    
----------

## Oturum Ayarları

Kullanıcılar için oluşturulan oturumları özelleştirmek veya kapatmak için kullanılan metotdur. Oturumları kapatmak için, `session_status` parametresi `false` olarak, açmak içinse `true` olarak güncellenmelidir. 

Oturumların saklandığı klasör yolunu değiştirmek için, `path` parametresinin güncellenmesi gerekir. Belirtilen yolda oturumların tutulması görevini etkinleştirmek için  `path_status` parametresi `true` olarak güncellenmelidir. 

**Bilgi:** Oturum Ayarları **varsayılan olarak** sunucu ayarlarına göre yapılandırılmıştır.

#### Örnek

    private $sess_set    = array(
        'path'              =>  './session/',
        'path_status'       =>  false,
        'status_session'    =>  true
    );

----------

## Zaman Dilimi Ayarı

İçeriğin doğru zaman damgasıyla işaretlenebilmesi için zaman dilimini kişiselleştirmek mümkündür. Varsayılan olarak `Europe/Istanbul` tanımlanmıştır. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır. Daha fazla bilgi için [Desteklenen zaman dilimlerinin listesi](https://secure.php.net/manual/tr/timezones.php) bölümüne bakabilirsiniz.

**Bilgi:** Gerektiği kadar kişiselleştirilmemiş sunucular proje zaman diliminden farklı zaman dilimi kullanabilmektedir, bu kısımda ki yapılan düzenleme farklı sunucularda doğru zaman damgasına sahip olmayı sağlar. 

#### Örnek

    public $timezone    = 'Europe/Istanbul';

----------

## Herkese açık dizin ayarları

**Mind.php** dosyasıyla aynı dizinde bulunan ve herkesin erişimine açık olması istenen klasör isimleri bu ayar yardımıyla tanımlanır. Varsayılan olarak `public` değeri tanımlandığı için belirtilme zorunluluğu yoktur. Sınıf dışından erişime müsaade etmek için `public` özelliği tanımlanmıştır.

İki farklı kullanım şekli vardır. 

##### Sınıfı çağırdığımız **index.php** içinde tanımlama yapmak


#### Örnek

    $conf = array(
        'host'              =>  'localhost',
        'dbname'            =>  'mydb',
        'username'          =>  'root',
        'password'          =>  '',
        'allow_folders'     =>  'public'
    );
    $Mind = new Mind($conf);

veya 

    $conf = array(
        'host'              =>  'localhost',
        'dbname'            =>  'mydb',
        'username'          =>  'root',
        'password'          =>  '',
        'allow_folders'     =>  array(
            'public',
            'public1'
        )
    );
    $Mind = new Mind($conf);


##### **Mind.php** dosyası içinde tanımlama yapmak

#### Örnek

    public $allow_folders = 'public';
    
veya

    public $allow_folders = array(
        'public',
        'public1'
    );
    

**Bilgi:** Herkesin erişimine açık dizinler, image, js, css gibi çeşitli arayüz varlıklarının çalışabilmesi için gerekli alanlardır. Özel dosyalarınızı bu alanlarda barındırmayınız.

----------


## Etkin Metodlar

Oturum yönetimi, **$_GET**, **$_POST** ve **$_FILES** istekleri, hata raporlama, işlem bekleme süresi gibi gereksinimleri karşılayan yöntemler, **Mind.php** dosyası içinde bulunan **__construct()** metodu içinde çalıştırılarak etkinleştirilmiştir.

-   [session_check()](#session_check)
-   [request()](#request)
-   error_reporting(-1)
-   error_reporting(E_ALL) 
-   ini_set('display_errors', 1)   
-   set_time_limit(0)
-   ini_set('memory_limit', '-1')

----------

## Etkin Değişkenler

##### public $post

Sınıfın dahil edildiği projede yapılan `$_GET`, `$_POST` ve `$_FILES` istekleri, `$this->post` değişkeninde tutulur. Sınıf dışından erişime müsaade etmek için `public` özelliği tanımlanmıştır.

##### public $base_url

**Mind.php** dosyasının içinde bulunduğu klasörün yolu `$this->base_url` değişkeninde tutulur. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $allow_folders

**Mind.php** dosyasının bulunduğu dizinde, herkese açık olması istenen klasör isimleri `$this->allow_folders`  değişkeninde tutulur. `string` ya da `array` türünde klasör isimleri belirtilebilir. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.


##### public $page_current

Görüntülenmekte olan sayfa yolu `$this->page_current` değişkeninde tutulur. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $page_back

Önceki sayfa yolu `$this->page_back` değişkeninde tutulur. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $timezone

Projenin zaman dili tutulur, varsayılan olarak `Europe/Istanbul` olarak belirtilmiştir. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $timestamp

Projenin zaman damgası, **yıl-ay-gün saat:dakika:saniye** biçiminde `$this->timestamp` değişkeninde tutulur. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $lang

Çoklu dil desteği için ayarların tutulduğu değişkendir, Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $error_status

Hata durumlarını `true` veya `false` olarak taşıyan değişkendir, varsayılan olarak `false` belirtilmiştir. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### public $error_file

Hata durumunda yüklenmesi istenen dosya yolunu taşıyan değişkendir, varsayılan olarak `app/views/errors/404` belirtilmiştir, eğer söz konusu dosya yoksa boş bir sayfa gösterilir. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

#### public  $errors

Hata mesajlarının tutulduğu değişkendir, dışarıdan erişime izin vermek için `public` özelliği tanımlanmıştır. 

----------

## Metodlar

##### Temel

-   [__construct](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#__construct)
-   [__destruct](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#__destruct)

##### Veritabanı

-   [selectDB](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#selectDB)
-   [dbList](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#dbList)
-   [tableList](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#tableList)
-   [columnList](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#columnList)
-   [dbCreate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#dbCreate)
-   [tableCreate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#tableCreate)
-   [columnCreate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#columnCreate)
-   [dbDelete](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#dbDelete)
-   [tableDelete](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#tableDelete)
-   [columnDelete](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#columnDelete)
-   [dbClear](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#dbClear)
-   [tableClear](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#tableClear)
-   [columnClear](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#columnClear)
-   [insert](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#insert)
-   [update](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#update)
-   [delete](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#delete)
-   [getData](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#getData)
-   [samantha](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#samantha)
-   [theodore](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#theodore)
-   [amelia](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#amelia)
-   [do_have](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#do_have)
-   [getId](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#getId)
-   [newId](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#newId)
-   [increments](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#increments)
-   [tableInterpriter](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#tableInterpriter)
-   [backup](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#backup)
-   [restore](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#restore)
-   [pagination](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#pagination)
-   [translate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#translate)

##### Doğrulayıcı

-   [is_db](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_db)
-   [is_table](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_table)
-   [is_column](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_column)
-   [is_phone](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_phone)
-   [is_date](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_date)
-   [is_email](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_email)
-   [is_type](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_type)
-   [is_size](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_size)
-   [is_color](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_color)
-   [is_url](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_url)
-   [is_http](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_http)
-   [is_https](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_https)
-   [is_json](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_json)
-   [is_age](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_age)
-   [is_iban](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_iban)
-   [is_ipv4](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_ipv4)
-   [is_ipv6](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_ipv6)
-   [is_blood](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_blood)
-   [is_latitude](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_latitude)
-   [is_longitude](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_longitude)
-   [is_coordinate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_coordinate)
-   [is_distance](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_distance)
-   [is_md5](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_md5)
-   [is_ssl](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_ssl)
-   [is_htmlspecialchars](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#is_htmlspecialchars)
-   [validate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#validate)

##### Yardımcı

-   [accessGenerate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#accessgenerate)
-   [print_pre](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#print_pre)
-   [arraySort](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#arraySort)
-   [info](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#info)
-   [request](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#request)
-   [filter](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#filter)
-   [firewall](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#firewall)
-   [redirect](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#redirect)
-   [permalink](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#permalink)
-   [timezones](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#timezones)
-   [languages](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#languages)
-   [currencies](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#currencies)
-   [session_check](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#session_check)
-   [remoteFileSize](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#remoteFileSize)
-   [mindLoad](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#mindLoad)
-   [cGeneration](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#cGeneration)
-   [pGeneration](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#pGeneration)
-   [generateToken](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#generateToken)
-   [coordinatesMaker](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#coordinatesMaker)
-   [encodeSize](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#encodeSize)
-   [decodeSize](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#decodeSize)
-   [getIPAddress](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#getipaddress)

##### Sistem

-   [getOS](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#getOS)
-   [getSoftware](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#getsoftware)
-   [route](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#route)
-   [write](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#write)
-   [upload](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#upload)
-   [download](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#download)
-   [get_contents](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#get_contents)
-   [distanceMeter](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#distanceMeter)
-   [evalContainer](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#evalContainer)

----------

## __construct()

[Kurulum](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#Introduction) aşamasında belirtilen bilgiler ışığında veri tabanı bağlantısı sağlamak ve [Etkin Metodllar](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#etkin-metodlar) kısmında yeralan metodların etkinleştirilmesi için kullanılır. 

----------

## __destruct()

Metodlar içinde değişime uğrayan istek ve durumların kaderinin belirlenmesi için kullanılır. Örneğin herhangi bir kısımda hata durumu varsa hata sayfasının görüntülenmesi gibi.

----------

## selectDB()

[Kurulum](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#kurulum) aşamasında belirtilen kullanıcının yetkilendirildiği veritabanına bağlanmak amacıyla kullanılır. Veritabanı adı `string` olarak belirtilmelidir.

##### Örnek

    $this->selectDB('mydb1');

----------

## dbList()

[Kurulum](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#kurulum) aşamasında belirtilen kullanıcının yetkilendirildiği veritabanlarını listelemek amacıyla kullanılır.

##### Örnek

    $this->print_pre($this->dbList());

----------

## tableList()

Belirtilen veritabanına ait tabloları listelemek amacıyla kullanılır. Veritabanı adı `string` olarak belirtilmelidir.

##### Örnek

    $this->print_pre($this->tableList('mydb'));

----------

## columnList()

Belirtilen veritabanı tablosuna ait sütunları listelemek amacıyla kullanılır. Veritabanı tablo adı `string` olarak belirtilmelidir.

##### Örnek

    $this->print_pre($this->columnList('users'));

----------

## dbCreate()

Yeni bir veya daha fazla veritabanı oluşturmak amacıyla kullanılır, `mydb0` ve `mydb1` veritabanı adlarını temsil etmektedir, oluşturulacak veritabanı isimleri `string` veya `array` olarak gönderildiğinde veritabanı oluşturma işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür. Eğer projeye tanımlanan veritabanı adı `dbCreate()` metoduna gönderilmişse, oluşturulduktan sonra o veritabanı seçilir.

##### Örnek

    $this->dbCreate('mydb0');

veya

    $this->dbCreate(array('mydb0','mydb1'));

----------

## tableCreate()

Yeni bir veritabanı tablosu oluşturmak amacıyla kullanılır. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür. 


##### Özellikler

-   int - (`int`)
-   decimal - (`decimal`)
-   string - (`varchar`)
-   small - (`text`)
-   medium - (`mediumtext`)
-   large - (`longtext`)
-   increments - (`auto_increment`)

##### Örnek

    $scheme = array(
        'id:increments',
        'username:small',
        'password',
        'address:medium',
        'about:large',
        'amount:decimal:6,2',
        'title:string:120',
        'age:int'
    );
    $this->tableCreate('phonebook', $scheme);

****Bilgi:**** Bir sütun oluşturma hakkında daha fazla bilgi için [columnCreate](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#columnCreate) metoduna bakın.

----------

## columnCreate()

Veritabanı tablosunda bir veya daha fazla sütun oluşturmak amacıyla kullanılır, Sütun adı ve özelliği `array` olarak gönderilebilir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür. 

##### Özellikler

-   int - (`int`)
-   decimal - (`decimal`)
-   string - (`varchar`)
-   small - (`text`)
-   medium - (`mediumtext`)
-   large - (`longtext`)
-   increments - (`auto_increment`)

#### Örnek

    $scheme = array(
        'id:increments',
        'username:small',
        'password',
        'address:medium',
        'about:large',
        'amount:decimal:6,2',
        'title:string:120',
        'age:int'
    );
    $this->columnCreate('phonebook', $scheme);


#### int

Sayıları tutmak için kullanılır. 3 parametre alır. `number`:`int`:`11` ilk parametre sütun adıdır. ikinci parametre sütun türüdür. Üçüncü parametre sütun değerlerinin maksimum limitidir. Üçüncü parametre zorunlu değildir, eğer belirtilmezse varsayılan olarak `11` değerini alır.

##### Örnek

    $scheme = array(
        'number:int:12'
    );
    $this->columnCreate('phonebook', $scheme);
    
veya

    $scheme = array(
        'number:int'
    );
    $this->columnCreate('phonebook', $scheme);
 
 
 #### decimal
 
Parasal değerleri tutmak için kullanılır, 3 parametre alır. `amount`:`decimal`:`6,2` ilk parametre sütun adıdır. İkinci parametre sütun türüdür. Üçüncü parametreyse sütunun aldığı değerdir.  Üçüncü parametre zorunlu değildir, eğer belirtilmezse varsayılan olarak `6,2` değerini alır.
 
 ##### Örnek
 
     $scheme = array(
         'amount:decimal:6,2'
     );
     $this->columnCreate('phonebook', $scheme);
     
veya

 
     $scheme = array(
         'amount:decimal'
     );
     $this->columnCreate('phonebook', $scheme);
     
#### string (varchar)

Belirtilen karakter uzunluğuna sahip string veri tutmak için kullanılır. 3 parametre alır. `title`:`string`:`120` ilk parametre sütun adıdır. İkinci parametre sütun türüdür. Üçüncü parametreyse sütunun taşıyacağı string değerin maksimum karakter sayısını temsil etmektedir. Üçüncü parametre zorunlu değildir, eğer belirtilmezse varsayılan olarak `255` değerini alır.

  ##### Örnek
   
       $scheme = array(
           'title:string:120'
       );
       $this->columnCreate('phonebook', $scheme);
       
  veya
  
   
       $scheme = array(
           'title:string'
       );
       $this->columnCreate('phonebook', $scheme);
     
#### small (text)

`65535` karakterlik string yapıda ki veriyi tutmak amacıyla kullanılır. 2 parametre alır. `content`:`small` ilk parametre sütunun adı, ikinci parametre sütunun türüdür. İkinci parametre zorunlu değildir. Eğer ikinci parametre belirtilmezse sütun varsayılan olarak `small` türünü alır.

 ##### Örnek
   
       $scheme = array(
           'content:small'
       );
       $this->columnCreate('phonebook', $scheme);
       
  veya
  
   
       $scheme = array(
           'content'
       );
       $this->columnCreate('phonebook', $scheme);
       
#### medium (mediumtext)

`16777215` karakterlik string yapıda ki veriyi tutmak amacıyla kullanılır. 2 parametre alır. `description`:`medium` ilk parametre sütun adı, ikinci parametre sütun türüdür. Her iki parametrenin de belirtilme zorunluluğu bulunmaktadır.


 ##### Örnek
   
       $scheme = array(
           'description:medium'
       );
       $this->columnCreate('phonebook', $scheme);
  
#### large (longtext)

`4294967295` karakterlik string yapıda ki veriyi tutmak amacıyla kullanılır. 2 parametre alır. `content`:`large` ilk parametre sütun adı, ikinci parametre sütun türüdür. Her iki parametrenin de belirtilme zorunluluğu bulunmaktadır.

 ##### Örnek
   
       $scheme = array(
           'content:large'
       );
       $this->columnCreate('phonebook', $scheme);     

#### increments (auto_increment)

Veritabanı tablosuna her eklenen kaydın otomatik artan bir numaraya sahip olması amacıyla kullanılır. 3 parametre alır. `id`:`increments`:`11` ilk parametre sütun adıdır. İkinci parametre sütun türüdür. Üçüncü parametreyse artışın basamaksal maksimum limitini temsil etmektedir. Üçüncü parametre zorunlu değildir, eğer belirtilmezse varsayılan olarak `11` değerini alır.

 ##### Örnek
   
       $scheme = array(
           'id:increments:12'
       );
       $this->columnCreate('phonebook', $scheme);
       
  veya
  
   
       $scheme = array(
           'id:increments'
       );
       $this->columnCreate('phonebook', $scheme);

----------

## dbDelete()

Bir veya daha fazla veritabanını silmek amacıyla kullanılır, `mydb0` ve `mydb1` veritabanı adlarını temsil etmektedir, `string` veya `array` olarak veritabanı isimleri gönderildiğinde veritabanı silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->dbDelete('mydb0');

veya

    $this->dbDelete(array('mydb0','mydb1'));

----------

## tableDelete()

Bir veya daha fazla veritabanı tablosunu silmek amacıyla kullanılır, `my_table0` ve `my_table1` veritabanı tablo isimlerini temsil etmektedir, `string` veya `array` olarak tablo isimleri gönderildiğinde silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->tableDelete('my_table0');

veya

    $this->tableDelete(array('my_table0', 'my_table1'));

----------

## columnDelete()

Veritabanı tablosunda bulunan bir veya daha fazla sütunu silmek için kullanılır. `users` tablo adını, `username` ve `password` silinmesi istenen sütunları temsil eder. `string` veya `array` olarak sütun isimleri gönderildiğinde silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->columnDelete('users', 'username');

veya

    $this->columnDelete('users', array('username', 'password'));

----------

## dbClear()

Bir veya daha fazla veritabanı içeriğini (auto_increment değerleri dahil) silmek amacıyla kullanılır, `mydb0` ve `mydb1` veritabanı adlarını temsil etmektedir. Veritabanı isimleri `string` veya `array` olarak gönderildiğinde silme işlemi gerçekleşir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->dbClear('mydb0');

veya

    $this->dbClear(array('mydb0','mydb1'));

----------

## tableClear()

Bir veya daha fazla veritabanı tablosu içindeki kayıtların tamamını(auto_increment değerleri dahil) silmek amacıyla kullanılır. Veritabanı tablo isimleri `string` veya `array` olarak gönderilebilir. `my_table0` ve `my_table1` veritabanı tablo isimlerini temsil etmektedir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->tableClear('my_table0');

veya

    $this->tableClear(array('my_table0', 'my_table1'));

----------

## columnClear()

Bir veritabanı tablosunda bulunan bir veya daha fazla sütuna ait kayıtların tamamını silmek amacıyla kullanılır. `string` veya `array` olarak sütun isimleri gönderilebilir. `username` ve `password` sütun isimlerini temsil eder. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $this->columnClear('username');

veya

    $this->columnClear(array('username', 'password'));
    
----------

## insert()

Veritabanı tablosuna bir veya daha fazla kayıt eklemek amacıyla kullanılır. 3 parametre alır, ilk parametre veritabanı tablo adı, ikincisi verilerin bulunduğu `array` veya `array`'ler içindir. 3'ncü parametre ise `trigger` yani tetikleyici görevleri içindir ve kullanım şekli aşağıda bilgilerinize sunulmuştur. Tüm işlem(ler) başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    $query = $this->insert('my_table', array(
    	'title' => 'test user',
    	'content' => '123456',
    	'tag' => 'test@mail.com'
    ));

veya

    $query = $this->insert('my_table', array(
            array(
                'name'          => 'Ali Yılmaz',
                'phone'         => '10101010101',
                'email'         => 'aliyilmaz.work@gmail.com',
                'created_at'    =>  date('d-m-Y H:i:s')
            ),
            array(
                'name'          => 'Deniz Yılmaz',
                'phone'         => '20202020202',
                'email'         => 'deniz@gmail.com',
                'created_at'    =>  date('d-m-Y H:i:s')
            ),
            array(
                'name'          => 'Hasan Yılmaz',
                'phone'         => '30303030303',
                'email'         => 'hasan@gmail.com',
                'created_at'    =>  date('d-m-Y H:i:s')
            )
        )
    );

veya

    $values = array(
        'username'=>'aliyilmaz1',
        'password'=>'1111111111'
    );
    $trigger = array(
        'users'=>array(
            'username'=>'aliyilmaz2',
            'password'=>'2222222222'
        ),
        'log'=>array(
            'data'=>'test'
        )
    );
    if($this->insert('users', $values, $trigger)){
        echo 'Kayıt eklendi.';
    } else {
        echo 'Kayıt eklenemedi.';
    }

veya 

    $values = array(
        'username'=>'aliyilmaz1',
        'password'=>'1111111111'
    );
    $trigger = array(
        'users'=>array(
            array(
                'username'=>'ali1',
                'password'=>'pass1'
            ),
            array(
                'username'=>'ali2',
                'password'=>'pass2'
            )
        ),
        'log'=>array(
            'data'=>'test'
        )
    );
    if($this->insert('users', $values, $trigger)){
        echo 'Kayıt eklendi.';
    } else {
        echo 'Kayıt eklenemedi.';
    }

----------

## update()

Veritabanı tablosunda bulunan bir kaydı güncellemek amacıyla kullanılır. `my_table` veritabanı tablo adını temsil eder. `title`, `content` ve `tag` ise `my_table` tablosu içinde ki sütunları temsil eder. `17` güncellenmesi istenen kaydın `id`'sini temsil eder. Yeni değerler `array` şeklinde gönderildiğinde güncelleme işlemi gerçekleşir. `id` parametresini `auto_increment` özelliği tanımlanmayan bir sütunda aramak için sütun adını 4'ncü parametre de belirtmek gerekir. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

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

Veritabanı tablosunda bulunan bir veya daha fazla kaydı silmek amacıyla kullanılır. Bu silme işlemini yaparken başka tablolarda kayıt silmesi de mümkündür. Geliştirici alışkanlıklarına göre çeşitli kullanım şekiller sunar. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

#### auto_increment değer(ler)i göndererek kayıt(ları) silmek

Bu kullanım şeklinde, auto_increment özelliği tanımlanmış bir sütunda belirtilen parametre(ler) aranır ve bulunan kayıtlar silinir, tablo adı ve parametre(ler) belirtmek zorunludur. 3'ncü parametrede belirtilen `boolean` türündeki değer, parametrenin varlığına bakmaksızın silmeye zorlar. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek


    if($this->delete('users', 73)){
        echo 'Kayıt silindi.';
    } else {
        echo 'Kayıt silinemedi.';
    }

veya

    if($this->delete('users', 66, true)){
        echo 'Kayıt silindi.';
    } else {
        echo 'Kayıt silinemedi.';
    }

veya


    if($this->delete('users', array(74,75))){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }

veya 

    if($this->delete('users', array(76,77), true)){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }


#### Sütun adı belirterek kayıt(ları) silmek
Bu kullanım şeklinde, `auto_increment` özelliği tanımlanmayan bir sütunda parametre(ler) aranır, bulunan kayıt(lar) silinir. Sütun adını 3'ncü parametrede belirtmek gerekir. 4'ncü parametrede belirtilen `boolean` türündeki değer, parametrenin varlığına bakmaksızın silmeye zorlar. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    if($this->delete('users', 'fikret', 'username')){
        echo 'Kayıt silindi.';
    } else {
        echo 'Kayıt silinemedi.';
    }

veya 

    if($this->delete('users', 'fikret', 'username', true)){
        echo 'Kayıt silindi.';
    } else {
        echo 'Kayıt silinemedi.';
    }

veya

    if($this->delete('users', array('julide', 'Fatih'), 'username')){
        echo 'Kayıt silindi.';
    } else {
        echo 'Kayıt silinemedi.';
    }
  
veya

    if($this->delete('users', array('julide', 'Fatih'), 'username', true)){
        echo 'Kayıt silindi.';
    } else {
        echo 'Kayıt silinemedi.';
    }


#### Bağlantılı kayıtlarla birlikte silmek
Söz konusu parametreyi taşıyan başka tablo sütunları varsa bu tablo ve sütun isimlerinin belirtilmesi halinde, eşleşen ilintili kayıtların silinmesi sağlanır. Aşağıdaki kullanım şekline göre 4 ve 5'nci parametrede belirtilen `boolean` türündeki değer, parametrenin varlığına bakmaksızın silmeye zorlar. İşlem başarılıysa `true`, değilse `false` yanıtı döndürülür.

##### Örnek

    if($this->delete('users', 1, array('log'=>'user_id'))){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }

veya 

    if($this->delete('users', 1, array('log'=>'user_id'), true)){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }


veya 

    if($this->delete('users', array(2,3), array('log'=>'user_id'))){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }

veya

    if($this->delete('users', array(4,5), array('log'=>'user_id'), true)){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }

veya

    if($this->delete('users', 'Fatih', 'username', array('log'=>'username'))){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }

veya

    if($this->delete('users', 'Fatih', 'username', array('log'=>'username'), true)){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }    

veya

    if($this->delete('users', array('Fatih','aliyilmaz'), 'username', array('log'=>'username'))){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }

veya

    if($this->delete('users', array('Fatih','aliyilmaz'), 'username', array('log'=>'username'), true)){
        echo 'Kayıtlar silindi.';
    } else {
        echo 'Kayıtlar silinemedi.';
    }

----------

## getData()

Bir veritabanı tablosundaki kayıtları olduğu gibi veya filtreleyerek elde etmek için kullanılır. `my_table` tablo ismini temsil etmektedir, `$options` parametreleri ve kullanım örneklerine aşağıda yer verilmiştir.



#### Tüm kayıtlara ulaşmak

Bir veritabanı tablosunun tüm kayıtlarını elde etmek için kullanılır. Ek bir parametreye ihtiyaç duymadan kullanmak mümkündür, ancak bir kerede çok sayıda veri elde etmek, sunucu ve kullanıcı tarafında bir yük oluşturarak proje performansını düşürebilir.

##### Örnek

    $this->print_pre($this->getData('my_table'));



#### column: Tablo sütunlarına ulaşmak

Bir veritabanı tablosundaki belirtilen sütun verilerini elde etmek için kullanılır. Tüm sütun verilerini almadığından, daha hafif bir sorgulamaya izin verir. `column`, özelliğin adını, `title` ve `tag`, sütun adlarını temsil eder.

##### Örnek

    $options = array(
    	'column' => array(
    	      'title',
    	      'tag'
    	)
    );
    $this->print_pre($this->getData('my_table', $options));

veya

    $options = array(
    	'column' => 'title'
    );
    $this->print_pre($this->getData('my_table', $options));



#### limit: Kayıt aralığına ulaşmak

Veritabanındaki kayıtları belirtilen limitlere göre elde etmek için kullanılır. `limit`, özelliğin adını, `start` ve `end` alt özellik adlarını temsil eder. Kayıt aralığını elde etmek için `start` ve `end` belirtilmelidir.

##### Örnek

    $options = array(
    	'limit' => array('start'=>'1', 'end'=>'10')
    );
    $this->print_pre($this->getData('my_table', $options));



#### limit:start Belirtilen miktarda ilk kaydı gözardı etmek

Veritabanı tablosunda bulunan kayıtların ilk eklenenden son eklenene doğru belirtilen sayı kadarının gözardı edilmesi amacıyla kullanılır. `limit` özelliğin adını, `start` gözardı edilecek kayıt miktarını temsil etmektedir.

##### Örnek

    $options = array(
    	'limit' => array('start' => '2')
    );
    $this->print_pre($this->getData('my_table', $options));



#### limit:end Belirtilen miktar kadar kayda ulaşmak

Veritabanı tablosunda, belirtilen sayı kadar kaydı elde etmek amacıyla kullanılır. `limit` özelliğin adını, `end` elde edilmek istenen kayıt miktarını temsil etmektedir.

##### Örnek

    $options = array(
    	'limit' => array('end' => '10')
    );
    $this->print_pre($this->getData('my_table', $options));



#### sort: Kayıtları sıralamak

Veritabanı tablosundaki kayıtları belirtilen sütun içeriğine göre küçükten büyüğe veya büyükten küçüğe doğru sıralamak amacıyla kullanılır. `sort` özelliğin adını, `columnname` sıralamanın yapılacağı sütun adını, `ASC` küçükten büyüğe sıralama talebini, `DESC` ise büyükten küçüğe doğru sıralama talebini temsil etmektedir.

##### Örnek

    $options = array(
    	'sort' => 'columnname:ASC'
    );
    $this->print_pre($this->getData('my_table', $options));

veya

    $options = array(
    	'sort' => 'columnname:DESC'
    );
    $this->print_pre($this->getData('my_table', $options));



#### search: Arama yapmak

Anahtar kelimeleri bir veritabanı tablosunda aramak için kullanılır. Anahtar kelimeler `string` veya `array` olarak gönderilebilir. `search`, özelliğin adını, `keyword` aranan anahtar kelimeleri temsil eder.   

##### Örnek

    $options = array(
    	'search' => array(
    		'keyword' => array(
    			'hello world!',
    			'merhaba dünya'
    		)
    	)
    );
    $this->print_pre($this->getData('my_table', $options));

veya

    $options = array(
    	'search' => array(
    		'keyword' => 'merhaba dünya'
    	)
    );
    $this->print_pre($this->getData('my_table', $options));


#### search: Her yerde aramak

Veritabanı tablosundaki anahtar kelimeleri geniş eşlemeli olarak aramak için kullanılır. Kelimeler `string` veya `array` olarak gönderilebilir. 

Kelime veya kelimeler, `%kelime%` biçiminde belirtilirse cümle içinde geçen `kelime` aranır, eğer belirtilmezse sadece `kelime` değeriyle birebir örtüşen kayıtlar aranır. 

Sonu **kelime**yle biten içeriği aramak için `%kelime`, başı **kelime**yle başlayan içeriği aramak için ise `kelime%`şeklinde bir ifade kullanmak gerekir.

##### Örnek

    $options = array(
    	'search' => array(
    		'keyword' => array(
    			'%hello world!%',
    			'%merhaba dünya'
    		)
    	)
    );
    $this->print_pre($this->getData('my_table', $options));

veya

    $options = array(
    	'search' => array(
    		'keyword' => 'merhaba dünya%'
    	)
    );
    $this->print_pre($this->getData('my_table', $options));


#### search:column Sütunlarda aramak

Bir veritabanı tablosunun belirtilen sütunlarını tam veya genel bir eşleme politikası ile aramak için kullanılır, kelimeler ve sütunlar `string` veya `array` olarak gönderilebilir. `column` özellik adını,`id`, `title`, `content` ve `tag` sütun adlarını temsil eder.

##### Örnek

    $options = array(
        'search' => array(
            'column' => array('id', 'title', 'content', 'tag'),
            'keyword' => array(
                'hello world!',
                'merhaba dünya'
            )
        )
    );
    $this->print_pre($this->getData('my_table', $options));

veya

    $options = array(
    	'search' => array(
    		'column' => 'title',
    		'keyword' => array(
    			'hello world!',
    			'merhaba dünya'
    		)
    	)
    );
    $this->print_pre($this->getData('my_table', $options));


#### search:and Sütuna özel kelime aramak

Kayda ait birden çok sütunda yapılan arama sonuçlarının tümünde bulgu tespit edilmesi halinde, bunların `array` olarak geri döndürülmesini sağlar.

***Bilgi:*** getData:column kısmında sütun tanımlama yapılmışsa bu sütunların içinde aranması istenen sütunlarında olması zorunludur.


##### Örnek

    $params = array(
        'username' => 'admin', 
        'password' => 'root'
    );
    $options = array(
        'search' => array(
            'and' => $params
        )
    );
    $tblname = 'users';
    $this->print_pre($this->getData($tblname, $options));

veya


    $params = array(
        array(
            'username' => 'admin', 
            'password' => 'root'
        ),
        array(
            'username' => 'user', 
            'password' => 'password'
        )
    );
    $options = array(
        'search' => array(
            'and' => $params
        )
    );
    $tblname = 'users';
    $this->print_pre($this->getData($tblname, $options));



#### search:or Sütuna özel kelime aramak

Kayda ait birden çok sütunda yapılan arama sonuçlarının herhangi birinde bulgu tespit edilmesi halinde, bunların `array` olarak geri döndürülmesini sağlar.

##### Örnek

    $params = array(
        'username' => 'admin', 
        'password' => 'root'
    );
    $options = array(
        'search' => array(
            'or' => $params
        )
    );
    $tblname = 'users';
    $this->print_pre($this->getData($tblname, $options));

veya

    $params = array(
        array(
            'username' => 'admin', 
            'password' => 'root'
        ),
        array(
            'username' => 'user', 
            'password' => 'password'
        )
    );
    $options = array(
        'search' => array(
            'or' => $params
        )
    );
    $tblname = 'users';
    $this->print_pre($this->getData($tblname, $options));

***Bilgi:*** getData:column kısmında sütun tanımlama yapılmışsa bu sütunların içinde aranması istenen sütunlarında olması zorunludur.


#### search:delimiter Sütuna özel kelime dizisi ayracı

Sütuna özel kelime aramak için kullanılan `search:and` ve `search:or` yöntemlerinde kullanılması amacıyla tasarlanmış özelliktir.


Örneğin `search:and` alt özelliğine çoklu dizi olarak bir şema gönderildiğini varsayalım, bu şema içinde yer alan her bir dizi kümesinin diğer kardeş kümelerle arasına konulması istenen ifade, delimiter özelliğinde belirtilir.

Örneği daha iyi anlamak için, iki kişi arasındaki yazışmaların elde edilmesi amacıyla yazılması icap eden şemayı inceleyebilirsiniz.


    $params = array(
        array(
            'sender_id' => '3', 
            'reciver_id' => '15'
        ),
        array(
            'sender_id' => '15', 
            'reciver_id' => '3'
        )
    );

    $options = array(
        'search' => array(
            'delimiter'=array(
                'and'=>'OR' //or, OR, and, AND
            ),
            'and' => $params
        )
    );
    $tblname = 'messages';
    $this->print_pre($this->getData($tblname, $options));

#### search:scope Özelleştirilebilen hassasiyet

Aramaların, büyük küçük harf fark duyarlılığı bu alt özellik sayesinde belirlenebilir. Bunu yapabilmek için `string` olarak `like`, `LIKE`, `binary`, `BINARY` olarak belirtilebilir. `LIKE` veya `like` büyük küçük harf duyarlılığı gözetmeden yapılan aramalar için kullanılır, bu yöntem tercih edildiğinde `%` gibi kapsam ifade eden işaretler gönderilebilir. `BINARY` veya `binary` ise büyük küçük harf duyarlılığını gözeterek yapılan aramalar için kullanılır, bu yöntemde `%` gibi kapsam ifadeleri gönderilemez. Varsayılan olarak `BINARY` belirtilmiştir.

****Bilgi:**** Bu özellik `search:and`, `search:or`, `search:delimiter`, `search:keyword` gibi tüm search alt özellikleriyle beraber kullanılabilir.

##### Örnek

    $options = array(
        'search'=>array(
            'scope'=>'LIKE', // like veya LIKE
            'keyword'=>'%ali%'
        )
    );

    $this->print_pre($this->getData('users', $options));

veya 


    $options = array(
        'search'=>array(
            'scope'=>'BINARY', // binary veya BINARY
            'keyword'=>'aliyilmaz'
        )
    );

    $this->print_pre($this->getData('users', $options));



#### format: Sonuçların formatı

Sonuç çıktı formatlarını belirlemek için kullanılır. Şu an için `array` formatı dışında `json` formatını desteklemektedir.

##### Örnek

    $options = array(
    	'format' => 'json'
    );
    $this->print_pre($this->getData('my_table', $options));



#### Özelliklerin bir arada kullanımı

`getData()` özelliklerinin bir çoğu birlikte kullanılabilir, bu tür kullanımlar herhangi bir yük oluşturmadığı gibi yüksek performans gerektiren projeler için hayat kurtarıcı olabilirler.

##### Örnek

    $options = array(
    	'search' => array(
    		'column' => array(
    			'id',
    			'title',
    			'content',
    			'tag'
    		),
    		'keyword' => array(
    			'merhaba',
    			'hello'
    		)
    	),
    	'format' => 'json',
    	'sort' => 'id:ASC',
    	'limit' => array(
    		'start' => '1',
    		'end' => '5'
    	),
    	'column' => array(
    		'id',
    		'title'
    		)
    );
    $this->print_pre($this->getData('my_table', $options));


veya

    $options = array(
    	'search' => array(
    		'and' => array(
    		    'username' => 'aliyilmaz',
    		    'password' => '123456'
    		)
    	),
    	'format' => 'json',
    	'sort' => 'id:ASC',
    	'limit' => array(
    		'start' => '1',
    		'end' => '5'
    	),
    	'column' => array(
    		'username'
    		)
    );
    $this->print_pre($this->getData('users', $options));


veya

    $options = array(
    	'search' => array(
    		'or' => array(
    		    'username' => 'aliyilmaz',
    		    'password' => '123456'
    		)
    	),
    	'format' =>'json',
    	'sort' => 'id:ASC',
    	'limit' => array(
    		'start' => '1',
    		'end' => '5'
    	),
    	'column' => array(
    		'username'
    		)
    );
    $this->print_pre($this->getData('users', $options));

#### Çoklu tablolardan veri elde etmek

    $scheme = array(
        'users','groups'
    );
    $this->print_pre($this->getData($scheme));

veya 

    $scheme = array(
        'users',
        'groups'=>array(
            'column'=>'name'
        )
    );
    $this->print_pre($this->getData($scheme));

veya

    $scheme = array(
        'users'=>array(
            'column'=>array('username', 'password')
        ),
        'groups'=>array(
            'column'=>array('name')
        )
    );

    $this->print_pre($this->getData($scheme));

----------

## samantha()

Spike Jonze imzası taşıyan **Her** filminde bulunan `samantha` karakterinden esinlenerek oluşturulmuştur. Sütun adları ve o sütunlarda bakılması istenen veriler belirtildiğinde, bulunan tüm veriler geri döndürülür. Bu işlem sırasında tüm veri kümelerinin hangi sütunları barındırması gerektiği bilgisi, 3'ncü parametre ile belirlenebilir.

#### 3 parametre alır; 

* İlki tablo adının string biçiminde tanımlanabildiği kısımdır ve belirtilmesi zorunludur.

* İkincisi çoklu şartın bir dizi içinde tanımlanabildiği kısımdır ve belirtilmesi zorunludur.

* Üçüncüsü ise görüntülenmesi istenen sütunların string veya dizi biçiminde tanımlanabildiği kısımdır ve belirtilmesi zorunlu değildir.


##### Örnek

    // Array
    // (
    //     [0] => Array
    //         (
    //             [group_id] => 10
    //         )
    // )
    
    $this->print_pre($this->samantha('permission', array('user_id'=>15), 'group_id'));

veya

    // Array
    // (
    //     [0] => Array
    //         (
    //             [id] => 208
    //             [group_id] => 10
    //         )

    // )
    // $this->print_pre($this->samantha('permission', array('user_id'=>15), array('id', 'group_id')));

veya

    // Array
    // (
    //     [0] => Array
    //         (
    //             [id] => 208
    //             [user_id] => 15
    //             [group_id] => 10
    //             [_token] => 
    //             [status] => 
    //             [created_at] => 
    //             [updated_at] => 
    //         )

    // )

    // $this->print_pre($this->samantha('permission', array('user_id'=>15)));
    
----------


## theodore()

Tıpkı samantha gibi, bu metod da Her filminde hayat bulmuş Theodore Twombly karakterinden esinlenerek oluşturulmuştur. Kesin olarak bir adet olduğu bilinen bir kaydı  bir dizi olarak elde etmek amacıyla kullanılır.

#### 3 parametre alır; 

* İlki tablo adının string biçiminde tanımlanabildiği kısımdır ve belirtilmesi zorunludur.

* İkincisi çoklu şartın bir dizi içinde tanımlanabildiği kısımdır ve belirtilmesi zorunludur.

* Üçüncüsü ise görüntülenmesi istenen sütunların string veya dizi biçiminde tanımlanabildiği kısımdır ve belirtilmesi zorunlu değildir.


##### Örnek

    // Array
    // (
    //     [group_id] => 10
    // )

    $this->print_pre($this->theodore('permission', array('user_id'=>15), 'group_id'));

veya

    // Array
    // (
    //     [id] => 208
    //     [group_id] => 10
    // )

    $this->print_pre($this->theodore('permission', array('user_id'=>15), array('id', 'group_id')));

veya

    // Array
    // (
    //     [id] => 208
    //     [user_id] => 15
    //     [group_id] => 10
    //     [_token] => 
    //     [status] => 
    //     [created_at] => 
    //     [updated_at] => 
    // )

    $this->print_pre($this->theodore('permission', array('user_id'=>15)));


----------

## amelia()

samantha ve theodore metodlarında olduğu gibi amelia da Her filminden esinlenerek oluşturulmuştur. Görevi sadece bir adet olduğu bilinen bir kaydın belirtilen sütun verisini elde etmek, şartları sağlamadığında ise boş bir yanıt döndürmektedir.

#### 3 parametre alır; 

* İlki tablo adının string biçiminde tanımlanabildiği kısımdır ve belirtilmesi zorunludur.

* İkincisi çoklu şartın bir dizi içinde tanımlanabildiği kısımdır ve belirtilmesi zorunludur.

* Üçüncüsü ise görüntülenmesi istenen sütunun string biçimde tanımlanabildiği kısımdır ve belirtilmesi zorunludur.


##### Örnek

    // 208

    $this->print_pre($this->amelia('permission', array('user_id'=>15), 'id'));

----------

## do_have()

Bir veya daha fazla verinin, tam eşleşme prensibiyle veritabanı tablosunda bulunup bulunmadığını kontrol etmek amacıyla kullanılır. 

Bu tür bir kontrolü, aynı üye bilgileriyle tekrar kayıt olunmasını istemediğimiz durumlarda veya Select box'dan gönderilen verilerin gerçekten select box'ın edindiği kaynakla aynılığını kontrol etmemiz gereken durumlarda kullanırız. 

`$tblname` tablo adını, `$str` veriyi, `$column` verinin olup olmadığına bakılan sütunu temsil etmektedir, eğer `$column` değişkeni boş bırakılırsa veri, tablo'nun tüm sütunlarında aranır. `$str` string olarak belirtilebildiği gibi, sütun adını anahtar olarak kullanan bir dizi yapısıyla da belirtilebilir.

Arama sonucunda eşleşen kayıt bulunursa yanıt olarak `true` değeri döndürülür, bulunmazsa da `false` değeri döndürülür.

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

veya

    if($this->do_have('users', array('email'=>'aliyilmaz.work@gmail.com'))){
    	echo 'Bu E-Posta adresi kullanılmaktadır';
    } else {
    	echo 'Bu E-Posta adresi kullanılmamaktadır.';
    }


----------

## getId()

Bir veritabanı tablosunda belirtilen koşulları sağlayan ve sadece bir adet bulunan kaydın `auto_increment` özelliği tanımlanmış sütununda bulunan değeri göstermeye yarar. `$tblname` tablo adını, `$needle` koşulları temsil etmektedir.

##### Örnek

    $needle = array(
        'username'=>'burcu',
        'password'=>md5(123123)
    );

    echo $this->getId('users', $needle);


**Bilgi:** `insert` metodunun `boolean` türünde bir yanıt döndürüyor olması, `amelia` metodunun `auto_increment` özelliği tanımlanmış sütunu kendiliğinden hedeflememesi ve daha anlamlı isme sahip `id` temin edici bir metot ihtiyacı bu metodun oluşmasını sağlamıştır.

----------

## newId()

Bir veritabanı tablosuna eklenmesi planlanan kayda tahsis edilecek `auto_increment` değerini göstermeye yarar. `$tblname` tablo adını temsil etmektedir.

##### Örnek
    $tblname  = 'users';
    echo $this->newId($tblname);

----------

## increments()

Veritabanı tablosunda ki `auto_increment` görevine sahip sütun adını göstermek amacıyla kullanılır. `$tblname` veritabanı tablo adını temsil etmektedir.

##### Örnek

    $tblname = 'users';
    echo $this->increments($tblname);

----------

## tableInterpriter()

Mind ile oluşturulmuş veritabanı tablosunu, Mind'ın veritabanı tablosu oluşturma şemasına dönüştüren yorumlayıcı bir metotdur. Veritabanı tablo adı `string` bir yapıda belirtilmelidir. Söz konusu tablo oluşturucu şema, dizi yapısında geri döndürülür. Bu metod'a ihtiyaç duyulmasının nedeni, veritabanı tablolarının yeniden oluşturulması gerekebileceği ihtiyacıdır.

****Not:**** Eğer veritabanı tablosu yoksa veya tablo boş ise, boş bir dizi yanıt olarak geri döndürülür.


##### Örnek

    // Array
    // (
    //     [0] => id:increments:11
    //     [1] => username:string:255
    //     [2] => password:string:255
    //     [3] => description:medium
    //     [4] => address:large
    //     [5] => amount:decimal:10,0
    //     [6] => age:int:11
    // )

    $this->print_pre($this->tableInterpriter('users'));

----------

## backup()

Bir veya daha fazla veritabanını yedeklemek için kullanılır. İki parametre alır, ilki veritabanı isimlerini temsil eder ve belirtilmesi zorunludur, bu isimler `string` ve `array` biçiminde gönderilebilir, ikinci parametre ise yedeğin konumlanması istenen dizin yolunu temsil eder ve zorunlu değildir, bu yol `string` olarak belirtilmelidir. 

Yedek `JSON` yapısındadır, tarayıcı üzerinden bilgisayara kaydedilmek istenirse, ikinci parametre gönderilmez.

##### Örnek

    $this->backup('mydb');

veya 

    $this->backup(array('mydb', 'trek'));

veya

    $this->backup('mydb', 'restore/');

veya

    $this->backup(array('mydb', 'trek'), './');

----------

## restore()

Bir veya daha fazla veritabanını yedeğini geri yüklemek için kullanılır. `JSON` dosyalarına ait `string` veya `array` yapısındaki yolları temsil eden bir parametre alır ve zorunludur.

##### Örnek

    
    $this->restore('backup_2020_11_06_17_40_21.json');
    
veya

    $this->restore(array('backup_2020_11_06_17_40_21.json', 'backup_2020_11_06_17_41_22.json'));


## pagination()

Veritabanı tablosunda bulunan verileri sayfalamak amacıyla kullanılır. 

#### prefix

Sayfa ön eki'ni temsil etmekte olup zorunlu değildir, varsayılan olarak `p` belirtilmiştir. 

###### Rotasız url yapısında kullanımı

`pagination.php`  adında bir dosya olduğunu varsayalım, bu dosyanın tam yoluna ön eki dahil ederek şu şekilde `pagination.php?p` veya şu şekilde `pagination.php?p=1` kullanarak ilk sayfa verilerini görüntülemiş oluruz.


###### Rotalı url yapısında kullanımı

Parametreli rota gerektiren bu kullanım şekli, rotaların tanımlandığı dosyada rota `users:p` olarak tanımlandığında adres satırına `users` veya şekilde `users/1` yazılırsa ilk sayfa verilerini görüntülemiş oluruz.


#### limit 

Her sayfada görüntülenmesi istenen kayıt adedini temsil etmekte olup zorunlu değildir, varsayılan olarak `5` adet belirtilmiştir. 

#### search, column, format, sort

Bu kurallar hakkında daha fazla bilgi edinmek için, doğrudan [getData](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#getData) metoduna göz atabilirsiniz.


#### Geriye dönen değerlerin kullanım amaçları

`data` anahtarı yardımıyla elde edilen verilere ulaşılır, `prefix` anahtarı yardımıyla adres ön ekine ulaşılır, `limit` anahtarıyla kaç adet verinin elde edildiği bilgisine ulaşılır, `totalPage` anahtarı yardımıyla toplam sayfa sayısına ulaşılır ve `page` anahtarı yardımıyla hangi sayfada olduğu bilgisine ulaşılır.

##### Örnek

    $data = $this->pagination('messages');

    $this->print_pre($data['data']);

    echo "\n";

    $prefix = $data['prefix'];
    for ($i=1; $i <= $data['totalPage']; $i++) { 

        echo "\n<a ";

        if($i == $this->post[$prefix] OR empty($this->post[$prefix])){ 
            echo 'class="pageSelected" ';
        }
        echo 'href="'.$this->base_url.'pagination.php?'.$prefix.'='.$i.'">'.$i.'</a>';
    }

    echo "\n\n";

veya


    $options = array(
        'prefix'=>'page', // Default p
        'search'=>array(
            'scope'=>'like',
            'keyword'=>'%a%',
            'column'=>'text',
            'delimiter'=>array(
                'or'=>'AND'
            ),
            'or'=>array(
                array(
                    'sender_id'=>1,
                    'reciver_id'=>1
                ),
                array(
                    'sender_id'=>3,
                    'reciver_id'=>3
                )
            )
        ),
        'column'=>array('sender_id','reciver_id','text'), // array / string
        'limit'=>2, // Default 5
        'format'=>'json', // json 
        'sort'=>'id:asc' // asc / ASC / desc / DESC
    );
    $data = $this->pagination('messages', $options);

    $this->print_pre($data['data']);

    echo "\n";

    $prefix = $data['prefix'];
    for ($i=1; $i <= $data['totalPage']; $i++) { 

        echo "\n<a ";

        if($i == $this->post[$prefix] OR empty($this->post[$prefix])){ 
            echo 'class="pageSelected" ';
        }
        echo 'href="'.$this->base_url.'pagination.php?'.$prefix.'='.$i.'">'.$i.'</a>';
    }

    echo "\n\n";


----------

## translate()

Bu fonksiyon, veritabanı altyapısına dayanan çoklu çeviri desteğini sağlamayı amaçlar. Kullanıma hazır hale gelmesi için veritabanı tablosunun oluşturulması ve Mind'a tanımlanması gerekir. 

### Veritabanı tablosunun tasarlanması

    $scheme = array(
        'id:increments',
        'name:small',
        'text:small',
        'lang:small',
        'user_id:small',
        '_token:small',
        'status:string',
        'created_at:string',
        'updated_at:string'
    );

### Veritabanı tablosunun ve içeriğinin oluşturulması

    if($this->tableCreate('translations', $scheme)){
        $data = array(
                array(
                    "name" => "dashboard",
                    "text" => "Dashboard",
                    "lang" => "GB",
                    "user_id" => 1,
                    "_token" => $this->generateToken(),
                    "status" => 1,
                    "created_at" => $this->timestamp
                ),
                array(
                    "name" => "profile-signout",
                    "text" => "Sign out",
                    "lang" => "GB",
                    "user_id" => 1,
                    "_token" => $this->generateToken(),
                    "status" => 1,
                    "created_at" => $this->timestamp
                ),
                array(
                    "name" => "dashboard",
                    "text" => "Başlangıç",
                    "lang" => "TR",
                    "user_id" => 1,
                    "_token" => $this->generateToken(),
                    "status" => 1,
                    "created_at" => $this->timestamp
                ),
                array(
                    "name" => "profile-signout",
                    "text" => "Oturumu kapat",
                    "lang" => "TR",
                    "user_id" => 1,
                    "_token" => $this->generateToken(),
                    "status" => 1,
                    "created_at" => $this->timestamp
                )
            );
            
        $this->insert('translations', $data);
    }

### Çeviri kullanımı

İki parametre alan `translate()` metodunun ilk parametresi, çevirisi istenen kaydın anahtarının belirtildiği kısımdır, ikinci parametresi ise Mind içinde bulunan languages() metodundaki kısaltmalardan birinin belirtildiği kısımdır. İkinci parametrenin belirtilme zorunluluğu yoktur, eğer belirtilmez ise varsayılan olarak tanımlanan Dil kısaltmasının çevirisini geri döndürür.

    echo $this->translate('dashboard'); // Varsayılan olarak TR belirtildiği için Başlangıç geri döndürülür.
    echo '<br />';
    echo $this->translate('dashboard', 'TR'); // Başlangıç
    echo '<br />';
    echo $this->translate('dashboard', 'GB'); // Dashboard

### Çeviri ayarlarının Mind'a tanımlanması

`table` tablo adını, `column` dil kısaltmalarının tutulduğu sütun adını, `haystack` çevirisi istenen kaydın benzersiz isminin tutulduğu sütun adını, `return` geri döndürülmesi istenen verinin sütun adını ve `lang` varsayılan dilin kısaltmasının tutulduğu sütun adını temsil eder.

Varsayılan olarak aşağıdaki tanımlamalar yapılmıştır, eğer bu dökümanda belirtilen kullanım yönergesinden başka isimlendirmeler belirlemeyi düşünürseniz aşağıdaki kısmı Mind'ı çağırırken ya da Mind.php dosyası içinden güncellemeniz yeterlidir.

    $conf = array(
        'translate'=>array(
            'table'                 =>  'translations',
            'column'                =>  'lang',
            'haystack'              =>  'name',
            'return'                =>  'text',
            'lang'                  =>  'TR'
        )
    );

    $Mind = new Mind($conf);


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

Bu fonksiyon kendisiyle paylaşılan tarih biçiminin gerçek olup olmadığını kontrol etmek amacıyla kullanılır, tarih ve format `string` olarak gönderilebilir. `$date` ve `01.02.1987` tarihi, `$format` ve `d.m.Y` tarihin hangi formatta kontrol edilmesi gerektiği bilgisini temsil etmektedir. Format parametresinin belirtilmesi isteğe bağlıdır, belirtilmediğinde tarih formatının varsayılan olarak `Y-m-d H:i:s` olduğu varsayılır. Eğer tarih geçerliyse yanıt olarak `true` değeri döndürülür, geçerli değilse `false` değeri döndürülür.
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

Bu fonksiyon özellikle dosya yükleme işlemleri sırasında yüklenmek istenen dosyanın formatını kontrol etmek amacıyla kullanılır, Dosya adı `string` olarak belirtilmelidir, Dosya uzantıları ise `string` veya `array` olarak belirtilebilir. `$this->post['photo']['name']` dosya adını, `$list` müsaade edilen dosya uzantılarını temsil etmektedir. Eğer dosya müsaade edilen uzantıya sahip ise yanıt olarak `true` değeri döndürülür, değilse `false` değeri döndürülür.
##### Örnek

    $list = 'jpg';
    if($this->is_type($this->post['photo']['name'], $list)){
    	echo 'Yüklemek istediğiniz dosya müsaade edilen bir uzantıya sahiptir.';
    } else {
    	echo 'Yüklemek istediğiniz dosya müsaade edilen bir uzantıya sahip değildir.';
    }

veya

    $list = array('jpg', 'jpeg', 'png', 'gif');
    if($this->is_type($this->post['photo']['name'], $list)){
    	echo 'Yüklemek istediğiniz dosya müsaade edilen bir uzantıya sahiptir.';
    } else {
    	echo 'Yüklemek istediğiniz dosya müsaade edilen bir uzantıya sahip değildir.';
    }

----------

## is_size()

Bu fonksiyon, dosya dizisinde bulunan `size` değerinin ya da `string` veya `integer` yapısında belirtilen `byte` cinsinden değerin kontrol edilmesi amacıyla kullanılır. İlk parametre kontrol edilmesi istenen boyut bilgisini, ikici parametre ise kontrol edilmesi istenen boyutu temsil etmektedir. Eğer dosya veya belirtilen değer müsaade edilen boyutun altında veya eşitse yanıt olarak `true` değeri döndürülür, değilse `false` değeri döndürülür. Daha iyi anlamak için aşağıdaki örnekleri inceleyebilirsiniz.
 
 **Bilgi:** Dosyalarla çalışırken `php.ini` ayarlarında bulunan `upload_max_filesize` parametresine en az `$size` değişkeninde belirtilen miktar kadar boyutun belirtilmesi gereklidir. 

##### Örnek

    $second_size = '35 KB';
    $this->post['photo'] = array(
        'size'=>35840
    );
    if($this->is_size($this->post['photo'], $second_size)){
        echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }

veya

    $this->post['photo'] = array(
        'size'=>36700160
    );
    if($this->is_size($this->post['photo'], '35 MB')){
        echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }

veya

    $this->post['photo'] = array(
        'size'=>37580963840
    );
    if($this->is_size($this->post['photo'], '35 GB')){
        echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }

veya

    $this->post['photo'] = array(
        'size'=>1099511627776
    );
    if($this->is_size($this->post['photo'], '1 TB')){
        echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }

veya

    $this->post['photo'] = array(
        'size'=>1125899906842624
    );
    if($this->is_size($this->post['photo'], '1 PB')){
        echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }

veya

    $second_size = 35839;
    $first_size = 35839;
    if($this->is_size($first_size, $second_size)){
        echo 'Değer belirtilen boyuttan küçüktür';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }

veya

    $second_size = '35 KB';
    $first_size = '35840';
    if($this->is_size($first_size, $second_size)){
        echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }

veya

    $second_size = '1024 KB';
    $first_size = '1023 KB';
    if($this->is_size($first_size, $second_size)){
        echo 'ilk boyut belirtilen ikinci boyuttan küçük veya eşittir.';
    } else {
        echo 'ilk boyut belirtilen ikinci boyuttan büyüktür.';
    }


----------

## is_color()

Bu fonksiyon kendisiyle paylaşılan değerin geçerli bir renk olup olmadığını kontrol etmeye yarar, eğer söz konusu değer transparent veya tüm tarayıcılar ile uyumlu olan 148 renk isminden biriyse ya da HEX, RGB, RGBA, HSL, HSLA ise yanıt olarak `true` değeri döndürülür, değilse `false` değeri döndürülür. `$color` renk değerini temsil etmektedir.

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

##### HSL

      $color = 'hsl(10,30%,40%)';
      if($this->is_color($color)){
        echo 'Geçerli bir renk parametresidir.';
      } else {
        echo 'Geçerli bir renk parametresi değildir.';
      }

##### HSLA

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

    $str = 'http://localhost';
    if($this->is_url($str)){
        echo 'Bu bir bağlantıdır.';
    } else {
        echo 'Bu bir bağlantı değildir.';
    }
    }

veya

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


## is_http()

Kendisiyle paylaşılan `string` yapıdaki verinin HTTP söz diziminde yazılıp yazılmadığını kontrol etmek amacıyla kullanılır, Eğer söz konusu veri bir HTTP söz dizimine sahip ise `true` değeri döndürülür, değilse `false` değeri döndürülür.

##### Örnek

    $url = 'http://www.google.com/';
    if($this->is_http($url)){
        echo 'Bu bir HTTP bağlantısıdır.';
    } else {
        echo 'Bu bir HTTP bağlantısı değildir.';
    }

----------


## is_https()

Kendisiyle paylaşılan `string` yapıdaki verinin HTTPS sözdiziminde yazılıp yazılmadığını kontrol etmek amacıyla kullanılır, Eğer söz konusu veri bir HTTPS sözdizimine sahip ise `true` değeri döndürülür, değilse `false` değeri döndürülür.

##### Örnek

    $url = 'http://www.google.com/';
    if($this->is_http($url)){
        echo 'Bu bir HTTP bağlantısıdır.';
    } else {
        echo 'Bu bir HTTP bağlantısı değildir.';
    }

    
----------

## is_json()

Kendisiyle paylaşılan `string` türde ki verinin json formatında olup olmadığını kontrol etmek amacıyla kullanılır, `$schema` json verisini temsil etmektedir. Eğer söz konusu veri bir json sözdizimine sahip ise `true` değeri döndürülür, değilse `false` değeri döndürülür.

##### Örnek

    $schema = array(
        'test'=>'ali'
    );
    
    if($this->is_json(json_encode($schema))){
        echo 'Bu bir json sözdizimidir.';
    } else {
        echo 'Bu bir json sözdizimi değildir.';
    }

    
        
----------

## is_age()

Yaş sınırlamasına ihtiyaç duyulan yerlerde kullanılır. Kendisiyle paylaşılan doğum tarihini mevcut tarihten çıkarır, elde edilen sonuç eğer belirtilen yaş ile aynı veya o yaştan büyük ise `true` yanıtı döndürülür, değilse `false` yanıtı döndürülür.

##### Örnek

    echo '<br>';
    if($this->is_age('1987-03-17', 35)){
        echo 'Age is appropriate.';
    } else {
        echo 'Age is not appropriate.';
    }
    
veya

    echo '<br>';
    if($this->is_age('1987-03-17', 32)){
        echo 'Yaş uygundur.';
    } else {
        echo 'Yaş uygun değildir.';
    }

veya

    echo '<br>';
    if($this->is_age('1987-03-17', 35)){
        echo 'Yaş uygundur.';
    } else {
        echo 'Yaş uygun değildir.';
    }
    
        
----------
    
## is_iban()

Kendisiyle paylaşılan değerin geçerli bir IBAN numarası olup olmadığını kontrol etmek amacıyla kullanılır. Eğer değer bir IBAN numarası söz dizimine sahipse `true` yanıtı döndürülür, değilse `false` yanıtı döndürülür.

##### Örnek

    if($this->is_iban('SE35 500 0000 0549 1000 0003')){
        echo 'Bu bir IBAN numarasıdır.';
    } else {
        echo 'Bu bir IBAN numarası değildir.';
    }


----------

## is_ipv4()

Kendisiyle paylaşılan değerin `ipv4` söz diziminde olup olmadığını kontrol etmek için kullanılır. Eğer değer `ipv4` söz diziminde ise true yanıtı döndürülür, değilse `false` yanıtı döndürülür.

##### Örnek

    echo '<br>';
    if($this->is_ipv4('208.111.171.236')){
        echo 'Bu bir ipv4 adresdir.';
    } else {
        echo 'Bu bir ipv4 adres değildir.';
    }
        
veya 


    echo'<br>';
    if($this->is_ipv4('256.111.171.236')){
        echo 'Bu bir ipv4 adresdir.';
    } else {
        echo 'Bu bir ipv4 adres değildir.';
    }


----------


## is_ipv6()

Kendisiyle paylaşılan değerin `ipv6` söz diziminde olup olmadığını kontrol etmek için kullanılır. Eğer değer `ipv6` söz diziminde ise true yanıtı döndürülür, değilse `false` yanıtı döndürülür.

##### Örnek

    echo '<br>';
    if($this->is_ipv6('2001:0db8:85a3:08d3:1319:8a2e:0370:7334')){
        echo 'Bu bir ipv6 adresdir.';
    } else {
        echo 'Bu bir ipv6 adres değildir.';
    }
        
veya 


    echo'<br>';
    if($this->is_ipv6('2001:0db8:85a3:08d3:1319:8a2e:0370:7334dsdsd')){
        echo 'Bu bir ipv6 adresdir.';
    } else {
        echo 'Bu bir ipv6 adres değildir.';
    }


----------


## is_blood()

Kendisiyle paylaşılan değerin bir kan grubu olup olmadığını kontrol etmek için kullanıldığı gibi bir  kan grubunun başka bir kan grubu için uygun donör olup olmadığını kontrol etmek amacıyla da kullanılır. 

İki parametre alır, ilk parametre zorunludur, İkinci parametre zorunlu değildir. Sadece ilk parametre belirtilirse o kan grubunun geçerliliği kontrol edilir. İkinci parametre de belirtilirse, ikincisinin ilk kan grubu için uygun donör olup olmadığı kontrol edilir.

Eğer geçerli bir kan grubu belirtilmiş ise ya da uyumlu kan grupları belirtilmiş ise `true` yanıtı döndürülür, aksi halde `false` yanıtı döndürülür.

##### Örnek


    echo '<br>';
    
    if($this->is_blood('0+')){
        echo 'Evet, bu bir kan grubudur.';
    } else {
        echo 'Hayır, bu bir kan grubu değildir.';
    }
    
veya

        echo '<br>';
        
        if($this->is_blood('0+', '0+')){
            echo 'Evet, bu uyumlu bir kan grubudur.';
        } else {
            echo 'Hayır, bu uyumsuz bir kan grubudur.';
        }


----------


## is_latitude()

Kendisiyle paylaşılan `float`, `int` ya da `string` yapıdaki verinin geçerli bir enlem bilgisi olup olmadığını kontrol etmek amacıyla kullanılır. Eğer kendisiyle paylaşılan veri geçerli bir enlem bilgisiyse `true` yanıtı döndürülür, değilse `false` yanıtı döndürülür.

##### Örnek

    $latitude = 41.008610;
    if($this->is_latitude($latitude)){
        echo 'Geçerli enlem.';
    } else {
        echo 'Geçersiz enlem.';
    }


----------


## is_longitude()

Kendisiyle paylaşılan  `float`, `int` ya da `string` yapıdaki verinin geçerli bir boylam bilgisi olup olmadığını kontrol etmek amacıyla kullanılır. Eğer kendisiyle paylaşılan veri geçerli bir boylam bilgisiyse `true` yanıtı döndürülür, değilse `false` yanıtı döndürülür.

    $longitude = 28.971111;
    if($this->is_longitude($longitude)){
        echo 'Geçerli boylam.';
    } else {
        echo 'Geçersiz boylam.';
    }


----------


## is_coordinate()

Kendisiyle paylaşılan koordinatın geçerliliğini kontrol etmek amacıyla kullanılır.  `float`, `int` ya da `string` yapıda iki parametre alır, bunlar enlem ve boylam bilgisidir ve her ikisinin belirtilmesi zorunludur.

##### Örnek

    $point1 = array(
        'lat' => 41.008610, 
        'long' => 28.971111
    );
        
    if($this->is_coordinate($point1['lat'], $point1['long'])){
        echo 'Geçerli koordinat.';
    } else {
        echo 'Geçersiz koordinat.';
    }
    
veya

    $point2 = array(
        'lat' => 39.925018, 
        'long' => 32.836956
    );
          
    if($this->is_coordinate($point2['lat'], $point2['long'])){
        echo 'Geçerli koordinat.';
    } else {
        echo 'Geçersiz koordinat.';
    }


----------


## is_distance()

Bir koordinat noktası için, başka bir koordinat noktasının belirtilen menzil içinde kalıp kalmadığını sorgulamak amacıyla kullanılır.

3 parametre alır, ilk iki parametre iki farklı koordinat noktasını, 3'ncüsü ise menzil ve mesafe ölçü birimini temsil eder. 

3'ncü parametre iki nokta üst üste `:` işareti ile ikiye ayrılır, ilki menzil ikincisi mesafe ölçü birimini temsil eder. (örneğin: `300:m` )

ilk iki parametrede bulunan koordinat verileri `array` olarak, menzil ve menzil ölçü birimini temsil eden 3'ncü parametre ise `string` olarak belirtilmelidir.

`array` olarak belirtilen koordinat bilgisi `enlem,boylam` söz diziminde, `float`, `string` ya da `int` türünde belirtilmelidir.

Eğer menzil içinde bir mesafe söz konusuysa `true` yanıtı döndürülür, değilse `false` yanıtı döndürülür.

**Bilgi:**

Ölçü birimleri ve kısaltmaları aşağıdaki gibidir.

* m (Metre)
* km (Kilometre)
* mi (Mil)
* ft (Feet)
* yd (Yard)

##### KOORDİNATLAR

    $point1 = array(41.008610,28.971111); 
    $point2 = array(39.925018,32.836956); 
    
##### Örnek

    if($this->is_distance($point1, $point2, '349:km')){
        echo 'Menzil içindedir.';
    } else {
        echo 'Menzil içinde değildir.';
    }

veya

    if($this->is_distance($point1, $point2, '347:km')){
        echo 'Menzil içindedir.';
    } else {
        echo 'Menzil içinde değildir.';
    }


----------

## is_md5()

Kendisiyle paylaşılan verinin kriptografik özet söz diziminde olup olmadığını kontrol etmek amacıyla kullanılır. Söz konusu veri string olarak belirtilmelidir. Eğer veri bir md5 ise `true` değilse `false` yanıtı geri döndürülür.

##### Örnek

    $str = '123456';

    if($this->is_md5($str)){
        echo 'Bu bir md5.';
    } else {
        echo 'Bu bir md5 değil.';
    }

veya

    $str = md5('123456');

    if($this->is_md5($str)){
        echo 'Bu bir md5.';
    } else {
        echo 'Bu bir md5 değil.';
    }

----------

## is_ssl()

Bu fonksiyon, projeye ait SSL Sertifikasının varlığını sorgulamak amacıyla kullanılır. Eğer SSL bağlantısı etkinse `true` değilse `false` yanıtı döndürülür.

##### Örnek


    if($this->is_ssl($str)){
        echo 'SSL bağlantısı var.';
    } else {
        echo 'SSL bağlantısı yok.';
    }


----------

## is_htmlspecialchars()

Bu fonksiyon kendisiyle paylaşılan verinin HTML özel karakterleri içerip içermediğini kontrol etmeye yarar. Veri `string` türünde belirtilmelidir. Eğer HTML özel karakterleri içeriyorsa `true` değilse `false` yanıtı döndürülür.

##### Örnek

    $code = 'merhaba &lt;?=$this-&gt;timestamp;?&gt;';

    if($this->is_htmlspecialchars($code)){
        echo 'HTML özel karakterleri içeriyor.';
    } else {
        echo 'HTML özel karakterleri içermiyor.';
    }

----------


## validate()

Farklı türdeki verilerin belirtilen kurallara uygunluğunu tek seferde kontrol etmek amacıyla kullanılır. Kuralları ihlal eden veriler varsa ve hata mesajı belirtilmişse `$this->errors` dizi değişkenine hata mesajları tanımlanır, hata mesajı belirtilmemişse verilerin dizi anahtarları `$this->errors` dizi değişkenine tanımlanır ve `false` yanıtı döndürülür. Herhangi bir kural ihlali yok ise `true` yanıtı döndürülür. 

İstisnai olarak, özel veri tipine ihtiyaç duyan kurallarda uygunsuz veri tipi tespit edilmesi halinde, bir hata mesajı belirtilip belirtilmediğine bakılmaksızın bu durumu ifade eden bir hata mesajı `$this->errors` dizi değişkenine tanımlanarak `false` yanıtı döndürülür.    

Her anahtar adına birden çok kural tanımlamak için kurallar `|` sembolü yardımıyla ayrılmalıdır. Parametrelerde bulunan veri anahtarlarının eşleşmesi gerekmektedir.

##### Örnek


    //  Veri
    $data = array(
        'username'          =>  'aliyilmaz',
        'title'             =>  'Merhaba dünya1',
        'email'             =>  'aliyilmaz.work@gmail.com',
        'phone_number'      =>  '05554248988',
        'background_color'  =>  '#ffffff',
        'webpage'           =>  'http://google.com',
        'https_webpage'     =>  'https://google.com',
        'http_webpage'      =>  'http://google.com',
        'json_data'         =>  '{ "name":"John", "age":30, "car":null }',
        'content'           =>  'merhaba',
        'summary'           =>  'merhab',
        'quentity'          =>  '4',
        'numeric_str'       =>  12,
        'birthday'          =>  '1987-02-14',
        'register_date'     =>  '2020-02-18 14:34:22',
        'status'            =>  1,
        'ibanNumber'        =>  'SE35 5000 0000 0549 1000 0003',
        'ipv4Address'       =>  '127.0.0.1',
        'ipv6Address'       =>  '2001:0db8:85a3:08d3:1319:8a2e:0370:7334',
        'bloodGroup'        =>  '0+',
        'coordinates'       =>  '41.008610,28.971111',
        'distances'         =>  '41.008610,28.971111@39.925018,32.836956',
        'language'          =>  'TR'


    );

    // Kural
    $rule = array(
        'username'          =>  'available:users',
        // 'username'          =>  'knownunique:users:username:aliyilmaz'
        // 'username'          =>  'knownunique:users:aliyilmaz'
        'title'             =>  'required|unique:posts',
        'email'             =>  'email|unique:users',
        'phone_number'      =>  'phone',
        'background_color'  =>  'color',
        'webpage'           =>  'url',
        'https_webpage'     =>  'https',
        'http_webpage'      =>  'http',
        'json_data'         =>  'json',
        'content'           =>  'max-char:7',
        'summary'           =>  'min-char:6|max-char:10',
        'quentity'          =>  'min-num:2|max-num:4',
        'numeric_str'       =>  'numeric',
        'birthday'          =>  'min-age:33|max-age:40',
        'register_date'     =>  'date:Y-m-d H:i:s',
        'status'            =>  'bool:true',
        'ibanNumber'        =>  'iban',
        'ipv4Address'       =>  'ipv4',
        'ipv6Address'       =>  'ipv6',
        'bloodGroup'        =>  'blood:0+',
        'coordinates'       =>  'required|coordinate',
        'distances'         =>  'distance:349 km',
        'language'          =>  'languages'
    );


    // Mesaj
    $message = array(
        'username'=>array(
            'available'=>'Bu kullanıcı adı bulunmamaktadır'
        ),
        'title'=>  array(
            'required'=>'Boş bırakılmamalıdır.',
            'unique'=>'Benzersiz bir kayıt belirtilmelidir.'
        ),
        'email'=>array(
            'email'=>'Geçerli bir e-mail adresi belirtilmelidir.',
            'unique'=>'Benzersiz bir kayıt belirtilmelidir.'
        ),
        'phone_number'=>array(
            'phone'=>'Geçerli bir telefon numarası belirtilmelidir.'
        ),
        'background_color'=>array(
            'color'=>'Geçerli bir renk belirtilmelidir.'
        ),
        'webpage'=>array(
            'url'=>'Geçerli bir URL belirtilmelidir.'
        ),
        'https_webpage'=>array(
            'https'=>'Geçerli bir https adresi belirtilmelidir.'
        ),
        'http_webpage'=>array(
            'http'=>'Geçerli bir http adresi belirtilmelidir.'
        ),
        'json_data'=>array(
            'json'=>'Geçerli bir json verisi belirtilmelidir.'
        ),
        'content'=>array(
            'max-char'=>'Maksimum karakter limiti aşılmamalıdır.'
        ),
        'summary'=>array(
            'min-char'=>'Minumum karakter limiti belirtilmelidir.',
            'max-char'=>'Maksimum karakter limiti aşılmamalıdır.'
        ),
        'quentity'=>array(
            'min-num'=>'Minumum sayı belirtilmelidir.',
            'max-num'=>'Maksimum sayı aşılmamalıdır.'
        ),
        'numeric_str'=>array(
            'numeric'=>'Numerik karakter belirtilmelidir.'
        ),
        'birthday'=>array(
            'min-age'=>'Minumum yaştan küçük bir yaş belirtilmelidir.',
            'max-age'=>'Maksimum yaştan büyük bir yaş belirtilmelidir.'
        ),
        'register_date'=>array(
            'date'=>'Yıl-Ay-Gün biçiminde tarih belirtilmelidir.'
        ),
        'status'=>array(
            'bool'=>'Doğrulama başarısız.'
        ),
        'ibanNumber'=>array(
            'iban'=>'IBAN hesabı doğrulanamadı.'
        ),
        'ipv4Address'=>array(
            'ipv4'=>'ipv4 söz diziminde bir IP adresi belirtilmelidir.'
        ),
        'ipv6Address'=>array(
            'ipv6'=>'ipv6 söz diziminde bir IP adresi belirtilmelidir.'
        ),
        'bloodGroup'=>array(
            'blood'=>'Talimatlara göre kan grubu belirtilmelidir.'
        ),
        'coordinates'=>array(
            'coordinate'=>'Geçerli bir koordinat belirtilmelidir.'
        ),
        'distances'=>array(
            'distance'=>'Menzil içinde bulunan koordinat noktası belirtilmelidir.'
        ),
        'language'=>array(
            'languages'=>'Dil seçimi yapılmalıdır.'
        )


    );

    if($this->validate($rule, $data, $message)){
        echo 'Her şey yolunda!';
    } else {
        $this->print_pre($this->errors);

    }




#### Kurallar

##### min-num

Minumum belirtilmesi arzu edilen sayı miktarını ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duyar ve bu parametre integer bir değer olmak zorundadır, bu değerin tırnak işaretleri arasında ya da olduğu gibi yazılması bu kuralın doğru çalışmasını engellemez.

    min-num:5

##### max-num

Maksimum belirtilmesi arzu edilen sayı miktarını ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duyar ve bu parametre integer bir değer olmak zorundadır, bu değerin tırnak işaretleri arasında ya da olduğu gibi yazılması bu kuralın doğru çalışmasını engellemez.

    max-num:10

##### min-char

Verinin karakter uzunluğunun minumum belirtilen sayı kadar olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duyar ve bu parametre integer bir değer olmak zorundadır, bu değerin tırnak işaretleri arasında ya da olduğu gibi yazılması bu kuralın doğru çalışmasını engellemez.

    min-char:200

##### max-char

Verinin karakter uzunluğunun maksimum belirtilen sayı kadar olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duyar ve bu parametre integer bir değer olmak zorundadır, bu değerin tırnak işaretleri arasında ya da olduğu gibi yazılması bu kuralın doğru çalışmasını engellemez.

    max-char:500

##### email

Verinin bir e-email adresi olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `email` yazarak kullanılabilir.

    email

##### required

Veri belirtilmenin zorunlu olduğunu ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `required` yazarak kullanılabilir.

    required
    
##### phone

Verinin bir telefon numarası olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `phone` yazarak kullanılabilir.
 
    phone

##### date 

Verinin geçerli bir zaman bilgisi olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametre belirtilmeden kullanıldığında `Y-m-d` biçimini referans alarak veriyi kontrol eder, eğer zaman bilgisinin belirtilen formatta kontrol edilmesi arzu edilirse, kabul edilebilir zaman formatı belirtilmelidir.

    // 2020-02-18
    date:Y-m-d  

veya

    // 2020-02-18 14
    date:Y-m-d H 
veya

    // 2020-02-18 14:34
    date:Y-m-d H:i 

veya

    // 2020-02-18 14:34:22
    date:Y-m-d H:i:s 

gibi.

##### json

Veri formatının JSON söz diziminde olduğunu ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `json` yazarak kullanılabilir.

    json

##### color

Belirtilen değerin HEX, RGB, RGBA, HSL, HSLA veya 148 güvenli renkten biri olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `color` yazarak kullanılabilir.

    color

##### url

Belirtilen parametrenin geçerli bir bağlantı olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `url` yazarak kullanılabilir.

    url
    

##### https

Belirtilen parametrenin SSL bağlantısı olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `https` yazarak kullanılabilir.

    https

##### http

Belirtilen parametrenin HTTP bağlantısı olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `http` yazarak kullanılabilir.

    http

##### numeric

Belirtilen verinin rakam olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `numeric` yazarak kullanılabilir.

    numeric

##### min-age

Belirtilen doğum tarihine sahip kimsenin yine belirtilen yaş ya da üstü bir yaşta olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duyar ve bu parametre integer bir değer olmak zorundadır, bu değerin tırnak işaretleri arasında ya da olduğu gibi yazılması bu kuralın doğru çalışmasını engellemez.

    min-age:18

##### max-age

Belirtilen doğum tarihine sahip kimsenin yine belirtilen yaş ya da altında bir yaşta olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duyar ve bu parametre integer bir değer olmak zorundadır, bu değerin tırnak işaretleri arasında ya da olduğu gibi yazılması bu kuralın doğru çalışmasını engellemez.

    max-age:18

##### unique

Veritabanı tablosunda olmayan bir verinin belirtilmesi gerektiğini ifade eder. 



    unique:users

veya


    unique:posts

##### available

Veritabanı tablosunda olan bir verinin belirtilmesi gerektiğini ifade eder. 



    available:users

veya


    available:products


##### knownunique

Belirtilen parametrenin, veritabanı tablosunda olan bir kaydın mevcut parametresi veya kendisi dışındaki herhangi bir kayıt ile eşleşmeyen bir parametre olması gerektiğini belirtmek için kullanılır. Sadece 3'ncü parametre belirtilirse, veri anahtarıyla aynı isme sahip sütunda kontrol edilir, 4'ncü parametre belirtilirse 3'ncü parametre sütun adı, 4'ncü parametre ise değer olarak algılanır.



    knownunique:users:aliyilmaz

veya


    knownunique:users:username:aliyilmaz



##### bool

Parametrenin boolean türünde olması gerektiğini ifade etmek için kullanılır. Ekstra bir parametre gönderilmeden kullanıldığında geçerli bir boolean verisi olup olmadığını kontrol eder. Ekstra bir parametre gönderilirse bu parametrenin boolean türüyle aynı olup olmadığını kontrol eder. (Veri şu söz dizimlerinden birinde gönderilebilir. `true`, `false`, `'true'`, `'false'`, `0`, `1`, `'0'` veya `'1'`)

    bool
    
veya

    bool:true
    
veya

    bool:false
    
veya

    bool:1
    
veya

    bool:0
    
##### iban

Verinin bir IBAN numarası olması gerektiğini ifade etmek için kullanılır.  Ekstra bir parametreye ihtiyaç duymadığından `iban` yazarak kullanılabilir.

    iban

##### ipv4

Verinin `ipv4` söz diziminde olması gerektiğini ifade etmek için kullanılır.  Ekstra bir parametreye ihtiyaç duymadığından `ipv4` yazarak kullanılabilir.

    ipv4

##### ipv6

Verinin `ipv6` söz diziminde olması gerektiğini ifade etmek için kullanılır.  Ekstra bir parametreye ihtiyaç duymadığından `ipv6` yazarak kullanılabilir.

    ipv6


##### blood

Belirtilen parametrenin geçerli bir kan grubu olması gerektiğini ifade etmek için kullanılır. Ekstra bir kan grubu parametresi belirtilirse,  ekstra parametrenin ilk parametre için uygun donör olup olmadığı kontrol edilir.

    blood
    
veya

    blood:0+ 


##### coordinate

Virgül ile ayrılmış Enlem ve Boylam parametresinin geçerli bir koordinat noktasını işaret etmesi gerektiğini ifade etmek için kullanılır. Ekstra bir parametreye ihtiyaç duymadığından `coordinate` yazarak kullanılabilir.

    coordinate


##### distance

`@` işareti ile ayrılmış iki farklı koordinat noktası arasındaki mesafenin extra parametrede belirtilen miktar kadar olması gerektiğini ifade etmek için kullanılır. Rakam ve ölçü birimi arasında bir boşluk bırakılmalıdır. Kullanımına izin verilen ölçü birimleriyle ilgili daha fazla bilgi için [distanceMeter](https://github.com/aliyilmaz/Mind/blob/master/docs/tr-readme.md#distancemeter) metodunu inceleyebilirsiniz.

    distance:349 km


##### languages

Verinin `languages()` metodunda bulunan dil kısaltmalarından biri olması gerektiğini ifade etmek için kullanılır.  Ekstra bir parametreye ihtiyaç duymadığından `languages` yazarak kullanılabilir.

    languages

----------


## accessGenerate()

Bu fonksiyon sunucu yazılımına özgü erişim yönetmeliği dosyalarını (.htaccess, web.config) oluşturmaya yarar. 

`/` rotası bir defa kullanıldığında fonksiyon tetiklenir. `Apache`, `Microsoft IIS` ve `LiteSpeed` sunucu yazılımları desteklenmektedir. Bu fonksiyon, `route()` metodu içinde çalıştırılarak etkinleştirilmiştir.


#### Apache ve LiteSpeed için (.htaccess) 

###### Ana dizin

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} -s [OR]
    RewriteCond %{REQUEST_FILENAME} -l [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^.*$ - [NC,L]
    RewriteRule ^.*$ index.php [NC,L]


###### Herkese kapalı dizin

    Deny from all

###### Herkese açık dizin

    Allow from all

---

#### Microsoft IIS için (web.config)

###### Ana dizin 

    <?xml version="1.0" encoding="UTF-8"?>
    <configuration>
        <system.webServer>
            <rewrite>
                <rules>
                    <rule name="Imported Rule 1" stopProcessing="true">
                        <match url="^(.*)$" ignoreCase="false" />
                        <conditions>
                            <add input="{REQUEST_FILENAME}" matchType="IsFile" ignoreCase="false" negate="true" />
                            <add input="{REQUEST_FILENAME}" matchType="IsDirectory" ignoreCase="false" negate="true" />
                        </conditions>
                        <action type="Rewrite" url="index.php?{R:1}" appendQueryString="true" />
                    </rule>
                </rules>
            </rewrite>
        </system.webServer>
    </configuration>


###### Herkese kapalı dizin

    <authorization>
        <deny users="?"/>
    </authorization>

###### Herkese açık dizin

    <configuration>
        <system.webServer>
            <directoryBrowse enabled="true" showFlags="Date,Time,Extension,Size" />
        </system.webServer>
    </configuration>


----------

## print_pre()

Bu fonksiyon `array` ya da `json` biçiminde gönderilen verileri okunabilir şekilde ekrana yansıtmak amacıyla kullanılır.

##### Örnek

    /* -------------------------------------------------------------------------- */
    /*                                    ARRAY                                   */
    /* -------------------------------------------------------------------------- */
    $data = array(
            'username'=>'aliyilmaz',
            'password'=>md5(123456)
    );
    $this->print_pre($data);

veya

    /* -------------------------------------------------------------------------- */
    /*                                    JSON                                    */
    /* -------------------------------------------------------------------------- */
    $data = json_encode(array(
        'username'=>'aliyilmaz',
        'password'=>md5(123456)
    ));

    $this->print_pre($data);

----------

## arraySort()

Bu fonksiyon Dizi veya JSON biçiminde tutulan veri kümelerini sıralamak amacıyla kullanılır. 3 parametre alır, sadece ilk parametrenin belirtilmesi zorunludur. İlk parametre, `ARRAY` ya da `JSON` türünde belirtilen veri kümesi içindir, 2'nci parametre, veri türü `string` olan `asc`,`desc`,`ASC` veya `DESC` sıralama tiplerinden birini belirtmek içindir. Üçüncü parametreyse anahtarlı veri kümelerinde anahtar değerlerine göre sıralama yapmak içindir. Varsayılan olarak 2'nci parametre `ASC` değerine sahiptir.

##### Örnek


    /* -------------------------------------------------------------------------- */
    /*                                    ARRAY                                   */
    /* -------------------------------------------------------------------------- */
    echo '<h1>ARRAY</h1>';
    echo '<hr>';

    // 1 KADEMELİ DİZİLERDE SIRALAMA YAPMAK
    $data = array(
        2021,
        2020,
        2019
    );
    echo '<h4>2021 üstte</h4>';
    $this->print_pre($this->arraySort($data, 'DESC'));


    // 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTEREK SIRALAMA YAPMAK
    $data = array(
        array(
            'username'=>'aliyilmaz',
            'age'=>33
        ),
        array(
            'username'=>'eylül',
            'age'=>30
        )
    );
    echo '<hr>';
    echo '<h4>eylül üstte</h4>';
    $this->print_pre($this->arraySort($data, 'ASC', 'age'));


    // 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTMEDEN SIRALAMA YAPMAK
    // İLK ANAHTAR DEĞERİNİ REFERANS ALIR
    $data = array(
        array(
            'username'=>'aliyilmaz',
            'age'=>33
        ),
        array(
            'username'=>'aliyilmaz1',
            'age'=>29
        ),
        array(
            'username'=>'eylül',
            'age'=>30
        )
    );
    echo '<hr>';
    echo '<h4>aliyilmaz üstte</h4>';
    $this->print_pre($this->arraySort($data, 'ASC'));


    /* -------------------------------------------------------------------------- */
    /*                                    JSON                                    */
    /* -------------------------------------------------------------------------- */
    echo '<h1>JSON</h1>';
    echo '<hr>';

    // 1 KADEMELİ DİZİLERDE SIRALAMA YAPMAK
    $data = json_encode(array(
        2021,
        2020,
        2019
    ));
    echo '<h4>2021 üstte</h4>';
    $this->print_pre($this->arraySort($data, 'DESC'));


    // 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTEREK SIRALAMA YAPMAK
    $data = json_encode(array(
        array(
            'username'=>'aliyilmaz',
            'age'=>33
        ),
        array(
            'username'=>'eylül',
            'age'=>30
        )
    ));
    echo '<hr>';
    echo '<h4>eylül üstte</h4>';
    $this->print_pre($this->arraySort($data, 'ASC', 'age'));


    // 2 KADEMELİ DİZİLERDE ANAHTAR BELİRTMEDEN SIRALAMA YAPMAK
    // İLK ANAHTAR DEĞERİNİ REFERANS ALIR
    $data = json_encode(array(
        array(
            'username'=>'aliyilmaz',
            'age'=>33
        ),
        array(
            'username'=>'aliyilmaz1',
            'age'=>29
        ),
        array(
            'username'=>'eylül',
            'age'=>30
        )
    ));
    echo '<hr>';
    echo '<h4>aliyilmaz üstte</h4>';
    $this->print_pre($this->arraySort($data, 'ASC'));



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

## request()

`$_GET`, `$_POST` ve `$_FILES` isteklerini güvenli ve düzenli bir yapıya kavuşturmak amacıyla kullanılır, Verilere `$this->post` dizi değişkeni içinden erişilir,**Mind.php** dosyasında bulunan `__construct()` metodu içinde çalıştırılarak etkin hale getirilmiştir.

##### type="text" kullanımı

    <form action="new" method="post">  
	    <input type="text" name="username"> 
	    <input type="password" name="password"> 
	    <button type="submit">Send!</button>
     </form>

    $this->print_pre($this->post);
    echo $this->post['username'];
    echo $this->post['password'];

##### type="text" ve type="file" (Dosya) kullanımı

    <form action="new" method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="singlefile"> 
    	<button type="submit">Send!</button>
     </form>

    $this->print_pre($this->post);
    echo $this->post['username'];
    echo $this->post['password'];
    echo $this->post['singlefile']['name'];

##### type="text" ve type="file" (Dosyalar) kullanımı

    <form action="new" method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="multifile[]" multiple="multiple"> 
    	<button type="submit">Send!</button>
     </form>

    $this->print_pre($this->post);
    echo $this->post['username'];
    echo $this->post['password'];
    $this->print_pre($this->post['multifile']);

----------

## filter()

Bu metod `html` ve özel karakterleri, `sql_injection`, `xss` gibi istismar kodlarını etkisiz hale getirmek amacıyla kullanılır. `string` olarak gönderilen veriyi `htmlspecialchars` metodu yardımıyla güvenli hale getirip geri döndürür. Veriyi eski haline dönüştürmek için `htmlspecialchars_decode` metodu kullanılmalıdır.


##### Örnek

    $content = "%&%()' OR 1=1 karakterleri etkisizleştirilmiştir.";
    echo $this->filter($content);

veya

    $content = "<script>alert('XSS Açığı var'); </script>";
    echo $this->filter($content);


----------

## firewall()

Bu fonksiyon, Clickjacking, XSS, MIME Sniffing, CSRF davranışlarını engellemeye yarar. Varsayılan olarak tüm alt ayarlar tanımlandığı için parametre belirtme zorunluluğu yoktur. Varsayılan olarak __construct() metodu içerisinde çalıştırılarak etkinleştirilmiştir.

#### noiframe

Projenin iframe yoluyla kullanılmasını engellemek için kullanılır, `boolean` türünde belirtilmelidir. Varsayılan olarak `true` belirtilmiştir.


#### nosniff

Projeyi görüntüleyen kullanıcının tarayıcısının, proje içeriğini analiz etmesini engellemek için kullanılır, `boolean` türünde belirtilmelidir. Varsayılan olarak `true` belirtilmiştir.


#### noxss

Mind, XSS kodlarını etkisiz hale getirmektedir, buna rağmen proje adreslemesine kod enjekte etme girişimlerini durdurmak için bu alt ayar kullanılır, `boolean` türünde belirtilmelidir. Varsayılan olarak `true` belirtilmiştir.

#### ssl

SSL etkin bir projenin oturumlarını, SSL üzerinden kullanıcıya iletmek için kullanılır, bu sayede kullanıcıların username & password bilgileri başta olmak üzere, kredi kartı vb kritik bilgilerinin de güvenliği sağlanmış olur. Varsayılan olarak `true` belirtilmiştir.

#### hsts

SSL etkin bir projenin veri trafiğini, SSL üzerinden iletmeye zorlamak için kullanılır, bu sayede kullanıcıyla sunucu arasındaki haberleşmenin SSL ile korunması sağlanmış olur. Varsayılan olarak `true` belirtilmiştir.


#### csrf

Yetkisiz HTTP POST isteklerini engellemeye yarar, varsayılan olarak `true` belirtilmiştir. `token` adı ve rastgele parametre uzunluğu belirtmek mümkündür, varsayılan olarak token adı `csrf_token`, parametre uzunluğuysa `200` belirtilmiştir. 

Bu alt ayar etkin olduğu sürece herhangi bir form'dan gönderilenlerde `csrf_token` parametresini arayacak, bulamadığı taktirde ise söz konusu isteği durduracaktır. Form'a token input'unu eklemek için form içinde bir yere bu `<?=$_SESSION['csrf']['input'];?>` parametreyi belirtmek gerekir. 

##### Örnek

    $conf = array(
        'host'      =>  'localhost',
        'dbname'    =>  'mydb',
        'username'  =>  'root',
        'password'  =>  '',    
        'firewall'  =>  array(
            'noiframe'  =>  false,
            'nosniff'   =>  false,
            'noxss'     =>  false,
            'ssl'       =>  false,
            'csrf'      =>  false
            // 'csrf'      =>  true
            // 'csrf'      =>  array('limit'=>150)
            // 'csrf'      =>  array('name'=>'_token')
            // 'csrf'      =>  array('name'=>'_token', 'limit'=>150)
        )
    );

    $Mind = new Mind($conf);

    echo 'Uzaktan erişime açıktır';

**Bilgi:** Her geçerli `token`'a sahip HTTP POST isteği sonrası parametreler değiştirilir.

----------

## redirect()

Belirtilen adrese doğrudan veya belli bir süre sonra yönlendirme yapmak amacıyla kullanılır, boş bırakılırsa **Mind.php** dosyasının bulunduğu klasör'e yönlendirme yapar. İki parametre alır, ilk parametre yönlenecek adrestir ve `string` olarak belirtilmesi gerekir, ikinci parametre kaç saniye sonra yönlenmesi gerektiği bilgisidir ve `integer` olarak belirtilmesi gerekir. Üçüncü parametre ise yönlendirmeye kalan sürenin atanacağı element adı bilgisidir. Bu parametre javascript'in `querySelectorAll` metoduna gönderildiğinden, javascript'in element'e erişim yaklaşımı referans alınarak belirtilmelidir.

##### Örnek

    $this->redirect();

veya

    $this->redirect('contact');

veya

    $this->redirect('https://www.google.com');

veya

    $this->redirect('', 5);
    
veya

    $this->redirect('contact', 5);

veya

    $this->redirect('https://www.google.com', 5);

veya

    /* -------------------------------------------------------------------------- */
    /*                        GERİ SAYIM SAYAÇLI KULLANIMI                        */
    /* -------------------------------------------------------------------------- */
    <?=$this->redirect('https://www.google.com', 20, '.example1 #redirect-time');?>

    <form class="example1" action="">
        
        <h5>INPUT TEXT</h5>
        <input type="text" id="redirect-time">
        
        <br>
        
        <h5>TEXTAREA</h5>
        <textarea id="redirect-time"></textarea>
        
        <br>
        
        <h5>SPAN</h5>
        <span id="redirect-time"></span>
        
        <br>
        
        <h5>i</h5>
        <i id="redirect-time"></i>
        
        <br>
        
        <h5>CHECKBOX</h5>
        <input type="checkbox" id="redirect-time">
        <label for="redirect-time"> I have a bike</label>
        
        <br>

        <h5>OPTION</h5>
        <select>
            <option id="redirect-time">Redirect time</option>
            <option>Nothing</option>
        </select>
        
        <br>

        <h5>MULTI OPTION</h5>
        <select name="fruit" multiple>
            <option value ="none">Nothing</option>
            <option value ="guava" id="redirect-time">Guava</option>
            <option value ="lychee">Lychee</option>
            <option value ="papaya">Papaya</option>
            <option value ="watermelon">Watermelon</option>
        </select> 

    </form>


----------

## permalink()

Kendisiyle paylaşılan veriyi arama motoru dostu bir link yapısına dönüştürmek amacıyla kullanılır. İki parametre alabilir, İlk parametre de link yapısına dönüştürülmek istenen veri `string` olarak, ikinci parametrede ise aşağıda belirtilen ayarlar yer alır. ikinci parametre isteğe bağlı olup belirtilme zorunluluğu bulunmamaktadır.

##### Örnek

    $str = 'Merhaba dünya';
    echo $this->permalink($str);


#### Ayraç (delimiter)
 Varsayılan olarak `string` yapıda ki veri içinde bulunan boşluklar tire `-` yardımıyla ayrılır, eğer tire `-` yerine başka bir parametre barındırması arzu edilirse, `delimiter` özelliği kullanılabilir.
 
##### Örnek

    $str = 'Merhaba dünya';
    $option = array(
        'delimiter' => '_'
    );
    echo $this->permalink($str, $option);

#### Limit (limit)
 Varsayılan olarak `string` yapıda ki veri `SEO` dostu bir yapıya kavuşturularak geriye döndürülür , eğer belli bir karakter sayısında döndürülmesi istenirse, `limit` özelliği kullanılabilir.
 
 ##### Örnek
 
     $str = 'Merhaba dünya';
     $option = array(
         'limit'=>'3'
     );
     echo $this->permalink($str, $option);

 veya

      $str = 'Merhaba dünya';
      $option = array(
          'limit'=>3
      );
      echo $this->permalink($str, $option);

#### Harf boyutu (lowercase)
Varsayılan olarak `string` yapıda ki veri tamamıyla küçük harfe dönüştürülür, eğer harflerin yazıldığı boyutta kalması istenirse, `lowercase` özelliği kullanılabilir.

##### Örnek

    $str = 'Merhaba dünya';
    $option = array(
        'lowercase'=>false
    );
    echo $this->permalink($str, $option); 

#### Kelime değişimi (replacements)
`string` yapıda ki veri içinde belirtilen kelimeleri değiştirmek mümkündür, 

##### Örnek

    $str = 'Merhaba dünya';
    $option = array(
        'replacements'=>array(
            'Merhaba'=>'hello', 
            'dünya'=>'world'
        )
    );
    echo $this->permalink($str, $option);
    
#### Karakter desteği (transliterate)
Farklı alfabelere ait harfler varsayılan olarak `SEO` dostu karşılıklarıyla değiştirilir, eğer olduğu gibi yazılmaları istenirse, `false` parametresi belirtilmelidir.

##### Örnek

    $str = 'Merhaba dünya';
       $option = array(
           'transliterate'=>false
       );
       echo $this->permalink($str, $option);

#### Benzersiz bağlantı oluşturma (unique)
`string` yapıdaki veri, veritabanı tablosunun belirtilen sütununda aranır, eğer bir veya daha fazla bulunursa bunların toplam adedi tespit edilir.

Elde edilen bu toplam, bir döngü yardımıyla, `string` yapıdaki verinin sonuna, `delimiter` ayracından yardım alınarak eklenir ve veritabanı tablosunda tek tek varlık kontrolü yapılır.
 
 Eğer söz konusu bağlantı adayı, veritabanı tablosunda bulunmuyorsa o hali geri döndürülür. 
 
 Eğer tüm bulgularda yapılan varlık kontrolü neticesinde bağlantı adayı için uygun bir numaralandırma söz konusu değilse, bulgu toplamı **1** artırılmış şekilde bağlantı güncellenerek geri döndürülür.
 
Varsayılan olarak `delimiter` parametresi için tire **-** değeri, `linkColumn` parametresi için **link** değeri ve `titleColumn` parametresi ise **title** değeri tanımlanmıştır.

##### Örnek

    $str = 'Merhaba dünya';
    $option = array(
        'unique' => array(
            'tableName' => 'pages'
        )
    );
    echo $this->permalink($str, $option);

veya 

    $str = 'Merhaba dünya';
    $option = array(
        'unique' => array(
            'tableName' => 'pages',
            'delimiter' => '_'
        )
    );
    echo $this->permalink($str, $option);
    
    
veya

    $str = 'Merhaba dünya';
    $option = array(
        'unique' => array(
            'tableName' => 'pages',
            'titleColumn' => 'title',
            'linkColumn' => 'link'
        )
    );
    echo $this->permalink($str, $option);
    
----------

## timezones()

Bu fonksiyon, zaman damgasını isabetli kılmak amacıyla tercih edilen `date_default_timezone_set()` fonksiyonunda kullanılabilen bölge kodlarını dizi halinde sunar. Daha fazla bilgi için [Desteklenen Zaman Dilimlerinin Listesi](https://secure.php.net/manual/tr/timezones.php) sayfasını inceleyebilirsiniz.

    $this->print_pre($this->timezones());

----------

## languages()

Bu fonksiyon, 182 adet dilin evrensel ve yerel ismi ile kısaltmasını dizi halinde sunar. Daha fazla bilgi için [Stackoverflow](https://stackoverflow.com/a/4900304) sayfasını inceleyebilirsiniz.

    $this->print_pre($this->languages());

----------

## currencies()

Bu fonksiyon, 162 adet para birimi isim ve kısaltmasını dizi halinde sunar. Daha fazla bilgi için [Github Gist](https://gist.github.com/champsupertramp/95493faa7ba12b61bf6e#gistcomment-2085024) sayfasını inceleyebilirsiniz.

    $this->print_pre($this->currencies());

----------

## session_check()

`session_start()` komutunun kişiselleştirilmiş şekilde uygulanmasını sağlamak amacıyla kullanılır, Oturum Ayarları kısmında bulunan ayarlar ışığında oturumun akıbetini belirlemeye yarar,**Mind.php** dosyasında bulunan `__construct()` metodu içinde çalıştırılarak etkin hale getirilmiştir.

    $this->session_check();

----------

## remoteFileSize()

Uzak sunucuda barınan dosyanın boyunutunu(byte olarak) öğrenmeye yarar.

    echo $this->remoteFileSize('https://github.com/fluidicon.png');

----------

## mindLoad()

`.php` uzantıya sahip dosya ya da dosyaları projeye dahil etmek amacıyla kullanılır. `$file` ve `$cache`, dosyalara ait yollarının tutulduğu değişkenleri temsil etmektedir. Dosya yolları `.php` uzantısı olmadan belirtilmelidir.

Her iki değişkene de `string` veya `array` olarak dosya yolları gönderilebilir, eğer dosyalar varsa projeye `require_once` yöntemiyle dahil edilirler. 

İki parametre alır, ilk önce ikinci parametre olan `$cache` dosyaları, ardından birinci parametre olan `$file` değişkeninde bulunan dosyalar projeye dahil edilir. `$cache` değişkeni isteğe bağlı olup, belirtilme zorunluluğu bulunmamaktadır. Sınıf dışından erişime izin vermek için `public` özelliği tanımlanmıştır.

##### Örnek

    $this->mindLoad('app/views/home');

veya

    $file = array(
        'app/views/header',
        'app/views/content',
        'app/views/footer'
    );
    $this->mindLoad($file);

veya

    $this->mindLoad('app/views/home', 'app/model/home');

veya

    $file = array(
        'app/views/layout/header',
        'app/views/home',
        'app/views/layout/footer
    );
    $cache = array(
        'app/middleware/auth',
        'app/database/install',
        'app/model/home'
    );
    $this->mindLoad($file, $cache);

----------

## cGeneration()
Bu fonksiyon, veritabanı tablo veya sütunu oluştururken yazılması icap eden `sql` söz dizimini oluşturmak amacıyla kullanılır. `sql` söz dizimi, `tableCreate` ve `columnCreate` metodlarına gönderilen şema'nın yorumlanmasıyla oluşturulur. 

----------

## pGeneration()
Bu fonksiyon, `route` ve `mindLoad` metodlarına gönderilen parametreli adresin ayrıştırılması amacıyla kullanılır. 

----------

## generateToken()
Bu fonksiyon, belirtilen karakter uzunluğunda rastgele parametre oluşturmak amacıyla kullanılır, `integer` türünde bir parametre alır, belirtilme zorunluluğu bulunmamaktadır. Varsayılan olarak karakter uzunluğu `100` olarak belirtilmiştir.

##### Örnek

    echo $this->generateToken();

veya

    echo $this->generateToken(30);

----------

## coordinatesMaker()

Bu fonksiyon, ziyaretçinin GPS konumunun paylaşılmasına izin vermesi halinde, konum bilgisini elde etmek için kullanılır. `string` bir parametre alır ve belirtilmesi zorunlu değildir. Bu parametre javascript'in `querySelectorAll` metoduna gönderildiğinden, javascript'in element'e erişim yaklaşımı referans alınarak belirtilmelidir.(`form.example #my-coordinates` gibi). Eğer parametre belirtilmezse varsayılan olarak id'si `#coordinates` olan elementlere ziyaretçi konumunu ekler.

##### Örnek

    <?=$this->coordinatesMaker('form.example1 #my-coordinates');?>
    <form class="example1" action="">

        <h5>INPUT TEXT</h5>
        <input type="text" id="my-coordinates">

        <br>

        <h5>TEXTAREA</h5>
        <textarea id="my-coordinates"></textarea>

        <br>

        <h5>SPAN</h5>
        <span id="my-coordinates"></span>

        <br>

        <h5>i</h5>
        <i id="my-coordinates"></i>

        <br>

        <h5>CHECKBOX</h5>
        <input type="checkbox" id="my-coordinates">
        <label for="my-coordinates"> I have a bike</label>

        <br>

        <h5>OPTION</h5>
        <select>
            <option id="my-coordinates">My Coordinate</option>
            <option>Nothing</option>
        </select>

        <br>

        <h5>MULTI OPTION</h5>
        <select name="fruit" multiple>
            <option value ="none">Nothing</option>
            <option value ="guava" id="my-coordinates">Guava</option>
            <option value ="lychee">Lychee</option>
            <option value ="papaya">Papaya</option>
            <option value ="watermelon">Watermelon</option>
        </select> 

    </form>

veya

    <?=$this->coordinatesMaker();?>
    <form action="">

        <h5>INPUT TEXT</h5>
        <input type="text" id="coordinates">

        <br>

        <h5>TEXTAREA</h5>
        <textarea id="coordinates"></textarea>

        <br>

        <h5>SPAN</h5>
        <span id="coordinates"></span>

        <br>

        <h5>i</h5>
        <i id="coordinates"></i>

        <br>

        <h5>CHECKBOX</h5>
        <input type="checkbox" id="coordinates">
        <label for="coordinates"> I have a bike</label>

        <br>

        <h5>OPTION</h5>
        <select>
            <option id="coordinates">My Coordinate</option>
            <option>Nothing</option>
        </select>

        <br>

        <h5>MULTI OPTION</h5>
        <select name="fruit" multiple>
            <option value ="none">Nothing</option>
            <option value ="guava" id="coordinates">Guava</option>
            <option value ="lychee">Lychee</option>
            <option value ="papaya">Papaya</option>
            <option value ="watermelon">Watermelon</option>
        </select> 

    </form>



****Bilgi:**** Chrome, Firefox tarayıcılarınında test edilmiştir. Cep telefonu yoluyla paylaşılan konumların doğruluk oranı ortalama 4 ile 12 m2'dir. Eski nesil GPS modüle sahip masaüstü bilgisayar yoluyla paylaşılan konumların doğruluk oranı ise ortalama 7.000 m2'dir.

----------

## encodeSize()

Belirtilen byte değerini, dönüştürebileceği en büyük boyut türüne dönüştürmeye yarar. Sadece byte türünde bir değer veya bir size anahtarı barındıran dizi(dosya dizisi gibi) gönderilebilir. 

**Desteklenen Boyutlar**
`KB`, `MB`, `GB`, `TB`, `PB`, `EB`

##### Örnek


    // 1 KB
    echo $this->encodeSize(1024);

veya

    // 1 MB
    echo $this->encodeSize(1048576);

veya

    // 1 GB
    echo $this->encodeSize(1073741824);

veya

    // 1 TB
    echo $this->encodeSize(1099511627776);

veya

    // 1 PB
    echo $this->encodeSize(1125899906842624);

veya

    // 1 EB
    echo $this->encodeSize(1152921504606850000);

veya

    // 1 MB
    $file = array('size'=>1048576);
    echo $this->encodeSize($file);

----------

## decodeSize()

Belirtilen türdeki boyutu, byte'a dönüştürmek amacıyla kullanılır. Boyut ve boyut kısaltması arada bir boşluk bırakılarak belirtilmelidir.

**Desteklenen Boyutlar**
`KB`, `MB`, `GB`, `TB`, `PB`, `EB`


    // 1024
    echo $this->decodeSize('1 KB');

veya


    // 1048576
    echo $this->decodeSize('1 MB');

veya


    // 1073741824
    echo $this->decodeSize('1 GB');

veya


    // 1099511627776
    echo $this->decodeSize('1 TB');

veya


    // 1125899906842624
    echo $this->decodeSize('1 PB');

veya


    // 1152921504606846976
    echo $this->decodeSize('1 EB');



----------

## getIPAddress()

Projeyi görüntüleyen kullanıcının ip adresini elde etmeye yarar.

##### Örnek


    echo $this->getIPAddress();



----------

## getOS()

Projenin çalıştığı sunucu işletim sistemi ismini elde etmek için kullanılır. `Darwin`, `Windows`, `Linux` işletim sistemlerini desteklemektedir, bunlar dışındaki işletim sistemleri `Unknown` olarak isimlendirilir.

##### Örnek

    echo $this->getOS();

----------

## getSoftware()

Projenin çalıştığı işletim sistemi üzerindeki sunucu yazılımı ismini elde etmek için kullanılır. `Apache`, `Microsoft ISS` ve `LiteSpeed` yazılımları desteklemektedir, bunlar dışındaki sunucu yazılımları `Unknown` olarak isimlendirilir.

##### Örnek

    echo $this->getSoftware();

----------

## route()

Route fonksiyonu özelleştirilebilir rotalar tanımlamak ve bu rotalara özel zihinler yüklemek için kullanılır. Zihin kelimesi, Model, View, Controller, Middleware gibi çeşitli katmanları tanımlamak amacıyla kullanılmıştır. Böylelikle geliştirici, katmanların hangi rotaya tanımlandığını açıkça görebilir, yönetebilir ve proje ihtiyacına özel tasarım deseni oluşturabilir.  
  
Rotalar, `Mind.php` dosyasıyla aynı dizinde bulunan `index.php` dosyası içine tanımlanır, dolayısıyla `new Mind()` çağrısının atandığı değişkeni ön ek kabul ederek çalışır.

##### Örnek

    <?php

    require_once '../src/Mind.php';

    $Mind = new Mind();

    $Mind->route('/', 'app/views/welcome');

    ?>


#### Giriş

`url`, `file` ve `cache` parametreleri alabilen `route()` fonksiyonu, `url` parametresini `string` olarak kabul eder, `file` ve `cache` parametreleriniyse `string` ve `array` olarak kabul etmektedir. Bu üç parametreden sadece `cache` parametresinin belirtilme zorunluluğu yoktur. `file` ve `cache` parametreleri, uzantısı belirtilmeyen `php` dosyalarının yollarından meydana gelir. `cache` parametresi aynı zamanda sınıf metodlarını çağırmak için de kullanılabilir.

#### Url

`/` slaş sembolü dışında ki rotalara parametre isimleri tanımlamak mümkündür, eğer adres satırına `edit/users/1` yazılırsa ve `users` parametresini `table` ismiyle, `1` parametresini ise `id` ismiyle isimlendirmek istenirse, aşağıda ki yolu izlemek gerekir.

    $Mind->route('edit:table@id', 'app/view/edit');

Kontrolü sağlamak için `app/view/edit` yolunda ki `edit.php` dosyası içine

    $this->print_pre($this->post);

kodu eklendikten sonra, adres satırına `edit/users/1` yazarak, parametre isimlerinin `url` de tanımlanan parametre isimlerine pay edildiği görülebilir.

    Array (
        [table] => users
        [id] => 1
    )

Ayrıca adres satırına `edit/users/1/2/diger` gibi rota da isimlendirilmemiş parametreler yazılırsa bunlar görmezden gelinir. Eğer `url` parametresine aşağıda ki gibi parametre isimleri tanımlanmamışsa

    $Mind->route('edit', 'app/view/edit');

ve ulaşılmak istenen rota adresi `edit/users/1` ise, `app/view/edit` yolunda ki `edit.php` dosyası içine

    $this->print_pre($this->post);

kodu eklendiğinde, isimlendirilmemiş parametreler aşağıda ki şekilde görünecektir.

    Array (
        [0] => users
        [1] => 1
    )

#### File

`cache` parametresinde belirtilen dosya veya dosyalar projeye dahil edildikten sonra projeye `file` parametresinde tanımlanan dosya(lar) dahil edilir.

##### Örnek

    $Mind->route('/', 'app/view/home');

veya

    $arr = array(
        'app/view/layout/header',
        'app/view/home',
        'app/view/layout/footer'
        );
    $Mind->route('/', $arr);

#### Cache

Eğer `cache` parametresi belirtilirse, belirtilen `cache` dosyaları, `file` parametresinde belirtilen dosya(lar) henüz projeye dahil edilmeden önce, ilk eklenenden son eklenene doğru tek tek varlık kontrolünden geçirilerek projeye dahil edilir. İsteğe bağlı olarak `cache` parametresinde sınıfa ait metod veya metodlar çalıştırılabilir.

##### Örnek

    $Mind->route('/', 'app/view/home', 'database/CreateTable');

veya

    $arr = array(
        'database/CreateTable,
        'model/home'
    );
    $Mind->route('/', 'view/home', $arr);
    
veya

`app/controller/HomeController.php` dosyasını oluşturup içine aşağıda ki kodları kaydedin.
 
    <?php
    
    class HomeController extends Mind
    {
    
        public function __construct($conf = array())
        {
            parent::__construct($conf);
        }
    
        public function index()
        {
            //
            echo 'merhaba ben index';
        }
    
        public function create()
        {
            //
            echo 'merhaba ben create';
        }
    
    }

daha sonra aşağıda ki rotayı tanımlayın ve kontrol edin.

    
    $Mind->route('home', 'app/views/home', 'app/controller/HomeController:index@create');

Sınıf içinde ki `index` ve `create` metodlarının çalıştığını görebilirsiniz. Bir veya daha fazla metodu bir rotaya tanımlamak mümkündür. 

Oluşturulan bu `HomeController` sınıfı içinden `Mind` metodlarına `$this->` ön ekiyle ulaşılabilir.

Eğer metod çağırılırsa sınıf adıyla dosya adının aynı olması gerekmektedir.


#### .htaccess

`route()` fonksiyonu kullanıldığı zaman, eğer **Mind.php** dosyasının bulunduğu dizinde ve o dizinde ki klasörlerde `.htaccess` dosyası yoksa oluşturulur. Klasörlerin içinde oluşturulan `.htaccess` dosyası direkt erişimi engelleyen komut içerir. **Mind.php** ile aynı dizinde oluşturulan `.htaccess` dosyası ise anlamlı `url` rotalarını elde etmeyi sağlayan aşağıda ki komutları içerir.

##### Örnek (Erişimi kısıtlanan dizinler için)

    Deny from all

veya (Mind.php dosyasının olduğu dizin için)

    RewriteEngine On  
    RewriteCond %{REQUEST_FILENAME} -s [OR]  
    RewriteCond %{REQUEST_FILENAME} -l [OR]  
    RewriteCond %{REQUEST_FILENAME} -d  
    RewriteRule ^.*$ - [NC,L]  
    RewriteRule ^.*$ index.php [NC,L]

----------

## write()

Belirtilen içeriği, belirtilen isimde ki dosyaya yazmak amacıyla kullanılır, eğer işlem başarılıysa `true`, değilse `false`  değeri döndürülür. üç parametre alır;

##### İlk parametre

içeriği temsil etmekte olup `string` veya `array` türünde gönderilebilir, dizi olarak gönderilmesi halinde dizi elemanları aralarına `:` sembolü eklenerek `string`'e dönüştürülmüş şekilde dosyaya yazılır.

##### İkinci parametre

Dosya yolunu temsil etmektedir, eğer dosya varsa söz konusu veri dosyanın sonuna eklenir, eğer dosya yoksa yolda belirtilen isimde bir dosyayı oluşturulur ve bu dosyaya yazılır.

##### Üçüncü parametre

Dizi olarak belirtilen verileri ayırmada kullanılacak değeri temsil etmektedir. Belirtilme zorunluluğu yoktur, varsayılan olarak `:` tanımlanmıştır.

##### Örnek

    $str = 'Merhaba dünya';
    $this->write($str, 'yeni.txt');

veya

    $str = array('Merhaba', 'Dünya');
    $this->write($str, 'yeni.txt');
    

veya

    $str = array('Merhaba', 'Dünya');
    $this->write($str, 'yeni.txt', '~');
    
----------

## upload()

Belirtilen dosya veya dosyaları, belirtilen klasöre yüklemek amacıyla kullanır, `$this->post['singlefile']` ve `$this->post['multifile']` dosyaların tutulduğu değişkenleri `$path` ise dosyaların yükleneceği klasör yolunu temsil etmektedir.

**Bilgi:** Dosya yükleme işlemi sırasında tek seferde maksimum kaç adet dosyanın yükleneceğini `php.ini` dosyasındaki `max_file_uploads` kısmından güncelleyebilirsiniz.
##### Örnek

    <form method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="singlefile"> 
    	<button type="submit">Send!</button>
     </form>
    
    <?php
    if(!empty($this->post['singlefile'])){
        $path = './upload';
        $u = $this->upload($this->post['singlefile'], $path);
        $this->print_pre($u);
    }
    ?>

veya 

    <form method="post" enctype="multipart/form-data">  
    	<input type="text" name="username"> 
    	<input type="password" name="password"> 
    	<input type="file" name="multifile[]" multiple="multiple"> 
    	<button type="submit">Send!</button>
     </form>

    <?php
    if(!empty($this->post['multifile'])){
        $path = './upload';
        $u = $this->upload($this->post['multifile'], $path);
        $this->print_pre($u);
    }
    ?>
    
----------

## download()

Yerel ve Uzak sunucuda barınan dosyaları indirmeye yarar. Dosya yolları `string` veya `array` olarak belirtilebilir. İki parametre alır, ilk parametre `string` veya `array` türünde belirtilen dosya yollarını, ikinci parametre ise `array` olarak tanımlanan `path` yolunu temsil eder. 

  **Bilgi:** Geliştirmeye açık olduğu için ikinci parametre `array` türündedir ve belirtilme zorunluluğu yoktur. Eğer ikinci parametre belirtilmezse varsayılan olarak inecek dosyaların kökdizini `download` olur. 

##### Örnek

    $this->print_pre($this->download('./LICENSE.md'));
    

veya 

    $this->print_pre($this->download('https://github.com/fluidicon.png'));
        

veya

    $links = array(
                'https://github.com/fluidicon.png',
                './LICENSE.md'
            );
            
    $this->print_pre($this->download($links));
    
veya

    $links = array(
                'https://github.com/fluidicon.png',
                './LICENSE.md'
                );
    $this->print_pre($this->download($links, array('path' => 'app/dosyalar')));
    
----------

## get_contents()

Kendisiyle paylaşılan `string` yapıda ki veride veya bir  url'nin varış noktasında bulunan sayfanın kaynak kodunda, `$left` ve `$right` değişkenlerinde belirtilen değerlerin arasında ki içeriği elde etmeye yarar. `$left` sol tarafta ki, `$right` sağ tarafta ki kapsayıcı parametresini temsil etmektedir. 

Bir veya birden fazla öğe bulunuyorsa hepsini bir `array` olarak sunar. Eğer kendisiyle paylaşılan url'nin kaynak kodu elde edilmek isteniyorsa `$left` ve `$right` değişkenlerinin olduğu ilk iki parametreye boş değer gönderilir ve geriye sayfa kaynağının `string` olarak dönmesi sağlanır.

İsteğe bağlı olan dördüncü parametre,varış adresine POST, Referer bilgisi göndermeye ve varsa erişim sırasında kullanılabilir oturum bilgisini elde etmeye yarar.


##### Örnek

    $url = 'https://www.cloudflare.com/';
    $left = '';
    $right = '';
    $data 	= $this->get_contents($left, $right, $url);
    $this->print_pre($data);

veya

    $url 	= 'https://www.cloudflare.com/';
    $left 	= '<title>';
    $right	= '</title>';
    $data 	= $this->get_contents($left, $right, $url);
    $this->print_pre($data);

veya

    $url 	= 'https://www.cloudflare.com/';
    $left 	= '<link rel="alternate" hreflang="';
    $right	= '"';
    $data 	= $this->get_contents($left, $right, $url);
    $this->print_pre($data);
    
veya

    $url 	= 'Örnek bir içeriktir. <title>Merhaba Dünya!</title>';
    $left 	= '<title>';
    $right	= '</title>';
    $data 	= $this->get_contents($left, $right, $url);
    $this->print_pre($data);

veya

    $url = 'src=\'-str\'-after src=\'-str\'-after src=\'-str\'-after src=\'-str\'-after';
    $left = 'src=\'';
    $right = '\'-after';
    $data 	= $this->get_contents($left, $right, $url);
    $this->print_pre($data);

veya

    $url = '{"filmler": [  {"imdb": "tt0116231", "url": "&lt;iframe src=&#039;https://example.com&#039; width=&#039;640&#039; height=&#039;360&#039; frameborder=&#039;0&#039; marginwidth=&#039;0&#039; marginheight=&#039;0&#039; scrolling=&#039;NO&#039; allowfullscreen=&#039;allowfullscreen&#039;&gt;&lt;/iframe&gt;"} ]}';
    $left = 'src=&#039;';
    $right = '&#039;';
    $data 	= $this->get_contents($left, $right, $url);
    $this->print_pre($data);


veya

    $url = 'https://www.example.com/login';
    $left = '';
    $right = '';
    $options = array(
    //    'referer'=>$url,
        'post'=>array(
            'username'=>'aliyilmaz',
            'password'=>'123456'
        )
    );

    // Start connection.
    $this->get_contents($left, $right, $url, $options);

    // Session access.
    $url = 'https://www.example.com/admin/users';
    $left = '<title>';
    $right = '</title>';
    $data = $this->get_contents($left, $right, $url);
    $this->print_pre($data);


----------


## distanceMeter()

Kendisiyle paylaşılan iki farklı koordinat noktası arasındaki mesafeyi, kuş uçuşu olarak hesaplamaya yarar. Koordinat bilgileri, `int`, `float` ve `string` yapıda gönderilebilir ve zorunludur.

İki koordinat arasındaki mesafenin ölçü birimi ise `string` veya `array` olarak belirtilebilir, zorunlu değildir, eğer belirtilmezse, `m`, `km`, `mi`, `ft` ve `yd` olarak dizi türünde geri döndürülür. 

Bir veya birden fazla ölçü birimine göre mesafe bilgisi elde etmek mümkündür. Eğer sadece bir ölçü birimi talep edilirse, o ölçü biriminin yanıtı `string` olarak geri döndürülür.

**Bilgi:** 

Ölçü birimleri ve kısaltmaları aşağıdaki gibidir.

*   m (Metre) 
*   km (Kilometre) 
*   mi (Mil) 
*   ft (Feet)
*   yd (Yard)

##### KOORDİNATLAR
    /* These are two points in Turkey */
    $point1 = array('lat' => 41.008610, 'long' => 28.971111); // Istanbul
    $point2 = array('lat' => 39.925018, 'long' => 32.836956); // Anitkabir


##### Örnek
    
    //Array
    //(
    //    [m] => 4188.59
    //    [km] => 4.19
    //    [mi] => 2.6
    //    [ft] => 13742.1
    //    [yd] => 4580.64
    //)
    
    $distance = $this->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
    
    $this->print_pre($distance);

veya

    //4188.59
    
    $distance = $this->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], 'm');
    echo $distance;
    
veya

    //4188.59
    
    $distance = $this->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], array('m'));
    echo $distance;
    
veya

    //Array
    //(
    //    [m] => 4188.59
    //    [km] => 4.19
    //)
    
    $distance = $this->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], array('m', 'km'));
    
    $this->print_pre($distance);
    
veya

    //Array
    //(
    //    [m] => 4188.59
    //    [km] => 4.19
    //    [mi] => 2.6
    //    [ft] => 13742.1
    //    [yd] => 4580.64
    //)
    
    $distance = $this->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], array());
    
    $this->print_pre($distance);
    
veya

    //Array
    //(
    //    [m] => 4188.59
    //    [km] => 4.19
    //    [mi] => 2.6
    //    [ft] => 13742.1
    //    [yd] => 4580.64
    //)
    
    $distance = $this->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], '');
    
    $this->print_pre($distance);


----------


## evalContainer()

Bu fonksiyon, `string` türündeki veriyi, içindeki `PHP` kodlarıyla birlikte kullanıldığı kısma eklemeye yarar. HTML özel karakterine dönüştürülmüş `PHP` kodları varsa onları da `PHP` koduna dönüştürerek kullanır.


###### Örnek

    $code = 'merhaba &lt;?=$this-&gt;timestamp;?&gt;';
    $this->evalContainer($code);

veya

    $code = 'merhaba &lt;?=$this-&gt;timestamp;?&gt;

    &lt;?php

    $array = array(
    \'username\'=&gt;\'aliyilmaz\',
    \'password\'=&gt;\'123456\'
    );

    $this-&gt;print_pre($array);';
    $this->evalContainer($code);