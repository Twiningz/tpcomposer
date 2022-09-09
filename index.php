<?php
//phpinfo();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
/* require_once 'fpdf/fpdf.php';
require_once 'PdfableInterface.php';
require_once 'Document.php';
require_once 'Bill.php';
require_once 'Quote.php'; */

/* require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/Router.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/pdfController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/UserController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/HostController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/ErrorController.php'); */

$router = new Router;

if (isset($_GET['page']) && !empty($_GET['page'])) {
  $router->get($_GET['page']);
} else {
  $router->get('register');
}
