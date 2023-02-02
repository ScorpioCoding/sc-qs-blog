<?php


namespace App\Models\Setup;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mUser extends Database
{

  public function __construct()
  {
    parent::__construct();
  }


  public static function setTableUser()
  {
    $query = "CREATE TABLE IF NOT EXISTS `user`(
      id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(50) NOT NULL,
      email VARCHAR(255) NOT NULL,
      permission VARCHAR(50) NOT NULL,
      psw_hash VARCHAR(255) NOT NULL
    )";

    $dB = static::getDb();

    try {
      return $dB->exec($query);
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function createUser($args = array())
  {
    $password = password_hash($args['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO `user` (`id`, `name`, `email`, `permission`, `psw_hash`)
            VALUES (:id, :name, :email, :permission, :psw_hash)";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', null, PDO::PARAM_NULL);
    $stmt->bindValue(':name', $args['name'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $args['email'], PDO::PARAM_STR);
    $stmt->bindValue(':permission', $args['permission'], PDO::PARAM_STR);
    $stmt->bindValue(':psw_hash', $password, PDO::PARAM_STR);
    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function readBySuper()
  {
    $permission = 'super';
    $query = "SELECT * FROM `user` WHERE `permission` = :permission LIMIT 1";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->bindValue(':permission', $permission, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  public static function readById($id)
  {
    $query = "SELECT * FROM `user` WHERE `id` = :id LIMIT 1";
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

  public static function readByEmail($email)
  {
    $query = "SELECT * FROM `user` WHERE `email` = :email LIMIT 1";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->bindValue(':id', $email, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  public static function updateUser($args = array())
  {
    $password = password_hash($args['password'], PASSWORD_DEFAULT);

    $query = "UPDATE `user` SET 
    `name`=:name, `email`=:email, `permission`=:permission,`psw_hash`=:psw_hash
    WHERE `id` = :id";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', $args['id'], PDO::PARAM_int);
    $stmt->bindValue(':name', $args['name'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $args['email'], PDO::PARAM_STR);
    $stmt->bindValue(':permission', $args['permission'], PDO::PARAM_STR);
    $stmt->bindValue(':psw_hash', $password, PDO::PARAM_STR);

    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }



  public static function validate($args = array())
  {
    $errorList = array();

    if ($args['name'] == "")
      $errorList[] = "Administrative User Name is Required !";

    if (filter_var($args['email'], FILTER_VALIDATE_EMAIL) === false)
      $errorList[] = 'Administrative Email Invalid!';

    if ($args['password'] == "")
      $errorList[] = 'Administrative Password required !';

    if ($args['passwordconfirm'] == "")
      $errorList[] = 'Administrative Confirmation Password required !';

    if ($args['password'] !== $args['passwordconfirm'])
      $errorList[] = 'Administrative Confirmation Password must be the same as Password !';

    if (strlen($args['password']) < 6)
      $errorList[] = 'Password must be more than 6 characters!';

    if (preg_match('/.*[a-z]+.*/i', $args['password']) == 0)
      $errorList[] = 'Password needs at least one letter!';

    if (preg_match('/.*\d+.*/i', $args['password']) == 0)
      $errorList[] = 'Password needs at least one number!';

    return $errorList;
  }

  //
  //END CLASS
}