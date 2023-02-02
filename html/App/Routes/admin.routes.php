<?php

return (object) array(



  '/admin'   => ['lang' => 'en', 'module' => 'Admin', 'namespace' => 'App\Controllers\Admin', 'controller' => 'Admin', 'action' => 'index'],

  '/{lang}/admin'   => ['module' => 'Admin', 'namespace' => 'App\Controllers\Admin', 'controller' => 'Admin', 'action' => 'index'],





);