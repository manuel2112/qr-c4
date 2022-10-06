<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipospago extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('idqrsession')) {
			$this->session->set_userdata('', current_url());
			redirect(base_url('login'));
		}
		$this->session_id 			= $this->session->userdata('idqrsession');
		$this->session_nmb 			= $this->session->userdata('nmbqrsession');
		$this->isadminqrsession 	= $this->session->userdata('isadminqrsession');
	}
	
	public function index()
	{
		$this->layout->view('index');
	}

	public function instanciar()
	{
		$data       = array();
        $idEmpresa	= $this->session_id;

        //INSTANCIAR VALORES
        $existe = $this->tipopago_model->getTipoEntregaEmpresa($idEmpresa);
        if( !$existe ){
            $tiposEntrega   = $this->tipopago_model->getTipoEntrega();
            $tiposPago      = $this->tipopago_model->getTipoPago();

            foreach( $tiposEntrega as $tipo ){
                $this->tipopago_model->insertTipoEntrega($idEmpresa, $tipo->TIPO_ENTREGA_ID);
            }
            foreach( $tiposPago as $tipo ){
                $this->tipopago_model->insertTipoPago($idEmpresa, $tipo->TIPO_PAGO_ID);
            }
        }

		$empresa = $this->empresa_model->getEmpresaRow($idEmpresa);
		$data['empresaPago'] 	= $empresa->EMPRESA_PAGO == 1 ? TRUE : FALSE;
		$data['tiposEntrega'] 	= $this->tipopago_model->getTipoEntregaEmpresa($idEmpresa);
		$data['tiposPago'] 		= $this->tipopago_model->getTipoPagoEmpresa($idEmpresa);
        
        echo json_encode($data);
	}

	public function accionPago()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request	= json_decode(file_get_contents('php://input'));
		$pago		= $request->pago;

		$this->empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_PAGO', $pago);

		$accion = $pago ? 22 : 23 ;
		insertAccion($idEmpresa, $accion, null, null);

		$data['ok'] = true;
		echo json_encode($data);
	}

	public function accionTipo()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request	= json_decode(file_get_contents('php://input'));
		$id			= $request->id;
		$bool		= $request->bool == 1 ? FALSE : TRUE;
		$tipo		= $request->tipo;

		if( $tipo == 1 ){
			$this->tipopago_model->updateTipoEntregaEmpresaCampo($id, 'TIPO_ENTREGA_EMPRESA_FLAG', $bool);
		}else{
			$this->tipopago_model->updateTipoPagoEmpresaCampo($id, 'TIPO_PAGO_EMPRESA_FLAG', $bool);
		}		

		insertAccion($idEmpresa, 24, null, null);

		$data['ok'] = true;
		echo json_encode($data);
	}

	public function accionInfo()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request	= json_decode(file_get_contents('php://input'));
		$id			= $request->info->id;
		$tipo		= $request->info->tipo;
		$info		= $request->info->info ? $request->info->info : NULL;

		if( $tipo == 1 ){
			$this->tipopago_model->updateTipoEntregaEmpresaCampo($id, 'TIPO_ENTREGA_EMPRESA_DETALLE', $info);
		}else{
			$this->tipopago_model->updateTipoPagoEmpresaCampo($id, 'TIPO_PAGO_EMPRESA_DETALLE', $info);
		}		

		insertAccion($idEmpresa, 25, null, null);

		$data['ok'] = true;
		echo json_encode($data);
	}
	
}
