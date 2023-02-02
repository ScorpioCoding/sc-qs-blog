<?php


namespace App\Models\Setup;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mGallery extends Database
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function setTableGallery()
  {
    $query = "CREATE TABLE IF NOT EXISTS `gallery` (
        id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
        title LONGTEXT NOT NULL,
        description LONGTEXT NOT NULL,
        name LONGTEXT NOT NULL,
        url LONGTEXT NOT NULL
    )";

    $dB = static::getDb();

    try {
      return $dB->exec($query);
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function createImage(array $args)
  {
    $query = "INSERT INTO `gallery` ( `id`, `title`, `description`, `name`, `url`)
    VALUES ( :id, :title, :description, :name, :url)";


    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', NULL, PDO::PARAM_NULL);
    $stmt->bindValue(':title', $args['title'], PDO::PARAM_LOB);
    $stmt->bindValue(':description', $args['description'], PDO::PARAM_LOB);
    $stmt->bindValue(':name', $args['name'], PDO::PARAM_LOB);
    $stmt->bindValue(':url', $args['url'], PDO::PARAM_LOB);


    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      print_r($e);
      return false;
    }
  }




  public static function readAll()
  {
    $query = "SELECT * FROM `gallery`";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      print_r($e);
      return false;
    }
  }

  public static function readById($id)
  {
    $query = "SELECT * FROM `gallery` WHERE `id` = :id LIMIT 1";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }











  //
  //END CLASS
}