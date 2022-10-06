<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends CI_Controller {
	
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
		$data 		= array();
        $idEmpresa 	= $this->session_id;

		$data['asuntos']   = array(
									array(
										'value'		=> "CONSULTA",
										'detalle' 	=> "CONSULTAS GENERALES DE TODO TIPO, DUDAS, AYUDA, ETC."
									),								
									array(
										'value'		=> "PROBLEMAS EN EL SISTEMA",
										'detalle'  	=> "CUÉNTANOS QUE PROBLEMA ESTÁ OCURRIENDO EN LA PLATAFORMA, Y LO SOLUCIONAREMOS A LA BREVEDAD"
									),									
									array(
										'value'		=> "RECLAMO",
										'detalle'  	=> "CUÉNTANOS EN QUE TE PODÉMOS AYUDAR PARA SOLUCIONAR TU PROBLEMA"
									),
									array(
										'value'		=> "MEJORAS",
										'detalle' 	=> "CUÉNTANOS QUE IDEA TIENES PARA MEJORAR TU EXPERIENCIA Y LA DE TUS USUARIOS"
									),
									array(
										'value'		=> "PROBLEMAS CON EL PAGO",
										'detalle' 	=> "SI HAS TENIDO PROBLEMAS CON TU PAGO O TU MEMBRESÍA, TE AYUDAREMOS"
									),
									array(
										'value'		=> "FELICITACIONES",
										'detalle' 	=> "SI NOS DESES FELICITAR, ESTAREMOS FELICES DE ESCUCHAR TUS COMENTARIOS"
									),
									array(
										'value'		=> "SERVICIO DE ADMINISTRACIÓN",
										'detalle' 	=> "SI TIENES CONTRATADO UN PLAN CON ESTE SERVICIOS, CUÉNTANOS QUE DESEAS ACTUALIZAR Y LO HAREMOS A LA BREVEDAD"
									),
								);
        
        echo json_encode($data);
	}

	public function send()
	{
		$data		= array();
		$idEmpresa	= $this->session_id;
		$request	= json_decode(file_get_contents('php://input'));
		$asunto		= $request->asunto; 
		$mensaje	= $request->mensaje;
		$empresa	= $this->empresa_model->getEmpresaRow($idEmpresa);
		$membresia	= $this->membresia_model->getMembresiaEmpresaEnUso($idEmpresa);

		//PASA A PHPMAILER
		$exito = email_formulario($empresa->EMPRESA_NOMBRE,$empresa->EMPRESA_EMAIL,$membresia->MEMBRESIA_NOMBRE,$mensaje,$asunto);

		//ERROR DE ENVÍO
		$data['ok']	= $exito ? true : false;

		echo json_encode($data);		
	}
	
}
