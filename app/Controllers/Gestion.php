<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('isadminqrsession')) {
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
		$data = array();

		$data['parametros']     = $this->parametro_model->getParametro();
		$data['editParametros'] = $this->parametro_model->getParametro();
        
        echo json_encode($data);
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
        echo json_encode($data);
	}
	
}
