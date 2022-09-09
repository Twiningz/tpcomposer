<?php

namespace App\Controllers;

class ErrorController
{

  public function pageNotFound()
  {
    echo '<pre>You`\'ve met with a terrible fate haven\'t you ?</pre>';
    header("refresh:3;/index.php?page=boo");
    exit();
  }

  public function boo()
  {
    echo 'BOOGA BOOGA';
    header("refresh:3;/index.php?page=register");
    exit();
  }
}
