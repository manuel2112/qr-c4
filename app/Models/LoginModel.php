<?php

namespace App\Models;
use CodeIgniter\Model;
	
class LoginModel extends Model
{
  public $db;

  function __construct()
  {
    $this->db = \Config\Database::connect();
  }
	
	public function editPassAdmin($password)
  {
    $builder = $this->db->table('empresa');
    $builder->set('EMPRESA_PASS', $password);
    $builder->where('EMPRESA_ADMIN', TRUE);
    $builder->update();
  }
  
	public function getLoginRow($user,$pass)
  {
    $where = array(
                    "EMPRESA_EMAIL" => $user, 
                    "EMPRESA_PASS"  => $pass
                  );

    $builder = $this->db->table('empresa');
    $builder->select('*');
    $builder->where($where);
    $query = $builder->get();

    return $query;
  }

}