<?php

namespace App\Router;

use App\Controllers\ErrorController;
use App\Controllers\HostController;
use App\Controllers\PdfController;
use App\Controllers\UserController;

class Router
{
  public function get($page_name = '')
  {
    switch ($page_name) {
      case 'pdf':
        $controller = new PdfController;
        $controller->pdfPage();
        break;

      case 'login':
        $controller = new HostController;
        $controller->logIn();
        break;

      case 'logout':
        $controller = new HostController;
        $controller->logOut();
        break;

      case 'register':
        $controller = new UserController;
        $controller->register();
        break;

      case 'boo':
        $controller = new ErrorController;
        $controller->boo();
        break;

      default:
        $controller = new ErrorController;
        $controller->pageNotFound();
        break;
    }
  }
}
