<?php

namespace App\Controllers;

use App\Lib\Class\Bill;
use App\Lib\Class\Quote;
use App\Models\UserModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

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
    $action = isset($_POST['action']) && !empty($_POST['action']) ? $_POST['action'] : "";

    if ($action == "edit_pdf") {
      $type = $_POST['type'];
      $this->editPdf($type);
    }

    if ($action == "send_mail") {
      $type = $_POST['type'];
      $this->sendMail($type);
    }

    require($_SERVER['DOCUMENT_ROOT'] . '/app/views/pdf.php');
  }

  public function getObject($class)
  {
    $object = false;
    if ($class == 'Bill') {
      $object = new Bill(1);
    } elseif ($class == 'Quote') {
      $object = new Quote(1);
    }
    return $object;
  }

  public function editPdf($type)
  {
    $object = $this->getObject(ucfirst($type));
    if ($object != false && isset($object)) {
      $object->getGeneratedDocument();
    }
  }

  public function getPdf($type)
  {
    $object = $this->getObject(ucfirst($type));
    if ($object != false && isset($object)) {
      return $object->generateDocument();
    }
  }

  public function uploadTempPdf($type, $path)
  {
    $object = $this->getObject(ucfirst($type));
    if ($object != false && isset($object)) {
      return $object->uploadTemp($path);
    }
  }

  public function deleteTempPdf($path)
  {
    if (file_exists($path)) {
      unlink($path);
      return true;
    }
    return false;
  }

  public function sendMail($type)
  {

    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

    // configuration SMTP (mailDev,here)
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->Port = 1025;

    //From email address and name
    $mail->From = "from@yourdomain.com";
    $mail->FromName = "Full Name";

    //To address and name
    $mail->addAddress("recepient1@example.com", "Recepient Name");

    //Address to which recipient will reply
    $mail->addReplyTo("reply@yourdomain.com", "Reply");

    //CC and BCC
    $mail->addCC("cc@example.com");
    $mail->addBCC("bcc@example.com");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Subject Text";
    $mail->Body = "<i>Mail body in HTML</i>";
    $mail->AltBody = "This is the plain text version of the email content";


    //*************/
    if (!empty($type)) {
      $repository = $_SERVER['DOCUMENT_ROOT'] . '/app/documents';
      if (!file_exists($repository)) mkdir($repository, 0777, true);
      $path = $repository . '/temp_' . $type . '.pdf';
      $this->uploadTempPdf($type, $path);

      $mail->Body .= 'addattachment : ' . $mail->AddAttachment($path, 'nom de pdf');
      $mail->Body .= '$path : ' . $path;
    }
    //*************/

    try {
      $mail->send();

      if (isset($path) && !empty($path)) $this->deleteTempPdf($path);

      $_SESSION['flash_message'] = '<p class="text-success">Your message has been sent successfully';
    } catch (PHPMailerException $e) {
      $_SESSION['flash_message'] = '<p class="text-danger">An error occured while sending your message <span class="fw-bold">Mailer Error: ' . $mail->ErrorInfo . '</span></p>';
    }
  }
}
