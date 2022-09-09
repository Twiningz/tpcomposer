<?php
//phpinfo();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use App\Router\Router;

$router = new Router;

if (isset($_GET['page']) && !empty($_GET['page'])) {
  $router->get($_GET['page']);
} else {
  $router->get('register');
}
