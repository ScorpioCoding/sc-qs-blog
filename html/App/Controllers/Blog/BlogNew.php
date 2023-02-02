<?php

namespace App\Controllers\Blog;

use App\Core\Controller;


use App\Models\Setup\mBlog;


/**
 *  BlogNew
 */
class BlogNew extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {
    $id = mBlog::createEmptyBlog();
    self::redirect('/blog/edit/' . $id);
  }

  protected function after()
  {
  }

  //END-Class
}