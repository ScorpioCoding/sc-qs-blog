<?php


namespace App\Models\User;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mLogin extends Database
{

  public function __construct()
  {
    parent::__construct();
  }

  public static function authenticate($args = array())
  {
    $user = static::readByEmail($args['email']);

    if ($user) {
      if (password_verify($args['password'], $user->psw_hash)) {
        return $user;
      }
    }
    return false;
  }

  public static function validate($args = array())
  {
    $errorList = array();
    //Email address
    if (filter_var($args['email'], FILTER_VALIDATE_EMAIL) === false)
      $errorList[] = 'Invalid Credentials!';

    if (!self::emailExists($args['email']))
      $errorList[] = 'Invalid Credentials!';

    //Password    
    if (strlen($args['password']) < 6)
      $errorList[] = 'Invalid Credentials!';

    if (preg_match('/.*[a-z]+.*/i', $args['password']) == 0)
      $errorList[] = 'Invalid Credentials!';

    if (preg_match('/.*\d+.*/i', $args['password']) == 0)
      $errorList[] = 'Invalid Credentials!';

    return $errorList;
  }



  public static function emailExists($email)
  {
    return static::readByEmail($email) !== false;
  }

  public static function readByEmail($email)
  {
    $query = "SELECT * FROM `user` WHERE email = :email";

    $dB = static::getdb();

    $stmt = $dB->prepare($query);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    $stmt->execute();
    return $stmt->fetch();
  }


  //
  //END CLASS
}