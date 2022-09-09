<?php

namespace App\Controllers;

use App\Lib\Class\Bill;
use App\Lib\Class\Quote;
use App\Models\UserModel;

class PdfController
{
  protected $user_model;

  function __construct()
  {
    try {
      $this->user_model = new UserModel;
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function pdfPage()
  {
    require($_SERVER['DOCUMENT_ROOT'] . '/app/views/pdf.php');
  }

  public function editPdf()
  {
    if (isset($_POST['edit_pdf'])) {

      $type = $_POST['type'];

      if ($type == 'bill') {
        $object = new Bill(2);
      } elseif ($type == 'quote') {
        $object = new Quote(1);
      }

      if (isset($object)) $object->getGenerate();
    }


    require($_SERVER['DOCUMENT_ROOT'] . '/app/views/pdf.php');
  }
}
