<?php

namespace App\Models;
use CodeIgniter\Model;
	
class LoginModel extends Model
{
  protected $builder;

  function __construct()
  {
      $db      = \Config\Database::connect();
      $this->builder = $db->table('empresa');
  }
	
	public function editPassAdmin($password)
  {
    $this->builder->set('EMPRESA_PASS', $password);
    $this->builder->where('EMPRESA_ADMIN', TRUE);
    $this->builder->update();
  }
  
	// public function getLoginRow($user,$pass)
  // {
  //   $where = array(
  //                   "EMPRESA_EMAIL" => $user, 
  //                   "EMPRESA_PASS"  => $pass
  //                  );		    
  //   $query = $this->db
  //                 ->select("*")
  //                 ->from("empresa")
  //                 ->where($where)
  //                 ->get();
  //   return $query->row();
  // }

}