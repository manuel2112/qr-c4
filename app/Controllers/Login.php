<?php

namespace App\Controllers;
use App\Models\LoginModel;
use App\Models\CiudadModel;
use App\Models\EmpresaModel;

class Login extends BaseController {
	
	public $login_model;
	public $ciudad_model;
	public $empresa_model;

    public function __construct()
    {
		helper(['fecha']);
		$this->login_model 	= new LoginModel();
		$this->ciudad_model 	= new CiudadModel();
		$this->empresa_model	= new EmpresaModel();
		
		//EDITAR PASSWORD ADMIN
		$this->login_model->editPassAdmin(md5(fechaNowPass()));
    }	

	public function index()
	{
		if ( $this->session->get('usuario') ) {
			return redirect()->to(base_url());
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
				
		$data['regiones'] = $this->ciudad_model->getRegiones()->getResult();
		return view('login/index',$data);
	}
	
	public function login()
	{
		$data  		= array();

        $request	= json_decode(file_get_contents('php://input'));
		$user	    = $request->login->user;
		$pass  		= md5($request->login->pass);

		$res = $this->login_model->getLoginRow($user,$pass)->getRow();

		$data['existe'] 	= $res ? true : false;
		$data['permiso'] 	= $res && ($res->EMPRESA_STATUS == 1) ? true : false;

		//CREAR SESION
		if( $res ){
			session()->set('usuario', array(
				'idqrsession'  		=> $res->EMPRESA_ID,
				'nmbqrsession'     	=> $res->EMPRESA_NOMBRE,
				'isadminqrsession' 	=> $res->EMPRESA_ADMIN,
			));
			insertAccion($res->EMPRESA_ID, 1, null, null);
			$data['URL']	= base_url();
		}

		return $this->response->setJSON($data);
	}

    public function logout()
	{
		$this->session->remove('usuario');
		$this->session->destroy();
		return redirect()->to(base_url('login'));
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

		//ERROR DE ENV??O
		$data['ok']	= $exito ? TRUE : FALSE;

		return $this->response->setJSON($data);	
		
	}

	public function recuperarpass()
	{
		$data			= array();
		$data['ok'] 	= FALSE;
		$data['existe']	= FALSE;
		$request		= json_decode(file_get_contents('php://input')); 
		$recuperar		= $request->recuperar;
		$email			= $recuperar->email;

		$empresa = $this->empresa_model->getEmpresaExisteCampoRow('EMPRESA_EMAIL',$email)->getRow();

		if( !$empresa ){
			$data['existe'] = true;
			return $this->response->setJSON($data);
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

		$data['send'] 	= $exito ? TRUE: FALSE;
		$data['ok'] 	= TRUE;
		$data['xxx'] 	= $urlRec;

		return $this->response->setJSON($data);		
	}
	
	public function recpass()
	{
		return view('login/recpass');
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

		$empresa = $this->empresa_model->getEmpresaNewPass($email,$hash)->getRow();

		if( !$empresa ){
			$data['valido'] = false;
			return $this->response->setJSON($data);
		}

		$idEmpresa 	= $empresa->EMPRESA_ID;
		$campo 		= 'EMPRESA_PASS';
		$valor 		= MD5($pass01);
		$this->empresa_model->updateEmpresaCampo($idEmpresa, $campo, $valor);

		$data['ok'] = true;
		return $this->response->setJSON($data);
	}
}