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
            $query = $this->db
                            ->select("*")
                            ->from("x_accion")
                            ->where($where)
                            ->order_by("ACCION_DATE DESC")
                            ->get();
            return $query->result();
    }
	
} 