<?php

namespace App\Models;

class UserModel extends RepositoryModel
{

  protected $table_name = 'users';

  public function getUserByMail($email)
  {

    $request = $this->db->prepare(
      'SELECT *
      FROM ' . $this->table_name . ' 
      WHERE email = ?
      LIMIT 1'
    );
    try {
      $request->execute(array($email));
      return $request->fetch();
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function countMailInTable($email)
  {

    $request = $this->db->prepare('SELECT COUNT(email) as NBemail FROM ' . $this->table_name . ' WHERE email = ?');
    try {
      $request->execute(array($email));
      return $request->fetch();
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function addUser($email, $pass_hashed, $name, $surname)
  {

    $request = $this->db->prepare(
      'INSERT INTO 
        ' . $this->table_name . '(
            email, password, 
            name, surname) 
    VALUES (:email, :passHashed, 
            :name, :surname)'
    );

    try {
      $request->execute(array(
        'email' => $email,
        'passHashed' => $pass_hashed,
        'name' => $name,
        'surname' => $surname
      ));
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function updateUser($email, $name, $surname, $user_id)
  {

    $request = $this->db->prepare(
      'UPDATE ' . $this->table_name . '
      SET email=:email, 
          name=:name, surname=:surname
      WHERE id=:id'
    );
    try {
      $request->execute(array(
        'email' => $email,
        'name' => $name,
        'surname' => $surname,
        'id' => $user_id
      ));
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function deleteUser($user_id)
  {

    $request = $this->db->prepare('DELETE FROM ' . $this->table_name . ' WHERE id = ? LIMIT 1');
    try {
      $request->execute(array($user_id));
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }
}
