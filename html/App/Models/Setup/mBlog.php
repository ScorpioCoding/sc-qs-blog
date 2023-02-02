<?php


namespace App\Models\Setup;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mBlog extends Database
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function setTableBlog()
  {
    $query = "CREATE TABLE IF NOT EXISTS blog (
        id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
        status VARCHAR(50), 
        author VARCHAR(100),
        image_author VARCHAR(255),
        date_at VARCHAR(50),
        title VARCHAR(255),
        slug VARCHAR(255),
        image_landscape VARCHAR(255),
        image_portrait VARCHAR(255),
        description TEXT,
        content TEXT
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
    $args['status'] = 'draft';
    $args['author'] = 'denOldTimer ';
    $args['image_author'] = 'https://avatars.githubusercontent.com/u/51490799?v=4';
    $args['date_at'] = '2023 Januari 27';
    $args['title'] = 'My First Post';
    $args['slug'] = 'my-first-post';
    $args['image_landscape'] = 'https://picsum.photos/350/250';
    $args['image_portrait'] = 'https://picsum.photos/250/350';
    $args['description'] = 'This is my first post and it is all about fake data';
    $args['content'] = 'This is my first attempt at getting this done and it is looking like shit crazy is going to happen.
    I get it to work and I wonder what I doing wrong.';

    self::createBlog($args);
  }

  public static function createBlog(array $args)
  {
    $query = "INSERT INTO `blog` ( `id`, `status`, `author`,`image_author`, `date_at`, `title`,`slug`,
      `image_landscape`,`image_portrait`, `description`, `content`)
    VALUES ( :id, :status, :author, :image_author, :date_at, :title, :slug, :image_landscape, :image_portrait, :description, :content)";


    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', NULL, PDO::PARAM_NULL);
    $stmt->bindValue(':status', $args['status'], PDO::PARAM_STR);

    $stmt->bindValue(':author', $args['author'], PDO::PARAM_STR);
    $stmt->bindValue(':image_author', $args['image_author'], PDO::PARAM_STR);
    $stmt->bindValue(':date_at', $args['date_at'], PDO::PARAM_STR);
    $stmt->bindValue(':title', $args['title'], PDO::PARAM_STR);
    $stmt->bindValue(':slug', $args['slug'], PDO::PARAM_STR);

    $stmt->bindValue(':image_landscape', $args['image_landscape'], PDO::PARAM_STR);
    $stmt->bindValue(':image_portrait', $args['image_portrait'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $args['description'], PDO::PARAM_LOB);
    $stmt->bindValue(':content', $args['content'], PDO::PARAM_LOB);


    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function createEmptyBlog()
  {
    $date =  date('d M Y');
    $status = 'draft';

    $query = "INSERT INTO `blog` ( `id`, `date_at`, `status`)
    VALUES ( :id, :date_at, :status)";


    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', NULL, PDO::PARAM_NULL);
    $stmt->bindValue(':date_at', $date, PDO::PARAM_STR);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);

    try {
      $stmt->execute();
      return $dB->lastInsertId();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }


  public static function readAll()
  {
    $query = "SELECT * FROM `blog`";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
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
    $query = "SELECT * FROM `blog` WHERE `id` = :id LIMIT 1";
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

  public static function readByStatus($status)
  {
    $status = strtolower($status);
    $query = "SELECT `id`,`title` FROM `blog` WHERE `status` = :status";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  public static function readBySlug(string $slug)
  {
    $query = "SELECT * FROM `blog` WHERE `slug` = :slug LIMIT 1";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  public static function updateBlog(array $args)
  {
    $date = date('d M Y');

    $query = "UPDATE `blog` SET 
    `status`=:status, `author`=:author, `image_author`=:image_author,`date_at`=:date_at, `title`=:title, `slug`=:slug, `image_landscape`=:image_landscape, `image_portrait`=:image_portrait, `description`=:description, `content`=:content
    WHERE `id`=:id ";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', $args['id'], PDO::PARAM_INT);
    $stmt->bindValue(':status', $args['status'], PDO::PARAM_STR);

    $stmt->bindValue(':author', $args['author'], PDO::PARAM_STR);
    $stmt->bindValue(':image_author', $args['image_author'], PDO::PARAM_STR);
    $stmt->bindValue(':date_at', $date, PDO::PARAM_STR);
    $stmt->bindValue(':title', $args['title'], PDO::PARAM_STR);
    $stmt->bindValue(':slug', $args['slug'], PDO::PARAM_STR);

    $stmt->bindValue(':image_landscape', $args['image_landscape'], PDO::PARAM_STR);
    $stmt->bindValue(':image_portrait', $args['image_portrait'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $args['description'], PDO::PARAM_LOB);
    $stmt->bindValue(':content', $args['content'], PDO::PARAM_LOB);

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