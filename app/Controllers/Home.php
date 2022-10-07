<?php

namespace App\Controllers;

use App\Models\EmpresaModel;
use App\Models\MembresiaModel;

class Home extends BaseController {

	public $session_id;
	public $empresaMdl;
	public $membresiaMdl;
	
	public function __construct()
	{
		if (!session('usuario')) {
			header('Location: '.base_url('login'));
			exit();
		}

		helper(['base','validate','fecha','log']);		
		$this->empresaMdl	= new EmpresaModel();
		$this->membresiaMdl	= new MembresiaModel();

		$session = session();
		$this->session_id = $session->get('usuario')['idqrsession'];

	}

	public function index()
	{
		return view('home/index');
	}

	public function instanciar()
	{
		$data 		= array();
        $idEmpresa 	= $this->session_id;

		$membresiaActual	= $this->membresiaMdl->getMembresiaEmpresaEnUso($idEmpresa)->getRow();
		downPlan($membresiaActual);

        $empresa				= $this->empresaMdl->getEmpresaRow($idEmpresa)->getRow();
        $data['empresa']		= $empresa;
		$data['msnMembresia']  	= avisoMembresia($idEmpresa);

		// //GET QR
		$qr = $this->empresaMdl->getEmpresaQRRow($idEmpresa)->getRow();
		$data['qr'] = $qr->EMP_QR_IMG;
        
        return $this->response->setJSON($data);
	}
	
	public function help()
	{
        $this->load->view('layouts/help/header');
        $this->load->view('home/help');
        $this->load->view('layouts/help/footer');
	}
	
}
