<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Core\View;
use App\Core\SessionMgr;

use App\Utils\Meta;
use App\Utils\Auth;

use App\Models\User\mLogin;


/**
 *  Login
 */
class Login extends Controller
{
  protected function before()
  {
    if (Auth::sessionValide())
      self::redirect('/admin');
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


    if ($_POST) {

      $data['errorList'] = mLogin::validate($_POST);

      if (empty($data['errorList'])) {
        $user = mLogin::authenticate($_POST);
        if ($user) {
          if (Auth::sessionUp($user))
            self::redirect('/admin');
        }
      }
    }




    $args['template'] = 'Basic';
    View::render($args, $meta, $trans, $data);
  }


  protected function after()
  {
  }

  //END-Class
}