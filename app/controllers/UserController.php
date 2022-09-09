<?php

namespace App\Controllers;

class UserController
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

  public function register()
  {

    if (isset($_POST['form_registration'])) {

      //! initialitse error count/message
      $errorCount = 0;
      $errorMessage = '';

      //!Check if required fields have been filled
      if (
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['pass']) && !empty($_POST['pass']) &&
        isset($_POST['confirm_pass']) && !empty($_POST['confirm_pass']) &&
        isset($_POST['name']) && !empty($_POST['name']) &&
        isset($_POST['surname']) && !empty($_POST['surname'])
      ) {

        //!Retrieve values
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $confirm_pass = $_POST['confirm_pass'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        $mailCount = $this->user_model->countMailInTable($email);
        //If no existing mail where found, next
        if ($mailCount['NBemail'] > 0) {
          $errorCount++;
          $errorMessage .= "This email address is already being used.</br>";
        }

        // Check mail form...
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
          $errorCount++;
          $errorMessage .= "Please enter a correct mail address.</br>";
        }

        //Check password inputs match
        if ($pass != $confirm_pass) {
          $errorCount++;
          $errorMessage .= "Careful, passwords didn't match !</br>";
        }

        //if no errors were found, insertion
        if ($errorCount == 0) {
          //-------------INSERTION---------
          $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

          try {
            $this->user_model->addUser(
              htmlspecialchars($email),
              $pass_hashed,
              htmlspecialchars($name),
              htmlspecialchars($surname)
            );
            echo "<p> GG, done ! </br></p>";
          } catch (\Exception $e) {
            die('Error : ' . $e->getMessage());
          }
        }
      } else {
        $errorMessage .= "Please fill in all the required fields";
      }
    }

    require($_SERVER['DOCUMENT_ROOT'] . '/views/register.php');
  }
}
