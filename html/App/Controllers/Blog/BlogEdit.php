<?php

namespace App\Controllers\Blog;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\SessionMgr;

use App\Utils\Meta;
use App\Utils\Auth;

use App\Models\Setup\mBlog;

use App\Vendor\Parsedown\Parsedown;


/**
 *  Admin
 */
class BlogEdit extends Controller
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
    $data['permission'] = (new SessionMgr())->get('permission');;

    $res = mBlog::readById($args['id']);
    foreach ($res as $m) {
      foreach ($m as $key => $value) {
        $data[$key] = $value;
      }
    }

    if ($_POST) {
      // echo '<pre>';
      // print_r($_POST);
      // echo '</pre>';
      mBlog::updateBlog($_POST);
      foreach ($_POST as $key => $value) {
        $data[$key] = $value;
      }
    }
    $data['output'] = (new Parsedown())->text($data['content']);



    $args['template'] = 'Basic';
    View::render($args, $meta, $trans, $data);
  }

  protected function after()
  {
  }

  //END-Class
}