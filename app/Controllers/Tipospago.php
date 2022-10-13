<?php

namespace App\Controllers;

use App\Models\EmpresaModel;
use App\Models\TipopagoModel;

class Tipospago extends BaseController {

	public $tipopago_model;
	public $empresa_model;
	
	public function __construct()
	{
		if (!session('usuario')) {
			header('Location: '.base_url('login'));
			exit();
		}

		$this->tipopago_model 	= new TipopagoModel();
		$this->empresa_model 	= new EmpresaModel();

		$session = session();
		$this->session_id 		= $session->get('usuario')['idqrsession'];
	}
	
	public function index()
	{
		return view('tipospago/index');
	}

	public function instanciar()
	{
		$data       = array();
        $idEmpresa	= $this->session_id;

        //INSTANCIAR VALORES
        $existe = $this->tipopago_model->getTipoEntregaEmpresa($idEmpresa)->getResult();
        if( !$existe ){
            $tiposEntrega   = $this->tipopago_model->getTipoEntrega()->getResult;
            $tiposPago      = $this->tipopago_model->getTipoPago()->getResult();

            foreach( $tiposEntrega as $tipo ){
				$dataEntrega = array(
					"EMPRESA_ID"        => $idEmpresa,
					"TIPO_ENTREGA_ID"   => $tipo->TIPO_ENTREGA_ID
				  );
				$this->tipopago_model->insertTipoEntrega($dataEntrega);
            }
            foreach( $tiposPago as $tipo ){
				$dataPago = array(
					"EMPRESA_ID"    => $idEmpresa,
					"TIPO_PAGO_ID"  => $tipo->TIPO_PAGO_ID
				  );
				$this->tipopago_model->insertTipoPago($dataPago);
            }
        }

		$empresa = $this->empresa_model->getEmpresaRow($idEmpresa)->getRow();
		$data['empresaPago'] 	= $empresa->EMPRESA_PAGO == 1 ? TRUE : FALSE;
		$data['tiposEntrega'] 	= $this->tipopago_model->getTipoEntregaEmpresa($idEmpresa)->getResult();
		$data['tiposPago'] 		= $this->tipopago_model->getTipoPagoEmpresa($idEmpresa)->getResult();
        
        return $this->response->setJSON($data);
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
		return $this->response->setJSON($data);
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
		return $this->response->setJSON($data);
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
		return $this->response->setJSON($data);
	}
	
}
