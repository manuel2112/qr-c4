<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('idqrsession')) {
			$this->session->set_userdata('', current_url());
			redirect(base_url('login'));
		}
		$this->session_id 	        = $this->session->userdata('idqrsession');
		$this->session_nmb 	        = $this->session->userdata('nmbqrsession');
		$this->isadminqrsession 	= $this->session->userdata('isadminqrsession');
        $this->load->library('transbankrest');
        $this->load->library('session'); 
        $this->load->helper('url');
	}

	public function index()
	{
		$this->layout->view('index');
	}

	public function instanciar()
	{
		$data 		= array();
        $idEmpresa 	= $this->session_id;

		$data['msnMembresia']   = avisoMembresia($idEmpresa);
		$data['textos']         = $this->textos();
        
        echo json_encode($data);
	}

    public function textos()
	{
		$array = [
            'qr' => 'Código QR personalizado con tu logo',
            'panel' => 'Panel autoadministrable',
            'visualizaciones' => 'visualizaciones máximo del menú por mes',
            'sinrestriccion' => 'Sin restricción de visualizaciones',
            'servicio' => '*Servicio de administración',
            'qrbronce' => 'Código QR',
            'categorias' => 'Categorías ilimitadas',
            'productos' => 'Productos ilimitados',
            'fotos' => 'Productos con imágenes',
            'maxfotos' => ' imágenes máximo por producto',
            'url' => 'URL Personalizada',
            'tecnico' => 'Servicio Técnico',
            'rrss' => 'Botónes a tus Redes Sociales y Whatsapp',
            'update' => 'Actualizacions ilimitadas',
        ];
        
        return $array;
	}

    public function calcMembresia()
    {
		$data		= array();
		$data['ok'] = false;

		$request        = json_decode(file_get_contents('php://input'));
		$cantMeses		= $request->cantMeses;
		$valor		    = $request->valor;

        $subTotal   = $cantMeses * $valor ;
        $iva        = $subTotal * (iva() / 100);
        $total      = $subTotal + $iva;

        $data['msn'] = '<div class="alert alert-success"><h4 class="text-center">POR PAGAR: '.formatoDinero($subTotal).' + IVA <br> TOTAL: '.formatoDinero($total).'</h4></div>';

        $data['ok'] = true;
		echo json_encode($data);
    } 
	
	public function pay()
	{
        $data           = array();
        $data['error']  = false;
        $cantMeses      = trim($this->input->post("cantMeses",true));
        $valor	        = trim($this->input->post("valor",true));
        // $valor	        = 100;
        $plan	        = trim($this->input->post("plan",true));
        $idMembresia    = trim($this->input->post("idMembresia",true));

        if( !$cantMeses ){
            $data['error'] = true;
            $this->layout->view('pay',$data);
            return;
        }
        
		$neto       = $cantMeses * $valor;
		$iva        = redondear($neto * (iva() / 100));
		$total      = $neto + $iva;
        $sessionId  = 'sessionFacilbakQRPay';
        $buyOrder 	= time();
        
        $data['plan']       = 'PLAN '.$plan;
        $data['valor']      = $valor;
        $data['meses']      = $cantMeses;
        $data['buyOrder']   = $buyOrder;
        $data['neto']       = $neto;
        $data['iva']        = $iva;
        $data['total']      = $total;
        
        $returnUrl  = 'pagos/result';
                
        $this->transbankrest->setBuyOrder($buyOrder);
        $this->transbankrest->setSession($sessionId);
        $this->transbankrest->setMonto($total);
        $this->transbankrest->setReturnUrl($returnUrl);

        $transaccion = $this->transbankrest->transaction();

        $data['formAction'] = $transaccion->url;
        $data['tokenWs']    = $transaccion->token;

        $this->pago_model->insertPago($this->session_id,$buyOrder,$data['tokenWs'],$idMembresia,$cantMeses,$neto,$iva,$total,fechaNow());
        
        $this->layout->view('pay',$data);
	}

    public function result()
    { 
        $ws_token = filter_input(INPUT_POST, 'token_ws');

        if( empty($ws_token) ){
            redirect(base_url('pagos/error'));
        }

        $result = $this->transbankrest->getTransactionResult( $ws_token );
        $status = $this->transbankrest->getTransactionStatus( $ws_token );
        
        if ( $result->responseCode === 0 ) {

            $this->pago_model->updatePagoPay($ws_token);
            $mdlPago = $this->pago_model->getPagoRow( 'PAGO_TOKEN', $ws_token );
            crearLogPlus($result,$status);
            
            $this->session->set_userdata("idqrsession", $mdlPago->EMPRESA_ID);
			$this->session->userdata('idqrsession');

            //INSERT MEMBRESÍA
            calcularMembresia($mdlPago);
                        
            redirect('pagos/exito');

        } else {
            $data               = array(); 
            $data['empresa']    = $this->empresa_model->getEmpresaRow($this->session_id);
            $this->layout->view('error',$data);
        }
    }

    public function exito()
    {
        $idEmpresa  = $this->session_id;
        $pago       = $this->pago_model->getLastPagoPorEmpresa($idEmpresa);
        $buyOrder   = $pago->PAGO_ORDEN;        

        if( empty($buyOrder) ){
            $data['compras']    = $this->pago_model->getPagosPorEmpresa($idEmpresa);
            $this->layout->view('miscompras',$data);
            return;
        }

        $data['buyOrder']   = $buyOrder;
		$data['empresa']    = $this->empresa_model->getEmpresaRow($idEmpresa);
        //ENVIAR CORREO A CLIENTE
        email_pago($buyOrder);
        $this->layout->view('exito',$data);
    }

    public function error()
    {
		$data               = array();        
		$data['empresa']    = $this->empresa_model->getEmpresaRow($this->session_id);
        $this->layout->view('error', $data );
    }

    public function miscompras()
    {
		$data = array();
		$data['empresa']    = $this->empresa_model->getEmpresaRow($this->session_id);
		$data['compras']    = $this->pago_model->getPagosPorEmpresa($this->session_id);
        $this->layout->view('miscompras',$data);
    }

	public function seleccionarMembresia()
	{
		$data = array();
		$data['ok'] = false;
		$request        = json_decode(file_get_contents('php://input'));
		$idMembresia    = trim($request->idMembresia);

        $data['membresia'] = $this->membresia_model->getTipoMembresiaRow($idMembresia);
		$data['ok'] = true;

        echo json_encode($data);
	}

	/*=============================================
	HELP
	=============================================*/
	
	public function help()
	{
        $this->load->view('layouts/help/header');
        $this->load->view('pagos/help');
        $this->load->view('layouts/help/footer');
	}

}