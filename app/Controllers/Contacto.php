<?php

namespace App\Controllers;

use App\Models\EmpresaModel;
use App\Models\MembresiaModel;

class Contacto extends BaseController {

	public $empresa_model;
	public $membresia_model;
	
	public function __construct()
	{
		if (!session('usuario')) {
			header('Location: '.base_url('login'));
			exit();
		}

		$this->empresa_model 	= new EmpresaModel();
		$this->membresia_model 	= new MembresiaModel();

		$session = session();
		$this->session_id 		= $session->get('usuario')['idqrsession'];
	}
	
	public function index()
	{
		return view('contacto/index');
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
        
        return $this->response->setJSON($data);
	}

	public function send()
	{
		$data		= array();
		$idEmpresa	= $this->session_id;
		$request	= json_decode(file_get_contents('php://input'));
		$asunto		= $request->asunto; 
		$mensaje	= $request->mensaje;
		$empresa	= $this->empresa_model->getEmpresaRow($idEmpresa)->getRow();
		$membresia	= $this->membresia_model->getMembresiaEmpresaEnUso($idEmpresa)->getRow();

		//PASA A PHPMAILER
		$exito = email_formulario($empresa->EMPRESA_NOMBRE,$empresa->EMPRESA_EMAIL,$membresia->MEMBRESIA_NOMBRE,$mensaje,$asunto);

		//ERROR DE ENVÍO
		$data['ok']	= $exito ? true : false;

		return $this->response->setJSON($data);		
	}
	
}
