<?php

namespace App\Controllers;

use App\Models\CiudadModel;
use App\Models\EmpresaModel;
use App\Models\MembresiaModel;

class Empresa extends BaseController {

	public $ciudad_model;
	public $membresia_model;
	public $empresa_model;
	
	public function __construct()
	{
		if (!session('usuario')) {
			header('Location: '.base_url('login'));
			exit();
		}

		$this->ciudad_model 	= new CiudadModel();
		$this->empresa_model 	= new EmpresaModel();
		$this->membresia_model 	= new MembresiaModel();

		$session = session();
		$this->session_id 		= $session->get('usuario')['idqrsession'];
		$this->session_admin	= $session->get('usuario')['isadminqrsession'];
	}
	
	public function index()
	{
		$data['regiones'] = $this->ciudad_model->getRegiones()->getResult();
		return view('empresa/index',$data);
	}

	public function instanciar()
	{
		$data = array();
		$idEmpresa	= $this->session_id;
		$empresa	= $this->empresa_model->getEmpresaRow($idEmpresa)->getRow();
		$membresias	= $this->membresia_model->getMembresiasPlan($idEmpresa)->getResult();
		
		$data['empresa']	= $empresa;
		$data['edit']		= $empresa;

		$data['vistas']		= countVistas($idEmpresa);
		$data['membresias']	= $membresias;
		$data['permiso']	= $empresa->EMPRESA_MEMBRESIA ? TRUE : FALSE ;
		$data['slugURL']	= urlQR().$empresa->EMPRESA_SLUG;
		
        return $this->response->setJSON($data);
	}

	public function editDatos()
	{
		$data  		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

        $request    	= json_decode(file_get_contents('php://input'));
		$nombre	    	= $request->nombre;
		$fono	    	= $request->fono;
		$direccion	    = $request->direccion;
		$comuna	    	= empty($request->nuevaCiudad) ? $request->comuna : $request->nuevaCiudad;
		$descripcion	= $request->descripcion;
		$slug			= slugify($nombre);
		$slug			= $this->existeSlug($slug);

		//EDITAR DATOS
		$this->empresa_model->updateDatosEmpresa($idEmpresa,$nombre,$fono,$direccion,$descripcion,$comuna,$slug);
		//UPDATE QR
		create_qr($idEmpresa);
		session()->set('usuario', array(
			'idqrsession'  		=> $idEmpresa,
			'nmbqrsession'     	=> $nombre,
			'isadminqrsession' 	=> $this->session_admin
		));

		insertAccion($idEmpresa, 2, null, null);
        $data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function editRedes()
	{
		$data  		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

        $request	= json_decode(file_get_contents('php://input'));
		$whatsapp	= $request->whatsapp;
		$web		= $request->web;
		$facebook	= $request->facebook;
		$instagram	= $request->instagram;

		//EDITAR DATOS
		$this->empresa_model->updateRedesEmpresa($idEmpresa,$whatsapp,$web,$facebook,$instagram);

		insertAccion($idEmpresa, 3, null, null);
        $data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function editPass()
	{
		$data  			= array();
		$data['error'] 	= '';
		$idEmpresa		= $this->session_id;

        $request	= json_decode(file_get_contents('php://input'));
		$pass		= $request->pass;
		$actual		= $request->actual;
		$nueva		= $request->nueva;
		$repetir	= $request->repetir;

		if( $pass != md5($actual) ){
			$data['error'] 	= 'LA CONTASEÑA ACTUAL NO ES CORRECTA.';
			return $this->response->setJSON($data);
			return;
		}
		if( $nueva != $repetir ){
			$data['error'] 	= 'LA NUEVA CONTRASEÑA NO COINCIDE.';
			return $this->response->setJSON($data);
			return;
		}
		if( strlen($nueva) < 7 ){
			$data['error'] 	= 'LA NUEVA CONTRASEÑA DEBE TENER 7 CARACTERES COMO MÍNIMO.';
			return $this->response->setJSON($data);
			return;
		}

		//EDITAR PASSWORD
		$this->empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_PASS', MD5($nueva));

		insertAccion($idEmpresa, 4, null, null);
        $data['error'] = '';
        return $this->response->setJSON($data);
	}
	
	public function existeSlug($slug)
	{
		$query	= $this->empresa_model->updateEmpresaExisteCampo($this->session_id,'EMPRESA_SLUG',$slug);
		$existe = $query > 0 ? true : false;

		if( $existe ){
			$i = 1;
			while( $i <= 100 ){
				$newSlug = $slug.'-'.$i++;
				$query2	= $this->empresa_model->updateEmpresaExisteCampo($this->session_id,'EMPRESA_SLUG',$newSlug);
				$existe2 = $query2 > 0 ? true : false;

				if( !$existe2 ){
					return $newSlug;
				}
			}
		}

		return $slug;

	}

	public function uploadLogo()
	{
		$data 			= array();
		$idEmpresa		= $this->session_id;
		$data['ok'] 	= false;
		$imgRuta		= NULL;
		$widthResize	= $_POST["widthResize"];
		$coords			= json_decode($_POST["coords"]);

		//INSERTAR IMAGEN
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "public/upload/empresas/".$idEmpresa."/logotipo";
			$prefijo	= "logo";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,TRUE,$coords,$widthResize);
			if( $imgRuta != '' ){
				$this->empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_LOGOTIPO', $imgRuta);
			}
			//UPDATE QR
			create_qr($idEmpresa);
		}
		
		insertAccion($idEmpresa, 5, null, null);
		$data['ok'] = true ;
		return $this->response->setJSON($data);
	}

	public function deleteLogo()
	{
		$data		= array();
		$data['ok'] = false;

        $request	= json_decode(file_get_contents('php://input'));
		$idEmpresa	= $request->idEmpresa;

		//DELETE LOGO
		$this->empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_LOGOTIPO', null);
		//UPDATE QR
		create_qr($idEmpresa);

		insertAccion($idEmpresa, 6, null, null);		
        $data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function downPlan()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

        $request		= json_decode(file_get_contents('php://input'));
		$idMembresia	= $request->idMembresia;
		
		//DAR DE BAJA PLAN
		$this->membresia_model->updateMembresiaPorCampo('EMP_MEMB_ID',$idMembresia,'EMP_MEMB_HASTA',fechaDown());
		$mdl = $this->membresia_model->getMembresiaByIDRow( $idMembresia );
		downPlan($mdl);

		//SI HAY MAS PLANES CONTRATADOS ACTUALIZAR FECHA
		updatePlanes($idEmpresa);

		insertAccion($idEmpresa, 21, null, null);
        $data['ok'] = true;
        return $this->response->setJSON($data);
	}
	
	public function getVistas()
	{
		$data		= array();
		$data['ok'] = false;

		$data['vistas'] = planActual($this->session_id);
		
        $data['ok'] = true;
        return $this->response->setJSON($data);
	}
	
	public function help()
	{
        $this->load->view('layouts/help/header');
        $this->load->view('empresa/help');
        $this->load->view('layouts/help/footer');
	}
	
}