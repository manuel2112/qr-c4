<?php
	
class accion_model extends CI_Model
{
  function __construct()
  {
      parent::__construct();
  }  

  public function insertAccion($idEmpresa, $txt, $date){
      $data = array(
              "EMPRESA_ID"    => $idEmpresa,
              "ACCION_TXT"    => $txt,
              "ACCION_DATE"   => $date
          );
      $this->db->insert('x_accion', $data);
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