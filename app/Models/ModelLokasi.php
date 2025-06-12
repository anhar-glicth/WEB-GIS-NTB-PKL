<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLokasi extends Model
{

 public function insertData($data)
 {
    $this->db->table('koordinat')->insert($data);

 }
  public function getalldata()
 {
  return $this->db->table('koordinat')->get()->getResultArray();


 }
}
