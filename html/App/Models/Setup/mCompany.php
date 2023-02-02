<?php


namespace App\Models\Setup;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mCompany extends Database
{
  public function __construct()
  {
    parent::__construct();
  }


  public static function setTableCompany()
  {
    $query = "CREATE TABLE IF NOT EXISTS `company`(
      id ENUM('') NOT NULL PRIMARY KEY,
      name VARCHAR(50),
      slogan VARCHAR(255),
      address VARCHAR(255),
      postal VARCHAR(50),
      city VARCHAR(255),
      state VARCHAR(255),
      country VARCHAR(255),
      email VARCHAR(255),
      phone VARCHAR(20),
      vat VARCHAR(20)
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

    $name = 'ScorpioCoding';
    $slogan = 'Design & Development';
    $address = 'Hanzestedenplaats 1';
    $postal = '2000';
    $city = 'Antwerp';
    $state = 'Antwerp';
    $country = 'Belgium';
    $email = 'info@fakedata.com';
    $phone = '+32 468 35 38 35';
    $vat = 'BE 0515.938.842';


    $query = "INSERT INTO `company` ( 
    `name`, `slogan`, `address`,`postal`, `city`, `state`,`country`,
    `email`,`phone`, `vat`)
    VALUES ( 
    :name, :slogan, :address, :postal, :city, :state, :country,
    :email, :phone, :vat)";


    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':slogan', $slogan, PDO::PARAM_STR);

    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':postal', $postal, PDO::PARAM_STR);
    $stmt->bindValue(':city', $city, PDO::PARAM_STR);
    $stmt->bindValue(':state', $state, PDO::PARAM_STR);
    $stmt->bindValue(':country', $country, PDO::PARAM_STR);

    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':vat', $vat, PDO::PARAM_STR);


    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      print_r($e);
      return false;
    }
  }


  public static function readAll()
  {
    $query = "SELECT * FROM `company`";
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

  public static function updateCompanyInfo($args = array())
  {
    $query = "UPDATE `company` SET 
    `name`=:name, `slogan`=:slogan, 
    `email`=:email,`phone`=:phone, `vat`=:vat ";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':name', $args['name'], PDO::PARAM_STR);
    $stmt->bindValue(':slogan', $args['slogan'], PDO::PARAM_STR);

    $stmt->bindValue(':email', $args['email'], PDO::PARAM_STR);
    $stmt->bindValue(':phone', $args['phone'], PDO::PARAM_STR);
    $stmt->bindValue(':vat', $args['vat'], PDO::PARAM_STR);

    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }


  public static function updateCompanyAddress($args = array())
  {
    $query = "UPDATE `company` SET 
    `address`=:address, `postal`=:postal, `city`=:city,
    `state`=:state, `country`=:country ";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':address', $args['address'], PDO::PARAM_STR);
    $stmt->bindValue(':postal', $args['postal'], PDO::PARAM_STR);
    $stmt->bindValue(':city', $args['city'], PDO::PARAM_STR);
    $stmt->bindValue(':state', $args['state'], PDO::PARAM_STR);
    $stmt->bindValue(':country', $args['country'], PDO::PARAM_STR);

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