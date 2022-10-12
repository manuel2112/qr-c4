<?php

namespace App\Models;
use CodeIgniter\Model;
	
class AccionModel extends Model
{
    public $db;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }  

    public function insertAccion($data){
        $this->db
             ->table('x_accion')
             ->insert($data);
    }
    
    public function getAccion($idEmpresa){
        $where = array(
                        'EMPRESA_ID' => $idEmpresa
                      );
    
        $builder = $this->db->table('x_accion');
        $builder->select('*');
        $builder->where($where);
        $builder->orderBy('ACCION_DATE', 'DESC');
        $query = $builder->get();
    
        return $query;
    }
	
} 