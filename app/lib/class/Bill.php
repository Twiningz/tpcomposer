<?php

namespace App\Lib\Class;

use App\FPDF\FPDF;

class Bill extends Document
{

  protected $payment_at;
  protected $prefix = 'F';

  public function __construct($id)
  {
    parent::__construct($id, $this->prefix);
    $this->payment_at = date('d-m-y h:i:s');
  }

  public function generateDocument()
  {
    ob_end_clean();

    // Instantiate and use the FPDF class 
    $pdf = new FPDF();

    //Add a new page
    $pdf->AddPage();

    // Set the font for the text
    $pdf->SetFont('Arial', 'B', 18);

    // Prints a cell with given text 
    $pdf->Cell(60, 20, 'Hello Bill! Bill number : ' . $this->getNumero());

    // return the generated output
    return $pdf;
  }
}
