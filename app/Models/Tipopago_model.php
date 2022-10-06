<?php
	
class tipopago_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }  
	/*=============================================
	TIPO ENTREGA
	=============================================*/
    public function getTipoEntrega()
    {
            $where = array(
                            'TIPO_ENTREGA_FLAG' => TRUE
                            );
            $query = $this->db
                            ->select("*")
                            ->from("tipo_entrega")
                            ->where($where)
                            ->order_by("TIPO_ENTREGA_NMB ASC")
                            ->get();
            return $query->result();
    }

	/*=============================================
	TIPO ENTREGA EMPRESA
	=============================================*/
    public function getTipoEntregaEmpresa($idEmpresa)
    {
            $where = array(
                            'EMPRESA_ID' => $idEmpresa
                            );
            $query = $this->db
                            ->select("*")
                            ->from("tipo_entrega")
                            ->join('tipo_entrega_empresa', 'tipo_entrega.TIPO_ENTREGA_ID = tipo_entrega_empresa.TIPO_ENTREGA_ID')
                            ->where($where)
                            ->get();
            return $query->result();
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

    public function insertTipoEntrega($idEmpresa, $idTipo)
    {
        $data = array(
                        "EMPRESA_ID"        => $idEmpresa,
                        "TIPO_ENTREGA_ID"   => $idTipo
                    );
        $this->db->insert('tipo_entrega_empresa', $data);
    }

    public function updateTipoEntregaEmpresaCampo($id, $campo, $valor)
    {
      $array = array(
                        $campo => $valor
                    );
      $this->db->where('TIPO_ENTREGA_EMPRESA_ID', $id);
      $this->db->update('tipo_entrega_empresa', $array);
    }

	/*=============================================
	TIPO PAGO
	=============================================*/
    public function getTipoPago()
    {
            $where = array(
                            'TIPO_PAGO_FLAG' => TRUE
                            );
            $query = $this->db
                            ->select("*")
                            ->from("tipo_pago")
                            ->where($where)
                            ->order_by("TIPO_PAGO_NMB ASC")
                            ->get();
            return $query->result();
    }

	/*=============================================
	TIPO PAGO EMPRESA
	=============================================*/
    public function getTipoPagoEmpresa($idEmpresa)
    {
            $where = array(
                            'EMPRESA_ID' => $idEmpresa
                            );
            $query = $this->db
                            ->select("*")
                            ->from("tipo_pago")
                            ->join('tipo_pago_empresa', 'tipo_pago.TIPO_PAGO_ID = tipo_pago_empresa.TIPO_PAGO_ID')
                            ->where($where)
                            ->get();
            return $query->result();
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
    
    public function insertTipoPago($idEmpresa, $idTipo)
    {
        $data = array(
                        "EMPRESA_ID"    => $idEmpresa,
                        "TIPO_PAGO_ID"  => $idTipo
                    );
        $this->db->insert('tipo_pago_empresa', $data);
    } 

    public function updateTipoPagoEmpresaCampo($id, $campo, $valor)
    {
      $array = array(
                        $campo => $valor
                    );
      $this->db->where('TIPO_PAGO_EMPRESA_ID', $id);
      $this->db->update('tipo_pago_empresa', $array);
    }

	
} 