<?php


namespace App\Models\Setup;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mSetup extends Database
{

  public function __construct()
  {
    parent::__construct();
  }

  public static function testForConnection()
  {
    $rtn = false;
    try {
      if ($db = self::getdB()) {
        $rtn = true;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $rtn;
  }

  public static function testForTable($table)
  {
    $rtn = false;
    $query = "SELECT 1 FROM `$table` LIMIT 1";
    $dB = self::getdb();
    $stmt = $dB->prepare($query);
    try {
      $rtn = $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $rtn;
  }

  //
  //END CLASS
}