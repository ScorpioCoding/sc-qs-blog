<?php

namespace App\Controllers\Setup;

use App\Core\Controller;
use App\Core\View;
use App\Core\SessionMgr;

use App\Models\Setup\mSetup;
use App\Models\Setup\mUser;
use App\Models\Setup\mCompany;
use App\Models\Setup\mWebsite;

use App\Utils\Meta;
use App\Utils\Auth;



/**
 *  Setup
 */
class Company extends Controller
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
    //TODO GET META FROM DATABASE
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    // Extra data
    $data = array();
    $data['permission'] = (new SessionMgr())->get('permission');

    //1. test for connection
    $con = mSetup::testForConnection();
    //2. test for table
    $company = mSetup::testForTable('company');

    if ($company) {
      $res = mCompany::readAll();

      foreach ($res as $m) {
        foreach ($m as $key => $value) {
          $data[$key] = $value;
        }
      }
    }


    $args['template'] = 'Basic';
    View::render($args, $meta, $trans, $data);
  }

  public function infoAction($args = array())
  {
    if ($_POST) {
      mCompany::updateCompanyInfo($_POST);
      self::redirect('/setup/company');
    }
  }
  public function addressAction($args = array())
  {
    if ($_POST) {
      mCompany::updateCompanyAddress($_POST);
      self::redirect('/setup/company');
    }
  }


  protected function after()
  {
  }

  //END-Class
}