<?php

namespace App\Controllers\Blog;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\SessionMgr;

use App\Utils\Meta;
use App\Utils\Auth;

use App\Models\Setup\mBlog;


/**
 *  BlogList
 */
class BlogList extends Controller
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

    $draft = mBlog::readByStatus('draft');
    $publish = mBlog::readByStatus('publish');

    if ($draft) echo 'draft found';

    foreach ($draft as $key => $value) {

      $data['draft'][$key] = $value;
    }

    foreach ($publish as $key => $value) {

      $data['publish'][$key] = $value;
    }



    $args['template'] = 'Basic';
    View::render($args, $meta, $trans, $data);
  }

  protected function after()
  {
  }

  //END-Class
}