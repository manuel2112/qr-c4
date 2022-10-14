<?php

namespace App\Controllers;

use App\Models\PagoModel;
use App\Models\EmpresaModel;
use CodeIgniter\HTTP\Request;
use App\Models\MembresiaModel;
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

class Pagos extends BaseController {

	public $pago_model;
	public $empresa_model;
	public $membresia_model;

	public function __construct()
	{
		if (!session('usuario')) {
			header('Location: '.base_url('login'));
			exit();
		}

        if( getenv('CI_ENVIRONMENT') == 'production' ){
            // WebpayPlus::configureForProduction(
            //     getenv('webpay_plus_cc'),
            //     getenv('webpay_plus_api_key')
            // );
        }else{
            WebpayPlus::configureForTesting();
        }

		$this->pago_model 		= new PagoModel();
		$this->empresa_model 	= new EmpresaModel();
		$this->membresia_model  = new MembresiaModel();

		$session = session();
		$this->session_id 		= $session->get('usuario')['idqrsession'];
	}

	public function index()
	{
        return view('pagos/index');
	}

	public function instanciar()
	{
		$data 		= array();
        $idEmpresa 	= $this->session_id;

		$data['msnMembresia']   = avisoMembresia($idEmpresa);
		$data['textos']         = $this->textos();
        
        return $this->response->setJSON($data);
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
		return $this->response->setJSON($data);
    } 
	
	public function pay()
	{
        $data           = array();
        $data['error']  = false;
        $cantMeses      = trim($_POST["cantMeses"]);
        $valor	        = trim($_POST["valor"]);
        // $valor	        = 100;
        $plan	        = trim($_POST["plan"]);
        $idMembresia    = trim($_POST["idMembresia"]);

        if( !$cantMeses ){
            $data['error'] = true;
            $this->layout->view('pay',$data);
            return;
        }
        
		$neto       = $cantMeses * $valor;
		$iva        = redondear($neto * (iva() / 100));
		$total      = $neto + $iva;
        $buyOrder 	= time();
        $sessionId  = 'FBQR-' . $buyOrder;
        $urlReturn  = base_url('pagos/result');
        
        $data['plan']       = 'PLAN '.$plan;
        $data['valor']      = $valor;
        $data['meses']      = $cantMeses;
        $data['buyOrder']   = $buyOrder;
        $data['neto']       = $neto;
        $data['iva']        = $iva;
        $data['total']      = $total;

        $dataPago = array(
            'EMPRESA_ID'		=> $this->session_id,
            'PAGO_ORDEN'		=> $buyOrder,
            'PAGO_TOKEN'		=> NULL,
            'MEMBRESIA_ID'		=> $idMembresia,
            'PAGO_CANTIDAD'		=> $cantMeses,
            'PAGO_NETO'			=> $neto,
            'PAGO_IVA'			=> $iva,
            'PAGO_TOTAL'		=> $total,
            'PAGO_FECHA'		=> fechaNow()
          );
        $idPago = $this->pago_model->insertPago($dataPago);

        $transaccion = (new Transaction)->create(
            $idPago,
            $sessionId,
            $total,
            $urlReturn
        );

        $data['token']      = $transaccion->getToken();
        $data['url_to_pay'] = $transaccion->getUrl();

        $this->pago_model->updatePagoCampo($idPago, 'PAGO_TOKEN', $data['token']);
        
        return view('pagos/pay',$data);
	}

    public function result()
    {
		$data       = array();
        $token_ws   = isset($_GET["token_ws"]) ? $_GET["token_ws"] : NULL;

        if( $token_ws ){
            $response = '';

            $existe = $this->pago_model->existePago($token_ws);
            if( $existe > 0 ){
                return redirect()->to('pagos/miscompras');
            }

            $response = (new Transaction)->commit($token_ws);

            // SI EL PAGO ESTÁ AUTORIZADO
            if( $response->status == 'AUTHORIZED' ){

                //PAGO REALIZADO CON ÉXITO
                $this->pago_model->updatePagoCampo($response->buyOrder, 'PAGO_PAY', TRUE);

                //DATOS REQUEST
                $dataRequest = array(
                    'PAGO_ID'						=> $response->buyOrder,
                    'PAGO_REQ_ACCOUNTING_DATE'		=> $response->accountingDate,
                    'PAGO_REQ_BUY_ORDER'			=> $response->buyOrder,
                    'PAGO_REQ_CARD_NUMBER'			=> $response->cardNumber,
                    'PAGO_REQ_AMOUNT'				=> $response->amount,
                    'PAGO_REQ_BUY_ORDER_2'			=> $response->buyOrder,
                    'PAGO_REQ_AUTHORIZATION_CODE'	=> $response->authorizationCode,
                    'PAGO_REQ_PAY_TYPE_CODE'		=> $response->paymentTypeCode,
                    'PAGO_REQ_RESPONSE_CODE'		=> $response->responseCode,
                    'PAGO_REQ_SESSIONID'			=> $response->sessionId,
                    'PAGO_REQ_DATE'					=> $response->transactionDate,
                    'PAGO_REQ_VCI'					=> $response->vci,
                    'PAGO_REQ_STATUS'				=> $response->status,
                    'PAGO_REQ_INSTALLMENTS_AMOUNT'	=> $response->installmentsAmount,
                    'PAGO_REQ_INSTALLMENTS_NUMBER'	=> $response->installmentsNumber,
                    'PAGO_REQ_BALANCE_NUMBER'		=> $response->balance
                );
                $this->pago_model->insertPagoRequest($dataRequest);

                //INGRESAR PLANES COMPRADOS
                $compra = $this->pago_model->getPagoRow('PAGO_TOKEN', $token_ws)->getRow();
                calcularMembresia($compra);

                //ENVIAR MAIL COMPROBANTE DE PAGO
                email_pago($response->buyOrder);

                // //CREAR LOG
                crearLogPlus($response);

                $data['token_ws']   = $token_ws;
                $data['status']     = $response->status;
                $mdlPago            = $this->pago_model->getPagoRow( 'PAGO_ID', $response->buyOrder )->getRow();
                $data['buyOrder']   = $mdlPago->PAGO_ORDEN;

            }

        }else{
            // $_GET["TBK_TOKEN"];
            // $_GET["TBK_ORDEN_COMPRA"];
            // $_GET["TBK_ID_SESION"];
        }

        return view('pagos/result',$data);

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
		$data['empresa']    = $this->empresa_model->getEmpresaRow($this->session_id)->getRow();
		$data['compras']    = $this->pago_model->getPagosPorEmpresa($this->session_id)->getResult();
        return view('pagos/miscompras',$data);
    }

	public function seleccionarMembresia()
	{
		$data = array();
		$data['ok'] = false;
		$request        = json_decode(file_get_contents('php://input'));
		$idMembresia    = trim($request->idMembresia);

        $data['membresia'] = $this->membresia_model->getTipoMembresiaRow($idMembresia)->getRow();
		$data['ok'] = true;

        return $this->response->setJSON($data);
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