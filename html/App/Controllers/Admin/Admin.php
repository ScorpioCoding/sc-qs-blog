<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\SessionMgr;

use App\Utils\Meta;
use App\Utils\Auth;


/**
 *  Admin
 */
class Admin extends Controller
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
    $trans = Translation::translate($args);
    // Extra data
    $data = array();

    $data['permission'] = (new SessionMgr())->get('permission');







    $args['template'] = 'Backend';
    View::render($args, $meta, $trans, $data);
  }

  protected function after()
  {
  }

  //END-Class
}