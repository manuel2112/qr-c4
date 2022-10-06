<?php

namespace App\Controllers;
use App\Models\LoginModel;
use App\Models\CiudadModel;

class Login extends BaseController {

	public $session;
	public $ciudadMdl;

    public function __construct()
    {
		helper(['fecha','base','form']);
		$this->session = \Config\Services::session();
		$loginMdl = new LoginModel();
		$this->ciudadMdl = new CiudadModel();
		//EDITAR PASSWORD ADMIN
		$loginMdl->editPassAdmin(md5(fechaNowPass()));
    }	

	public function index()
	{
		if ( $this->session->get('idqrsession') ) {
			redirect(base_url());
		}

		$data['registro'] = false;
		if ( isset($_GET['cod']) ){
			
			$codigo = $_GET['cod'];
			$query = $this->empresa_model->getEmpresaExisteCampo('EMPRESA_COD_REG',$codigo);
			$existe = $query > 0 ? true : false;
			
			if( $existe ){
				$this->empresa_model->updateEmpresaPermiso( $codigo );
				$data['registro'] = true;
			}
		}
				
		$data['regiones'] = $this->ciudadMdl->getRegiones()->getResult();
		return view('login/index',$data);
	}
	
	public function login()
	{
		$data  		= array();

        $request	= json_decode(file_get_contents('php://input'));
		$user	    = $request->login->user;
		$pass  		= md5($request->login->pass);

		$res = $this->login_model->getLoginRow($user,$pass);

		$data['existe'] 	= $res ? true : false;
		$data['permiso'] 	= $res && ($res->EMPRESA_STATUS == 1) ? true : false;

		//CREAR SESION
		if( $res ){
			$this->session->set_userdata("idqrsession", $res->EMPRESA_ID);
			$this->session->userdata('idqrsession');
			$this->session->set_userdata("nmbqrsession", $res->EMPRESA_NOMBRE);
			$this->session->userdata('nmbqrsession');
			$this->session->set_userdata("isadminqrsession", $res->EMPRESA_ADMIN);
			$this->session->userdata('isadminqrsession');
			insertAccion($res->EMPRESA_ID, 1, null, null);
			$data['URL']	= base_url();
		}

		echo json_encode($data);
	}

    public function logout()
	{
		$this->session->unset_userdata('idqrsession');
		$this->session->unset_userdata('nmbqrsession');
		$this->session->unset_userdata('isadminqrsession');
		$this->session->sess_destroy();
		redirect(base_url().'login', 301);
	}

	public function referido()
	{
		$data = array();

		$data['referidos']   = array(
									array(
										'value'	=> "POR UN REFERIDO (TE INVITARON A INGRESAR)",
										'bool' 	=> true,
										'nombre' 	=> ''
									),
									array(
										'value'	=> "SITIO WEB",
										'bool' 	=> false,
										'nombre' 	=> ''
									),
									array(
										'value'	=> "GOOGLE",
										'bool' 	=> false,
										'nombre' 	=> ''
									),
									array(
										'value'	=> "MAILLING",
										'bool' 	=> false,
										'nombre' 	=> ''
									),
									array(
										'value'	=> "REDES SOCIALES",
										'bool' 	=> false,
										'nombre' 	=> ''
									),
								);
        
        return $this->response->setJSON($data);
	}

	public function contacto()
	{
		$data		= array();
		$request	= json_decode(file_get_contents('php://input')); 
		$contacto	= $request->contacto;
		$nombre		= $contacto->nombre;
		$email		= $contacto->email;
		$mensaje	= $contacto->mensaje;

		//PASA A PHPMAILER
		$exito = formulario_contacto($nombre,$email,$mensaje);

		//ERROR DE ENVÍO
		$data['ok']	= $exito ? TRUE : FALSE;

		echo json_encode($data);
		
	}

	public function recuperarpass()
	{
		$data			= array();
		$data['existe']	= false;
		$request		= json_decode(file_get_contents('php://input')); 
		$recuperar		= $request->recuperar;
		$email			= $recuperar->email;

		$empresa = $this->empresa_model->getEmpresaExisteCampoRow('EMPRESA_EMAIL',$email);

		if( !$empresa ){
			$data['existe'] = true;
			echo json_encode($data);
			exit();
		}

		$idEmpresa 	= $empresa->EMPRESA_ID;
		$email 		= $empresa->EMPRESA_EMAIL;
		$nombre		= $empresa->EMPRESA_NOMBRE;
		$campo 		= 'EMPRESA_REC_PASS';
		$codRec 	= generaRandom();
		$this->empresa_model->updateEmpresaCampo($idEmpresa, $campo, $codRec);

		$codAttr	= "u=$email&h=$codRec";
		$urlRec		= base_url('login/recpass?'.$codAttr);

		$exito = email_recuperaracion($email,$nombre,$urlRec);

		$data['ok'] = $exito ? TRUE: FALSE;

		echo json_encode($data);		
	}
	
	public function recpass()
	{		
		$data['regiones'] = $this->ciudad_model->getRegion();
		$this->load->view('login/recpass',$data);
	}

	public function changepass()
	{
		$data			= array();
		$data['ok']		= false;
		$data['valido']	= true;
		$request		= json_decode(file_get_contents('php://input')); 
		$pass			= $request->pass;
		$pass01			= $pass->pass01;
		$email			= $pass->u;
		$hash			= $pass->h;

		$empresa = $this->empresa_model->getEmpresaNewPass($email,$hash);

		if( !$empresa ){
			$data['valido'] = false;
			echo json_encode($data);
			exit();
		}

		$idEmpresa 	= $empresa->EMPRESA_ID;
		$campo 		= 'EMPRESA_PASS';
		$valor 		= MD5($pass01);
		$this->empresa_model->updateEmpresaCampo($idEmpresa, $campo, $valor);

		$data['ok'] = true;
		echo json_encode($data);		
	}
}