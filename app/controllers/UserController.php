<?php

namespace App\Controllers;

use App\Models\UserModel;

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

  public function crud()
  {
    //! BEGIN EDIT OR DELETE FORMS EXECUTION
    if (isset($_POST['action'])) {
      $errorCount = 0;
      $errorMessageColor = 'text-danger';
      $errorMessage = '';

      //Edit User
      if ($_POST['action'] == 'editUser') {

        //!Check if required fields have been filled
        if (
          isset($_POST['email']) && !empty($_POST['email']) &&
          isset($_POST['name']) && !empty($_POST['name']) &&
          isset($_POST['surname']) && !empty($_POST['surname'])
        ) {

          //!Retrieve values
          $user_id = $_POST['user_id'];
          $email = $_POST['email'];
          $name = $_POST['name'];
          $surname = $_POST['surname'];

          $user_old = $this->user_model->getById($user_id);

          if ($email !== $user_old['email']) {
            $mailCount = $this->user_model->countMailInTable($email);

            //If no existing mail where found, next
            if ($mailCount['NBemail'] > 1) {
              $errorCount++;
              $errorMessage .= "This email address is already being used by someone else !</br>";
            }

            // Check mail form...
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
              $errorCount++;
              $errorMessage .= "Please enter a correct mail address.</br>";
            }
          }

          //if no errors were found, update
          if ($errorCount == 0) {
            //-------------UPDATING---------

            try {
              $this->user_model->updateUser(
                htmlspecialchars($email),
                htmlspecialchars($name),
                htmlspecialchars($surname),
                $user_id
              );

              $errorMessageColor = 'text-success';
              $errorMessage .= "the user was successfully edited ! </br>";
            } catch (\Exception $e) {
              die('Error : ' . $e->getMessage());
            }
          }
        } else {
          $errorMessage .= "Please fill in all the required fields";
        }
      }


      //Delete User
      if ($_POST['action'] == 'deleteUser') {
        $user = $this->user_model->getById($_POST['user_id']);

        if (empty($user)) {
          $errorCount++;
          $errorMessage .= "An error occured, the user you tried to delete doesn't exist.";
        }

        if ($errorCount == 0) {
          try {
            try {
              $this->user_model->deleteUser($user['id']);
              $errorMessage .= "The user with id '" . $user['id'] . "' (name : " . $user['name'] . " / surname : " . $user['surname'] . " and email : " . $user['email'] . ")  has successfully been deleted !";
            } catch (\Exception $e) {
              die('Error : ' . $e->getMessage());
            }
          } catch (\Exception $e) {
            die('Error : ' . $e->getMessage());
          }
        }
      }
    }
    //! END EDIT OR DELETE FORMS EXECUTION

    //!Execute requests to display CRUD
    try {
      $users = $this->user_model->getAll();
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }

    require($_SERVER['DOCUMENT_ROOT'] . '/app/views/crud.php');
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

    require($_SERVER['DOCUMENT_ROOT'] . '/app/views/register.php');
  }
}
