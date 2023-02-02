<?php

return (object) array(



  '/blog/list'   => ['lang' => 'en', 'module' => 'Blog', 'namespace' => 'App\Controllers\Blog', 'controller' => 'BlogList', 'action' => 'index'],

  '/blog/new'   => ['lang' => 'en', 'module' => 'Blog', 'namespace' => 'App\Controllers\Blog', 'controller' => 'BlogNew', 'action' => 'index'],

  '/blog/delete/{id:\d+}'   => ['lang' => 'en', 'module' => 'Blog', 'namespace' => 'App\Controllers\Blog', 'controller' => 'BlogDelete', 'action' => 'index'],

  '/blog/edit/{id:\d+}'   => ['lang' => 'en', 'module' => 'Blog', 'namespace' => 'App\Controllers\Blog', 'controller' => 'BlogEdit', 'action' => 'index'],


  '/gallery'   => ['lang' => 'en', 'module' => 'Blog', 'namespace' => 'App\Controllers\Blog', 'controller' => 'BlogGallery', 'action' => 'index'],

  '/gallery/index/{flash}'   => ['lang' => 'en', 'module' => 'Blog', 'namespace' => 'App\Controllers\Blog', 'controller' => 'BlogGallery', 'action' => 'index'],

  '/gallery/upload'   => ['lang' => 'en', 'module' => 'Blog', 'namespace' => 'App\Controllers\Blog', 'controller' => 'BlogGallery', 'action' => 'upload'],







);