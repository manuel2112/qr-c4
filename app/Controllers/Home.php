<?php

namespace App\Controllers;
// require APPPATH.'third_party/endroid_qrcode/autoload.php';
		
// use Endroid\QrCode\ErrorCorrectionLevel;
// use Endroid\QrCode\QrCode;

class Home extends BaseController {
	
	public function __construct()
	{
		// parent::__construct();
		// if (!$this->session->userdata('idqrsession')) {
		// 	$this->session->set_userdata('', current_url());
		// 	redirect(base_url('login'));
		// }
		// $this->session_id 			= $this->session->userdata('idqrsession');
		// $this->session_nmb 			= $this->session->userdata('nmbqrsession');
		// $this->isadminqrsession 	= $this->session->userdata('isadminqrsession');
	}

	public function index()
	{
		$this->layout->view('index');
	}

	public function instanciar()
	{
		$data 		= array();
        $idEmpresa 	= $this->session_id;

		$membresiaActual	= $this->membresia_model->getMembresiaEmpresaEnUso($idEmpresa);
		downPlan($membresiaActual);

        $empresa				= $this->empresa_model->getEmpresaRow($idEmpresa);
        $data['empresa']		= $empresa;
		$data['msnMembresia']  	= avisoMembresia($idEmpresa);

		//GET QR
		$qr = $this->empresa_model->getEmpresaQRRow($idEmpresa);
		$data['qr'] = $qr->EMP_QR_IMG;
        
        echo json_encode($data);
	}
	
	public function help()
	{
        $this->load->view('layouts/help/header');
        $this->load->view('home/help');
        $this->load->view('layouts/help/footer');
	}
	
}
