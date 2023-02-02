<?php


namespace App\Models\Setup;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mWebsite extends Database
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function setTableWebsite()
  {
    $query = "CREATE table `website`(
      id ENUM('') NOT NULL PRIMARY KEY,
      domain VARCHAR(100),
      url VARCHAR(255),
      image VARCHAR(255)
    )";

    $dB = static::getDb();

    try {
      return $dB->exec($query);
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }


  public static function setFakeData()
  {
    $domain = 'yourcompany.com';
    $url = 'https://yourcompany.com';
    $image = 'https://yourcompany.com/img/banner.png';

    $query = "INSERT INTO `website` (`domain`, `url`, `image` )
    VALUES (:domain, :url, :image)";


    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':domain', $domain, PDO::PARAM_STR);
    $stmt->bindValue(':url', $url, PDO::PARAM_STR);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);


    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      print_r($e);
      return false;
    }
  }


  public static function readAll()
  {
    $query = "SELECT * FROM `website`";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      print_r($e->getMessage());
      return false;
    }
  }

  public static function updateWebsiteInfo($args = array())
  {
    $query = "UPDATE `website` SET 
    `domain`=:domain, `url`=:url, `image`=:image ";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':domain', $args['domain'], PDO::PARAM_STR);
    $stmt->bindValue(':url', $args['url'], PDO::PARAM_STR);
    $stmt->bindValue(':image', $args['image'], PDO::PARAM_STR);

    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      print_r($e);
      return false;
    }
  }

  //
  //END CLASS
}