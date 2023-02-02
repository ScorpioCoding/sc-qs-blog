<?php

namespace App\Controllers\Blog;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\SessionMgr;
use App\Models\Setup\mGallery;
use App\Utils\Meta;
use App\Utils\Auth;



/**
 *  BlogGallery
 */
class BlogGallery extends Controller
{
  protected function before()
  {
    if (!Auth::sessionValide())
      self::redirect('/login');
  }

  public function indexAction($args = array())
  {
    //MetaData
    $meta = array();
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    //$trans = Translation::translate($args);
    // Extra data
    $data = array();
    $flash = array();

    if (isset($args['flash'])) {
      if ($args['flash'] === 'success') {
        $data['flash'][] = 'File Uploaded Successfully';
      }
      if ($args['flash'] === 'emptyfields') {
        $data['flash'][] = 'File upload Failed : Title, Description Required!';
      }
      if ($args['flash'] === 'moveuploadfaild') {
        $data['flash'][] = 'File upload Failed : Move from temp failed!';
      }
      if ($args['flash'] === 'uploadtodbfailed') {
        $data['flash'][] = 'File upload Failed : Image failed to upload to database!';
      }
      if ($args['flash'] === 'filesizetobig') {
        $data['flash'][] = 'File upload Failed : File size is to Big!';
      }
      if ($args['flash'] === 'error') {
        $data['flash'][] = 'File upload Failed : An error occurred!';
      }
      if ($args['flash'] === 'fileextension') {
        $data['flash'][] = 'File upload Failed : Invalid File Extension !';
      }
    }



    $res = mGallery::readAll();
    foreach ($res as $key => $value) {
      $data['gallery'][$key] = $value;
    }

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';



    $args['template'] = 'Basic';
    View::render($args, $meta, $trans, $data);
  }

  public function uploadAction($args = array())
  {
    // echo 'here gallery upload';

    if (isset($_POST['submit'])) {
      $newFileName = $_POST['name'];
      if (empty($_POST['name'])) {
        $newFileName = "gallery";  //add random id to the name
      } else {
        $newFileName = strtolower(str_replace(" ", "-", $newFileName));
      }
      $imageTitle = $_POST['title'];
      $imageDescription = $_POST['description'];

      $file = $_FILES['file'];
      $fileName = $_FILES['file']['name'];
      $fileType = $_FILES['file']['type'];
      $fileTempName = $_FILES['file']['tmp_name'];
      $fileError = $_FILES['file']['error'];
      $fileSize = $_FILES['file']['size'];

      echo '<pre>';
      print_r($fileTempName);
      echo '</pre>';

      $fileExt = explode(".", $fileName); //explode creates an array per "."
      $fileActualExt = strtolower(end($fileExt)); //end gets the last key of an array which is the extension

      $allowed = array('jpg', 'jpeg', 'png', 'gif');

      if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
          if ($fileSize <= 2000000) {
            $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
            $fileDestination = PATH_ROOT . "uploads" . $imageFullName;
            $fileTemp = PATH_TEMP . $fileTempName;

            //echo $fileTemp;
            //INSERT INTO DATABASE 
            //IF UPLOAD INTO DB WAS SUCCESS THEN UPLOAD TO FILE PATH
            if (empty($imageTitle) || empty($imageDescription)) {
              self::redirect('/gallery/index/emptyfields');
              exit();
            } else {
              $args['title'] = $imageTitle;
              $args['description'] = $imageDescription;
              $args['name'] = $imageFullName;
              $args['url'] = $fileDestination;
              if (mGallery::createImage($args)) {
                if (copy($fileTemp, $fileDestination)) {
                  self::redirect('/gallery/index/success');
                  exit();
                } else {
                  self::redirect('/gallery/index/moveuploadfaild');
                  exit();
                }
              } else {
                self::redirect('/gallery/index/uploadtodbfailed');
                exit();
              }
            }
          } else {
            self::redirect('/gallery/index/filesizetobig');
            exit();
          }
        } else {
          self::redirect('/gallery/index/error');
          exit();
        }
      } else {
        self::redirect('/gallery/index/fileextension');
        exit();
      }
    }
  }

  protected function after()
  {
  }

  //END-Class
}