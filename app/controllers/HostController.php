<?php

namespace App\Controllers;

use App\Lib\UserModel;

class HostController
{

  protected $user_model;

  public function __construct()
  {
    try {
      $this->user_model = new UserModel;
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function logIn()
  {

    if (isset($_POST['form_connexion'])) {

      //! initialitse error count/message
      $errorCount = 0;
      $errorMessage = '';

      //!checking if all field have been filled
      if (
        isset($_POST['mail_connect']) && !empty($_POST['mail_connect']) &&
        isset($_POST['pass_connect']) && !empty($_POST['pass_connect'])
      ) {
        //!Retrieve values
        $email = $_POST['mail_connect'];
        $password = $_POST['pass_connect'];

        $user = $this->user_model->getUserByMail($email);

        //if the mail didn't exist, fetch returns a false value
        if ($user == false) {
          $errorCount++;
          $errorMessage = "wrong password and/or email address";
        } else {
          $verif = password_verify($password, $user['password']);
          if ($verif == false) {
            $errorCount++;
            $errorMessage = "wrong password and/or email address";
          } else {
            try {
              $flash_message = '<p class="text-success">You are now loged in !</br></p>';

              //!Setting user's session
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['email'] = $user['email'];
              $_SESSION['name'] = $user['name'];
              $_SESSION['surname'] = $user['surname'];
              $_SESSION['flash_message'] = $flash_message;

              //!Setting user's navigator's cookies, yum yum
              $cookiesExpiration = time() + 60 * 5;
              setcookie(
                'email',
                $_SESSION['email'],
                [
                  'path' => '/',
                  'expires' => $cookiesExpiration,
                  'secure' => false,
                  'httponly' => true
                ]
              );

              header("Location: /index.php?page=pdf");
              exit;
            } catch (\Exception $e) {
              die('Error : ' . $e->getMessage());
            }
          }
        }
      } else {
        $errorMessage = "Fill in all the fields";
      }
    }

    require($_SERVER['DOCUMENT_ROOT'] . '/views/login.php');
  }

  public function logOut()
  {
    //Logout
    //$_SESSION = array('ID', 'pseudo');
    setcookie("email", "", time() - 3600);
    session_unset();
    session_destroy();
    session_start();

    $flash_message = '<p class="text-warning">You are now logged out !</br></p>';
    $_SESSION['flash_message'] = $flash_message;
    header("Location: /index.php?page=login");
    exit;

    require($_SERVER['DOCUMENT_ROOT'] . '/views/login.php');
  }
}
