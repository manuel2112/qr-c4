<?php

namespace App\Models;
use CodeIgniter\Model;
	
class PagoModel extends Model
{
	public $db;
  
	function __construct()
	{
	  $this->db = \Config\Database::connect();
	}
	
	public function insertPago($data)
    {
		$this->db
			 ->table('empresa_pago')
			 ->insert($data);
		return $this->db->insertID();
    }

	public function updatePagoCampo($idPago, $campo, $valor)
	{
	  $builder = $this->db->table('empresa_pago');
	  $builder->set($campo, $valor);
	  $builder->where('PAGO_ID', $idPago);
	  $builder->update();
	}

	public function existePago($token)
	{
	  $where = array(
					  "PAGO_TOKEN" 	=> $token,
					  "PAGO_PAY" 	=> TRUE
					);
  
	  $builder = $this->db->table('empresa_pago');
	  $builder->select('*');
	  $builder->where($where);
	  $query = $builder->countAllResults();
  
	  return $query;
	}

	public function updatePagoPay($token)
    {
		$array = array(
						'PAGO_PAY' => true
					   );
		$this->db->where('PAGO_TOKEN', $token);
		$this->db->update('empresa_pago', $array);
    }

    public function getPagoRow( $campo, $value )
    {
		$where = array(
						$campo => $value
					  );
	
		$builder = $this->db->table('empresa_pago');
		$builder->select('*');
		$builder->join('membresia', 'membresia.MEMBRESIA_ID = empresa_pago.MEMBRESIA_ID');
		$builder->where($where);
		$query = $builder->get();
	
		return $query;
    }

    public function getPagoRecibo( $campo, $value )
    {
		$where = array(
						$campo => $value
					  );
	
		$builder = $this->db->table('empresa_pago');
		$builder->select('*');
		$builder->join('membresia', 'membresia.MEMBRESIA_ID = empresa_pago.MEMBRESIA_ID');
		$builder->join('empresa_pago_request', 'empresa_pago_request.PAGO_ID = empresa_pago.PAGO_ID');
		$builder->where($where);
		$query = $builder->get();
	
		return $query;
    }

    public function getPagosPorEmpresa( $idEmpresa )
    {
		$where = array(
						'empresa_pago.EMPRESA_ID'	=> $idEmpresa,						
						'empresa_pago.PAGO_PAY'		=> true
					  );
	
		$builder = $this->db->table('empresa_pago');
		$builder->select('*');
		$builder->join('membresia', 'membresia.MEMBRESIA_ID = empresa_pago.MEMBRESIA_ID');
		$builder->where($where);
		$builder->orderBy('empresa_pago.PAGO_ID', 'DESC');
		$query = $builder->get();
	
		return $query;
    }

    public function getLastPagoPorEmpresa( $idEmpresa )
    {
        $where = array(
						'EMPRESA_ID'	=> $idEmpresa,						
						'PAGO_PAY'		=> true
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_pago")
                        ->where($where)
						->order_by("PAGO_ID DESC")
						->limit(1)
                        ->get();
        return $query->row();
    }
	
	/**************************/
	/******PAGO/REQUEST*****/
	/**************************/
		
	public function insertPagoRequest( $data )
	{
		$this->db
			 ->table('empresa_pago_request')
			 ->insert($data);
	}
    
    public function getPagoRequestRow( $campo, $value )
    {
		$where = array(
						$campo => $value
					  );
	
		$builder = $this->db->table('empresa_pago_request');
		$builder->select('*');
		$builder->where($where);
		$query = $builder->get();
	
		return $query;
    }
	
} 