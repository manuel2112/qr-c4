<?php

namespace App\Models;
use CodeIgniter\Model;
	
class TipopagoModel extends Model
{
    public $db;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }  
	/*=============================================
	TIPO ENTREGA
	=============================================*/
    public function getTipoEntrega()
    {
        $where = array(
                        'TIPO_ENTREGA_FLAG' => TRUE
                      );
    
        $builder = $this->db->table('tipo_entrega');
        $builder->select('*');
        $builder->where($where);
        $builder->orderBy("TIPO_ENTREGA_NMB", "ASC");
        $query = $builder->get();
    
        return $query;
    }

	/*=============================================
	TIPO ENTREGA EMPRESA
	=============================================*/
    public function getTipoEntregaEmpresa($idEmpresa)
    {
        $where = array(
                        'EMPRESA_ID' => $idEmpresa
                      );
    
        $builder = $this->db->table('tipo_entrega');
        $builder->select('*');
        $builder->join('tipo_entrega_empresa', 'tipo_entrega.TIPO_ENTREGA_ID = tipo_entrega_empresa.TIPO_ENTREGA_ID');
        $builder->where($where);
        $query = $builder->get();
    
        return $query;
    }
    
    public function getApiTipoEntregaEmpresa($idEmpresa)
    {
            $where = array(
                            'tipo_entrega_empresa.EMPRESA_ID' => $idEmpresa,
                            'tipo_entrega_empresa.TIPO_ENTREGA_EMPRESA_FLAG' => TRUE
                            );
            $query = $this->db
                            ->select("*")
                            ->from("tipo_entrega")
                            ->join('tipo_entrega_empresa', 'tipo_entrega.TIPO_ENTREGA_ID = tipo_entrega_empresa.TIPO_ENTREGA_ID')
                            ->where($where)
                            ->get();
            return $query->result();
    }

    public function insertTipoEntrega($data)
    {
        $this->db
             ->table('tipo_entrega_empresa')
             ->insert($data);
    }

    public function updateTipoEntregaEmpresaCampo($id, $campo, $valor)
    {
        $builder = $this->db->table('tipo_entrega_empresa');
        $builder->set($campo, $valor);
        $builder->where('TIPO_ENTREGA_EMPRESA_ID', $id);
        $builder->update();
    }

	/*=============================================
	TIPO PAGO
	=============================================*/
    public function getTipoPago()
    {
        $where = array(
                        'TIPO_PAGO_FLAG' => TRUE
                      );
    
        $builder = $this->db->table('tipo_pago');
        $builder->select('*');
        $builder->where($where);
        $builder->orderBy("TIPO_PAGO_NMB", "ASC");
        $query = $builder->get();
    
        return $query;
    }

	/*=============================================
	TIPO PAGO EMPRESA
	=============================================*/
    public function getTipoPagoEmpresa($idEmpresa)
    {
        $where = array(
                        'EMPRESA_ID' => $idEmpresa
                      );
    
        $builder = $this->db->table('tipo_pago');
        $builder->select('*');
        $builder->join('tipo_pago_empresa', 'tipo_pago.TIPO_PAGO_ID = tipo_pago_empresa.TIPO_PAGO_ID');
        $builder->where($where);
        $query = $builder->get();
    
        return $query;
    }
    
    public function getApiTipoPagoEmpresa($idEmpresa)
    {
            $where = array(
                            'tipo_pago_empresa.EMPRESA_ID' => $idEmpresa,
                            'tipo_pago_empresa.TIPO_PAGO_EMPRESA_FLAG' => TRUE
                            );
            $query = $this->db
                            ->select("*")
                            ->from("tipo_pago")
                            ->join('tipo_pago_empresa', 'tipo_pago.TIPO_PAGO_ID = tipo_pago_empresa.TIPO_PAGO_ID')
                            ->where($where)
                            ->get();
            return $query->result();
    }
    
    public function insertTipoPago($data)
    {
        $this->db
             ->table('tipo_pago_empresa')
             ->insert($data);
    } 

    public function updateTipoPagoEmpresaCampo($id, $campo, $valor)
    {
        $builder = $this->db->table('tipo_pago_empresa');
        $builder->set($campo, $valor);
        $builder->where('TIPO_PAGO_EMPRESA_ID', $id);
        $builder->update();
    }

	
} 