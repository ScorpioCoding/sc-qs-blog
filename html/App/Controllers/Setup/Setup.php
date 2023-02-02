<?php

namespace App\Controllers\Setup;

use App\Core\Controller;
use App\Core\View;

use App\Models\Setup\mSetup;
use App\Models\Setup\mUser;
use App\Models\Setup\mCompany;
use App\Models\Setup\mWebsite;
use App\Models\Setup\mBlog;
use App\Models\Setup\mGallery;

use App\Utils\Meta;
use App\Utils\Auth;



/**
 *  Setup
 */
class Setup extends Controller
{
  protected function before()
  {
    if (Auth::sessionValide())
      self::redirect('/login');
  }

  public function indexAction($args = array())
  {
    //MetaData
    $meta = array();
    //TODO GET META FROM DATABASE
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    // Extra data
    $data = array();

    //1. test for connection
    $con = mSetup::testForConnection();
    //2. test for user table
    $user = mSetup::testForTable('user');
    $company = mSetup::testForTable('company');
    $website = mSetup::testForTable('website');
    $blog = mSetup::testForTable('blog');
    $gallery = mSetup::testForTable('gallery');

    //3. read from user table where super
    if ($user) {
      $res = mUser::readBySuper();
      if (empty($res)) {
        //4. Need to create user
        $data['readonly'] = false;
      } else {
        self::redirect('/login');
        exit();
      }
    }

    if ($company) {
      $res = mCompany::readAll();
      if (empty($res)) {
        mCompany::setFakeData();
      }
    } else {
      if (mCompany::setTableCompany())
        mCompany::setFakeData();
    }

    if ($website) {
      $res = mWebsite::readAll();
      if (empty($res)) {
        mWebsite::setFakeData();
      }
    } else {
      if (mWebsite::setTableWebsite())
        mWebsite::setFakeData();
    }


    if ($blog) {
      $res = mBlog::readAll();
      if (empty($res)) {
        mBlog::setFakeData();
      }
    } else {
      if (mBlog::setTableBlog())
        mBlog::setFakeData();
    }

    if (!$gallery)
      mGallery::setTableGallery();







    if ($_POST) {
      $data['errorList'] = mUser::validate($_POST);
      if (empty($data['errorList'])) {
        mUser::createUser($_POST);
        self::redirect('/login');
      }
      if (!empty($data['errorList'])) {
        foreach ($_POST as $key => $value) {
          $data[$key] = $value;
        }
      }
    }


    $args['template'] = 'Basic';
    View::render($args, $meta, $trans, $data);
  }


  public function phpAction($args = array())
  {
    phpinfo();
  }

  public function selectAction($args = array())
  {
    //If super user not created then goto create super else goto login
    $con = mSetup::testForConnection();
    $user = mSetup::testForTable('user');
    if ($user) {
      $res = mUser::readBySuper();
      if (empty($res)) {
        self::redirect('/setup');
      } else {
        self::redirect('/login');
      }
    }
  }
  protected function after()
  {
  }

  //END-Class
}