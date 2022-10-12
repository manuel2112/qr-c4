<?php

namespace App\Models;
use CodeIgniter\Model;
	
class VistaModel extends Model
{
  public $db;

  function __construct()
  {
    $this->db = \Config\Database::connect();
  }  

	public function insertVista($idEmpresa, $date)
  {
	  $data = array(
            "EMPRESA_ID"  => $idEmpresa,
            "VISTA_DATE"	=> $date
          );
	  $this->db->insert('vista', $data);
  }

  public function getCountVistaMes($idEmpresa, $year, $month)
  {
        $where = array(
                        'EMPRESA_ID'        => $idEmpresa,
                        'YEAR(VISTA_DATE)'  => $year,
                        'MONTH(VISTA_DATE)' => $month,
					            );
        $query = $this->db
                        ->select("*")
                        ->from("vista")
                        ->where($where)
                        ->get();
        return $query->num_rows();
  }
  
  public function getVistaPlanActual($idEmpresa,$inicio,$fin)
  {
    $where = array(
                    'EMPRESA_ID'    => $idEmpresa,
                    'VISTA_DATE >=' => $inicio,
                    'VISTA_DATE <=' => $fin,
                  );

    $builder = $this->db->table('vista');
    $builder->select('*');
    $builder->where($where);
    $builder->orderBy('VISTA_ID', 'DESC');
    $query = $builder->get();

    return $query;
  }
	
} 