<?php

namespace App\Lib\Class;

use App\Lib\Interface\PdfableInterface;

abstract class Document implements PdfableInterface
{

  protected $id;
  protected $numero;
  protected $created_at;
  protected $prefix = '';

  public function __construct($id)
  {
    $this->id = $id;
    $this->numero = $this->setNumero();
    $this->created_at = date('d-m-y h:i:s');
  }

  public function setNumero()
  {
    if (!empty($this->prefix)) {
      $this->prefix = $this->prefix . '_';
    } else {
      $this->prefix = $this instanceof Quote ? 'D_' : 'F_';
    }

    $int_prefix = '';
    $num_length = strlen((string)$this->id);
    switch ($num_length) {
      case 1:
        $int_prefix = '0000';
        break;

      case 2:
        $int_prefix = '000';
        break;

      case 3:
        $int_prefix = '00';
        break;

      case 4:
        $int_prefix = '0';
        break;

      default:
        break;
    }

    $numero = $this->prefix . $int_prefix . $this->id;
    return $numero;
  }

  public function getNumero()
  {
    return $this->numero;
  }

  public function getGeneratedDocument()
  {
    ob_end_clean();
    $pdf = $this->generateDocument();
    $pdf->Output('I');
  }

  public function uploadTemp($path)
  {
    ob_end_clean();

    //Add a new page
    $pdf = $this->generateDocument();

    // return the generated output
    $pdf->Output($path, 'F');
  }
}
