<?php

class DB
{

  /**
   * @param null $tablo
   * @return array|false
   */
  public static function TabloCek($tablo = null)
  {
    global $db;

    $query = $db->query("SELECT * FROM $tablo");
    $query->execute();
    $toplam = $query->fetchAll(PDO::FETCH_ASSOC);
    return $toplam;
  }

  /**
   * @param null $tablo Tablo Adını yazın
   * @param null $param_id Where den sonra ki Paramatre (Sütun Adı)
   * @param null $param Sürunda bakılacak ifade
   * @return mixed
   */
  public static function VeriCek($tablo = null, $param_id = null, $param = null)
  {

    global $db;

    $query = $db->prepare("SELECT * FROM $tablo WHERE $param_id= '{$param}'");
    $query->execute();
    $query = $query->fetchAll(PDO::FETCH_ASSOC);
    return $query;
  }

  /**
   * @param null $tablo Tablo Adını yazın
   * @param null $param_id Where den sonra ki Paramatre (Sütun Adı)
   * @param null $param Sürunda bakılacak ifade
   * @return mixed
   */
  public static function TekVeriCek($tablo = null, $param_id = null, $param = null)
  {

    global $db;

    $query = $db->prepare("SELECT * FROM $tablo WHERE $param_id= '{$param}' LIMIT 1 ");
    $query->execute();
    $query = $query->fetch(PDO::FETCH_ASSOC);
    return $query;
  }



  /**
   * ekle                         veritabanına veri ekleme metodu
   * @param string $tablo verinin ekleneceği tablo adı
   * @param array $veri eklenecek veriler ve keyleri. örn: array("baslik" => "başlık", "icerik" => "veri içeriği");
   * @param integer $son_id eklenen verinin id'si isteniyorsa 1 yazılmalı.
   * @return integer              $son_id 1 olarak gelmişse, eklenen verinin id değerini geri döndürüyoruz.
   */
  public static function VeriEkle($tablo, $veri = array(), $son_id = null)
  {
    global $db;
    //tablo ve veri gelmemişse false döndürüyoruz
    if (empty($tablo) or empty($veri)) {
      return false;
    }
    //tablo isimlerini birleştiriyoruz
    $tablolar = implode(", ", array_keys($veri));
    //veri keylerini birleştiriyoruz
    $veriler = ":" . implode(", :", array_keys($veri));
    //sorguyu hazırlıyoruz
    $sorgu = $db->prepare("INSERT INTO $tablo ($tablolar) VALUES ($veriler)");

    //verileri ve keyleri bing'lere atıyoruz
    foreach ($veri as $ad => $bilgi) {
      $sorgu->bindValue(":$ad", $bilgi);
    }
    //sorguyu çalıştırıyoruz
    $sorgu->execute();
    //eklenen verinin id değeri istenmişse, geri döndürüyoruz
    if ($son_id == 1) {
      return $db->lastInsertId();
    }
  }

/**
* Bu fonksiyon ile silme işlemi yaparken Transaction işlemi de yapılmakta. 
* böylece silme işlemi sırasında sunucu da bir hata olması durumunda işlemi otomatik olarak geri almakta.
* 
*/
  public static function Delete($tablo, $param_id, $param)
  {
    global $db;
    $db->beginTransaction();
    $db->exec("DELETE FROM $tablo WHERE $param_id = '{$param}' ");
    $delete = $db->commit();

    if ($delete == true) {
      flash('success', 'Silme İşlemi Başarılı');
    } else {
      $db->rollBack();

    }
  }

}
