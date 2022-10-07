<?php

namespace App\Models;
use CodeIgniter\Model;
	
class MembresiaModel extends Model
{
    public $db;

    function __construct()
    {
    $this->db = \Config\Database::connect();
    }
    
    public function getMembresiaRow( $idEmpresa )
    {
        $where = array(
                        'EMPRESA_ID'	    => $idEmpresa,
						'EMP_MEMB_FLAG'	    => true
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_membresia")
                        ->where($where)
                        ->order_by('EMP_MEMB_ID ASC')
                        ->limit(1)
                        ->get();
        return $query->row();
    }

    public function getMembresiaByIDRow( $idMembresia )
    {
        $where = array(
                        'EMP_MEMB_ID' => $idMembresia
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_membresia")
                        ->where($where)
                        ->get();
        return $query->row();
    }

    public function getMembresiasPlan( $idEmpresa )
    {
        $where = array(
                        'empresa_membresia.EMPRESA_ID'      => $idEmpresa,
                        'empresa_membresia.EMP_MEMB_FLAG'   => true
                      );
    
        $builder = $this->db->table('empresa_membresia');
        $builder->select('*');
        $builder->join('membresia', 'membresia.MEMBRESIA_ID = empresa_membresia.MEMBRESIA_ID');
        $builder->where($where);
        $builder->orderBy('empresa_membresia.EMP_MEMB_ID', 'ASC');
        $builder->limit(1);
        $query = $builder->get();
    
        return $query;
    }

    public function getMembresiasAll( $idEmpresa )
    {
        $where = array(
                        'empresa_membresia.EMPRESA_ID'      => $idEmpresa
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_membresia")
					    ->join('membresia', 'membresia.MEMBRESIA_ID = empresa_membresia.MEMBRESIA_ID')
                        ->where($where)
                        ->order_by('empresa_membresia.EMP_MEMB_ID DESC')
                        ->get();
        return $query->result();
    }

    public function getMembresiaInsertPlanRow( $idEmpresa )
    {
        $where = array(
                        'EMPRESA_ID'	    => $idEmpresa,
						'EMP_MEMB_FLAG'	    => true
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_membresia")
                        ->where($where)
                        ->order_by('EMP_MEMB_ID DESC')
                        ->limit(1)
                        ->get();
        return $query->row();
    }
	
	public function updateMembresiaPorCampo($campoWhere,$valueWhere,$campoArr,$valueArr)
    {        
        $builder = $this->db->table('empresa_membresia');
        $builder->set($campoArr, $valueArr);
        $builder->where($campoWhere, $valueWhere);
        $builder->update();
    }
	
	public function updateMembresiaDownBronce($idEmpresa)
    {        
        $where = array(
                            'EMPRESA_ID'	    => $idEmpresa,
                            'EMP_MEMB_FLAG'	    => TRUE,
                            'MEMBRESIA_ID'	    => 1
                        );
		$array = array(
                            'EMP_MEMB_FLAG' => FALSE
					   );
                       
		$this->db->where($where);
		$this->db->update('empresa_membresia', $array);
    }
	
	public function insertMembresia($data)
    {
        $this->db
             ->table('empresa_membresia')
             ->insert($data);
    }

    public function getMembresiaEnUso()
    {
        $where = array(
						'EMP_MEMB_FLAG'	=> true
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_membresia")
                        ->where($where)
                        ->get();
        return $query->result();
    }
    
    public function getMembresiaEmpresaEnUso($idEmpresa)
    {
        $where = array(
                        'empresa_membresia.EMPRESA_ID'	    => $idEmpresa,
                        'empresa_membresia.EMP_MEMB_FLAG'   => true
                      );
    
        $builder = $this->db->table('empresa_membresia');
        $builder->select('*');
        $builder->join('membresia', 'membresia.MEMBRESIA_ID = empresa_membresia.MEMBRESIA_ID');
        $builder->where($where);
        $builder->orderBy('empresa_membresia.EMP_MEMB_ID', 'ASC');
        $builder->limit(1);
        $query = $builder->get();
    
        return $query;
    }
    
	/*=============================================
	MEMBRESÍA
	=============================================*/
    
    public function getMembresias()
    {
        $where = array(
                        'MEMBRESIA_ID !='   => 1,
						'MEMBRESIA_FLAG'    => true
					   );
        $query = $this->db
                        ->select("*")
                        ->from("membresia")
                        ->where($where)
                        ->get();
        return $query->result();
    }

    public function getTipoMembresiaRow( $idMembresia )
    {
        $where = array(
                        'MEMBRESIA_ID'      => $idMembresia,
						'MEMBRESIA_FLAG'    => true
					   );
        $query = $this->db
                        ->select("*")
                        ->from("membresia")
                        ->where($where)
                        ->get();
        return $query->row();
    }
	
} 