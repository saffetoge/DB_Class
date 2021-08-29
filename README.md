# DB_Class

### INCLUDE FILE
db.class.php projenize include ederek kullanabilirsiniz. 

```php
{
  require __DIR__ . '/db.class.php';
}
```

#### Proje içinde Kullanımları

örneğin bir tablo çekmek istiyorsanız 
```php
{
 $veriler=DB::TabloCek('tablo_adi');
 
 /*Burada $veriler array biçiminde döner*/
 
 print_r($veriler);
 
 foreach($veriler as $item){
 echo $item['sutun_adi'];
 }
}
```

yukarıda ki şekilde projenizde kullanabilirsiniz.

Eğer tek bir veri çekmek isterseniz WHERE değerini de göndermemiz gerektiği için şu şekilde kullanabilirsiniz.


```php
{
 $veriler=DB::TekVeriCek('tablo_adi','veri_cekilecek_sutun_adi','hangi_veriye_esit_olacak');
 
 /*Burada $veriler array biçiminde döner*/
 
 print_r($veriler);
 
 foreach($veriler as $item){
 echo $item['sutun_adi'];
 }
}
```

