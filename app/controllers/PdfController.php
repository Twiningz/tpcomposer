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

  /**
   * displaying page to edit pdf / send pdf mail
   * 
   */
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

  /**
   * getting an object based on a class
   * 
   * @param string $class
   * @return bool|object false if failure, object if success
   */
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

  /**
   * Edit a pdf and send it to the navigator
   * 
   * @param string $type, type of a required pdf
   * @return bool|int false if failure, 1 if success
   */
  public function editPdf($type)
  {
    $object = $this->getObject(ucfirst($type));
    if ($object != false && isset($object)) {
      return $object->getGeneratedDocument();
    }
    return false;
  }

  /**
   * gets a pdf based on a type
   * 
   * @param string $type, type of a required pdf
   * @return bool|int false if failure, 1 if success
   */
  public function getPdf($type)
  {
    $object = $this->getObject(ucfirst($type));
    if ($object != false && isset($object)) {
      return $object->generateDocument();
    }
    return false;
  }

  /**
   * Uploads a temp pdf file on the server
   * 
   * @param string $type, type of a required pdf
   * @param string $path, path where to upload the file
   * @return bool false if failure, true if success
   */
  public function uploadTempPdf($type, $path)
  {
    $object = $this->getObject(ucfirst($type));
    if ($object != false && isset($object)) {
      return $object->uploadTemp($path);
    }
  }

  /**
   * delete a file on the server
   * 
   * @param string $type, type of a required pdf
   * @return bool false if failure, true if success
   */
  public function deleteFile($path)
  {
    if (file_exists($path)) {
      unlink($path);
      return true;
    }
    return false;
  }

  /**
   * Sends a mail
   * 
   * @param string $type, type of a required pdf
   * @param string $content, mail content
   * @param string $header, mail header
   * @param string $footer, mail footer
   */
  public function sendMail($type = '', $content = '', $header = '', $footer = '')
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

      if (isset($path) && !empty($path)) $this->deleteFile($path);

      $_SESSION['flash_message'] = '<p class="text-success">Your message has been sent successfully';
    } catch (PHPMailerException $e) {
      $_SESSION['flash_message'] = '<p class="text-danger">An error occured while sending your message <span class="fw-bold">Mailer Error: ' . $mail->ErrorInfo . '</span></p>';
    }
  }
}
