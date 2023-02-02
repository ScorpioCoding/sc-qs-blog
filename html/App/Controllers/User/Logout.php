<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Core\View;
use App\Core\SessionMgr;

use App\Utils\Meta;

use App\Models\Login\mLogin;


/**
 *  Logout
 */
class Logout extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {

    $session = new SessionMgr();
    $session->remove('auth');
    $session->remove('username');
    $session->remove('email');
    $session->remove('permission');
    $session->clear();
    $session->destroy();


    self::redirect('/login');
  }


  protected function after()
  {
  }

  //END-Class
}