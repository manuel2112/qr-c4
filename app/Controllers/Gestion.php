<?php

namespace App\Controllers;

use App\Models\ParametroModel;

class Gestion extends BaseController {

	public $parametro_model;
	
	public function __construct()
	{
		if (!session('usuario')) {
			header('Location: '.base_url('login'));
			exit();
		}

		$this->parametro_model = new ParametroModel();
	}
	
	public function index()
	{
		return view('gestion/index');
	}

	public function instanciar()
	{
		$data = array();

		$data['parametros']     = $this->parametro_model->getParametro(1)->getRow();
		$data['editParametros'] = $this->parametro_model->getParametro(1)->getRow();
        
        return $this->response->setJSON($data);
	}

	public function editParametros()
	{
		$data  		= array();
		$data['ok'] = false;

        $request	            = json_decode(file_get_contents('php://input'));
		$PARAMETRO_IVA	        = $request->parametros->PARAMETRO_IVA;
		$PARAMETRO_ZONA_HORARIA = $request->parametros->PARAMETRO_ZONA_HORARIA;
		$PARAMETRO_TRANSBANK	= $request->parametros->PARAMETRO_TRANSBANK;

		//EDITAR PARAMETROS
		$this->parametro_model->updateParametro($PARAMETRO_IVA, $PARAMETRO_ZONA_HORARIA, $PARAMETRO_TRANSBANK);
        
        $data['ok'] = true;
        return $this->response->setJSON($data);
	}
	
}
