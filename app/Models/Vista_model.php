<?php
	
class vista_model extends CI_Model
{
  function __construct()
  {
      parent::__construct();
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
        $query = $this->db
                        ->select("*")
                        ->from("vista")
                        ->where($where)
                        ->order_by("VISTA_ID DESC")
                        ->get();
        return $query->result();
  }
	
} 