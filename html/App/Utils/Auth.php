<?php

namespace App\Utils;

use App\Core\SessionMgr;

class Auth
{

  public static function sessionUp($user)
  {
    if ($user) {
      $session = new SessionMgr();
      $session->set('auth', 'true');
      $session->set('username', $user->name);
      $session->set('email', $user->email);
      $session->set('permission', $user->permission);
      $session->set('created', time());
      return true;
      exit;
    }
    return false;
  }

  public static function sessionValide()
  {
    $session = new SessionMgr();
    $created = $session->get('created');
    if (!isset($created)) {
      return false;
      exit;
    }

    if (time() - $created > 1800) {
      session_regenerate_id(true);
      return false;
      exit;
    }

    $auth = $session->get('auth');
    if (!isset($auth) || $auth == false) {
      return false;
      exit;
    }

    return true;
  }


  //
  //END CLASS
}