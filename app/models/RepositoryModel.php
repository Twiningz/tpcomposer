<?php

namespace App\Lib;

abstract class RepositoryModel
{

  protected $db;
  protected $table_name;

  public function __construct()
  {
    try {
      $this->db = new PDO('mysql:host=localhost;dbname=exercice_composer', 'root', 'root');
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function getAll()
  {
    $request = $this->db->prepare('SELECT * FROM ' . $this->table_name);
    try {
      $request->execute();
      return $request->fetchAll();
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function getAllIdsNames()
  {
    $request = $this->db->prepare('SELECT id, name FROM ' . $this->table_name);
    try {
      $request->execute();
      return $request->fetchAll();
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function getById($id)
  {
    $request = $this->db->prepare('SELECT * FROM ' . $this->table_name . ' WHERE id=' . $id . ' LIMIT 1');
    try {
      $request->execute();
      return $request->fetchAll();
    } catch (\Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }
}
