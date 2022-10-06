<?php
	
class pago_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
	public function insertPago($idEmpresa,$orden,$token,$idMembresia,$cantidad,$neto,$iva,$total,$date)
    {
		$data = array(
						'EMPRESA_ID'		=> $idEmpresa,
						'PAGO_ORDEN'		=> $orden,
						'PAGO_TOKEN'		=> $token,
						'MEMBRESIA_ID'		=> $idMembresia,
						'PAGO_CANTIDAD'		=> $cantidad,
						'PAGO_NETO'			=> $neto,
						'PAGO_IVA'			=> $iva,
						'PAGO_TOTAL'		=> $total,
						'PAGO_FECHA'		=> $date
					);
		$this->db->insert('empresa_pago', $data);
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
						$campo	=> $value
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_pago")
					    ->join('membresia', 'membresia.MEMBRESIA_ID = empresa_pago.MEMBRESIA_ID')
                        ->where($where)
                        ->get();
        return $query->row();
    }

    public function getPagosPorEmpresa( $idEmpresa )
    {
        $where = array(
						'empresa_pago.EMPRESA_ID'	=> $idEmpresa,						
						'empresa_pago.PAGO_PAY'		=> true
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_pago")
					    ->join('membresia', 'membresia.MEMBRESIA_ID = empresa_pago.MEMBRESIA_ID')
                        ->where($where)
						->order_by("empresa_pago.PAGO_ID DESC")
                        ->get();
        return $query->result();
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
		
	public function insertPagoRequest( $idPedido, $log, $status )
	{
		$data = array(
						'PAGO_ID'						=> $idPedido,
						'PAGO_REQ_ACCOUNTING_DATE'		=> $log->accountingDate,
						'PAGO_REQ_BUY_ORDER'			=> $log->buyOrder,
						'PAGO_REQ_CARD_NUMBER'			=> $log->cardDetail['card_number'],
						'PAGO_REQ_AMOUNT'				=> $log->amount,
						'PAGO_REQ_BUY_ORDER_2'			=> $log->buyOrder,
						'PAGO_REQ_AUTHORIZATION_CODE'	=> $log->authorizationCode,
						'PAGO_REQ_PAY_TYPE_CODE'		=> $log->paymentTypeCode,
						'PAGO_REQ_RESPONSE_CODE'		=> $log->responseCode,
						'PAGO_REQ_SESSIONID'			=> $log->sessionId,
						'PAGO_REQ_DATE'					=> $log->transactionDate,
						'PAGO_REQ_VCI'					=> $log->vci,
						'PAGO_REQ_STATUS'				=> $log->status,
						'PAGO_REQ_INSTALLMENTS_AMOUNT'	=> $status->installmentsAmount,
						'PAGO_REQ_INSTALLMENTS_NUMBER'	=> $status->installmentsNumber,
						'PAGO_REQ_BALANCE_NUMBER'		=> $status->balance
					);
		$this->db->insert('empresa_pago_request', $data);
	}
    
    public function getPagoRequestRow( $campo, $value )
    {
        $where = array(
						$campo	=> $value
					   );
        $query = $this->db
                        ->select("*")
                        ->from("empresa_pago_request")
                        ->where($where)
                        ->get();
        return $query->row();
    }
	
} 