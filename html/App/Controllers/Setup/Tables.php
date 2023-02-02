<?php

namespace App\Controllers\Setup;

use App\Core\Controller;
use App\Core\View;
use App\Core\SessionMgr;

use App\Models\Setup\mSetup;
use App\Models\Setup\mUser;
use App\Models\Setup\mCompany;
use App\Models\Setup\mWebsite;
use App\Models\Setup\mBlog;

use App\Utils\Meta;
use App\Utils\Auth;



/**
 *  Tables
 */
class Tables extends Controller
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



    $args['template'] = 'Basic';
    View::render($args, $meta, $trans, $data);
  }

  public function blogAction($args = array())
  {
    if ($_POST) {
      if (mBlog::setTableBlog())
        mBlog::setFakeData();
      self::redirect('/setup/tables');
    }
  }



  protected function after()
  {
  }

  //END-Class
}