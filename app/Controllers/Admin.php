<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
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
		$data['regiones'] = $this->ciudad_model->getRegion();
		$this->layout->view('index',$data);
	}

	public function instanciar()
	{
		$data = array();
		$data['empresas']	= $this->empresa_model->getEmpresas();

        echo json_encode($data);
	}
    
    public function getEmpresa()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa	= trim($request->idEmpresa);

        $empresa = $this->empresa_model->getEmpresaRow($idEmpresa);
		
		$data['empresa']    = $empresa;
        
		$data['ok'] = true;		
		echo json_encode($data);
	}
    
    public function getDatos()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa	= trim($request->idEmpresa);

        $empresa    = $this->empresa_model->getEmpresaRow($idEmpresa);
		$qr         = $this->empresa_model->getEmpresaQRRow($idEmpresa);

        $data['slug']   = urlQR().$empresa->EMPRESA_SLUG;
		$data['qr']     = base_url().$qr->EMP_QR_IMG;
        
		$data['ok'] = true;		
		echo json_encode($data);
	}
    
    public function getAcciones()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa	= trim($request->idEmpresa);

        $data['acciones'] = $this->accion_model->getAccion($idEmpresa);
        
		$data['ok'] = true;		
		echo json_encode($data);
	}
    
    public function getPlan()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa	= trim($request->idEmpresa);
		$membresias	= $this->membresia_model->getMembresiasAll($idEmpresa);

		$data['vistas']		= planActual($idEmpresa);
		$data['membresias']	= $membresias;

		$data['ok'] = true;		
		echo json_encode($data);
	}
    
    public function getPlanes()
	{
		$data 		= array();
		$data['ok'] = false;
		
		$data['planes']	= $this->membresia_model->getMembresias();

		$data['ok'] = true;		
		echo json_encode($data);
	}
    
    public function insertGift()
	{
		$data 		= array();
		$data['ok'] = false;
		$request 	= json_decode(file_get_contents('php://input'));
		$mdl		= $request->mdl;
		$password	= $request->password;

		if( $password == fechaNowPermiso()){
			calcularMembresia($mdl);
			$data['ok'] = true;
		}
				
		echo json_encode($data);
	}

	public function getMenu()
	{
		$data 		= array();
		$arreglo 	= array();
		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa	= trim($request->idEmpresa);

		$grupos 		= $this->menu_model->getGrupoPorEmpresa($idEmpresa);
		$data['plan'] 	= $this->membresia_model->getMembresiaEmpresaEnUso($idEmpresa);

		$i = 0;
		foreach( $grupos as $grupo ){
			$arreglo[$i]['GRUPO'] = $grupo;
			$productos = $this->menu_model->getProductoPorGrupo($grupo->GRUPO_ID);
			$arreglo[$i]['COUNT_PRODUCTOS'] = count($productos);

			foreach( $productos as $producto ){
				$arreglo[$i]['PRODUCTOS'][] = $producto;
			}
			$i++;
		}

		$data['grupos'] = $arreglo;
        echo json_encode($data);
	}
	
	public function orderGrupo()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input')); 
		$idEmpresa	= $request->idEmpresa;
		$grupos 	= $request->grupos;

		$i = $this->menu_model->getCountProductos($idEmpresa);
		foreach( $grupos as $grupo ){
			$this->menu_model->updateGrupoCampo($grupo->GRUPO->GRUPO_ID, 'GRUPO_ORDEN', $i--);
		}
		
		insertAccion($idEmpresa, 9, null, null);
		$data['ok'] = true;
        echo json_encode($data);
	}

	public function insertGrupo()
	{
		$data  		= array();
		$imgRuta	= null;
		$data['ok'] = false;

        $idEmpresa 		= $this->input->post("idEmpresa",true);
        $grupo    		= $this->input->post("grupo",true);
        $widthResize	= $this->input->post("widthResize",true);
        $coords			= json_decode($this->input->post("coords",true));
	
		//VALIDAR IMAGEN
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "upload/empresas/".$idEmpresa."/grupo";
			$prefijo	= "grupo";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize,TRUE);
		}

		//INSERT GRUPO
		$idGrupo = $this->menu_model->insertGrupo($idEmpresa,$grupo,$imgRuta);
		
		insertAccion($idEmpresa, 7, $idGrupo, null);
		$data['ok'] = true;
        echo json_encode($data);
	}

	public function editGrupo()
	{
		$data  		= array();
		$imgRuta	= null;
		$data['ok'] = false;

		$idEmpresa 		= $this->input->post("idEmpresa",true);
        $grupo    		= json_decode(stripslashes($this->input->post("grupo",true)));
        $widthResize	= $this->input->post("widthResize",true);
        $coords			= json_decode($this->input->post("coords",true));

		$idGrupo	= $grupo->GRUPO_ID;
		$nmbGrupo	= $grupo->GRUPO_NOMBRE_EDIT;

		//EDIT GRUPO
		$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_NOMBRE', $nmbGrupo);

		if( $grupo->GRUPO_IMG_EDIT == '' ){
			$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_IMG', $imgRuta);
			deleteFile($grupo->GRUPO_IMG);
		}
	
		//INSERT IMAGEN		
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "upload/empresas/".$idEmpresa."/grupo";
			$prefijo	= "grupo";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize,TRUE);
			if( $imgRuta != '' ){
				$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_IMG', $imgRuta);
			}			
		}
		
		insertAccion($idEmpresa, 8, $idGrupo, null);
		$data['ok'] = true;
        echo json_encode($data);
	}
	
	public function orderProductos()
	{
		$data 		= array();
		$data['ok'] = false;

		$request	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$productos 	= $request->productos;

		$i = count($productos);
		foreach( $productos as $producto ){
			$this->menu_model->updateProductoCampo($producto->PRODUCTO_ID , 'PRODUCTO_ORDEN', $i--);
		}

		$data['ok'] = true;
        echo json_encode($data);
	}

	public function grupoHidden()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$idGrupo	= $request->idGrupo;
		$value		= $request->value;
		$nuevoValor	= $value == 1 ? 0 : 1;
		
		$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_SHOW', $nuevoValor);

		insertAccion($idEmpresa, 10, $idGrupo, null);		
		$data['ok'] = true;		
		echo json_encode($data);		
	}

	public function grupoDelete()
	{
		$data		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$idGrupo	= $request->idGrupo;
		
		$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_FLAG', false);

		insertAccion($idEmpresa, 11, $idGrupo, null);
		$data['ok'] = true;		
		echo json_encode($data);		
	}

	public function editProducto()
	{
		$data  		= array();
		$data['ok'] = false;		
		
		$idEmpresa 	= $this->input->post("idEmpresa",FALSE);
        $producto	= json_decode($this->input->post("producto",FALSE));
		$idProducto = $producto->PRODUCTO_ID;
        $detalle	= $producto->PRODUCTO_DET ? $producto->PRODUCTO_DET : null;
        $desc		= $producto->PRODUCTO_DESC ? $producto->PRODUCTO_DESC : null;

		//EDIT PRODUCTO
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_NOMBRE', $producto->PRODUCTO_NOMBRE);
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_DET', $detalle);
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_DESC', $desc);

		insertAccion($idEmpresa, 14, null, $idProducto);
		$data['ok'] = true;
        echo json_encode($data);
	}

	public function getProducto()
	{
		$data 		= array();
		$arreglo 	= array();

		$request 	= json_decode(file_get_contents('php://input'));
		$idProducto	= $request->idProducto;
		$limit		= $request->limit;

		$data['vps']		= $this->menu_model->getVariacionPorProducto($idProducto);
		$data['imagenes']	= $this->menu_model->getImgPorProducto($idProducto,$limit);
		
        echo json_encode($data);
	}

	public function editVP()
	{
		$data  		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$idProducto	= $request->idProducto;
		$vps		= json_decode($request->vps);

		//DELETE VP EXISTENTES
		$this->menu_model->deleteVariacionPorProducto($idProducto);

		//INSERT PRECIO VARIABLE
		$base = true;
		foreach( $vps as $v ){
			if( $base ){
				$nmbProducto = $v->nombre ? $v->nombre : null;
				$this->menu_model->insertVariacionProducto($idProducto,$nmbProducto,$v->valor,$base);
			}else{
				if( $v->nombre && $v->valor ){
					$this->menu_model->insertVariacionProducto($idProducto,$v->nombre,$v->valor,$base);
				}
			}			
			$base = false;
		}

		insertAccion($idEmpresa, 18, null, $idProducto);
		$data['ok'] = true;
        echo json_encode($data);
	}

	public function imagenDelete()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$img		= $request->img;

		$this->menu_model->updateImagenCampo($img->PROIMG_ID, 'PROIMG_FLAG', false);
		deleteFile($img->PROIMG_RUTA);

		insertAccion($idEmpresa, 19, null, null);
		$data['ok'] = true;
		echo json_encode($data);
	}

	public function editGaleriaProductos()
	{
		$data  		= array();
		$data['ok'] = false;
		
		$idEmpresa 		= $this->input->post("idEmpresa",FALSE);
        $idProducto		= $this->input->post("idProducto",true);
        $widthResize	= $this->input->post("widthResize",true);
        $coords			= json_decode($this->input->post("coords",true));

		//INSERTAR IMAGEN
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "upload/empresas/".$idEmpresa."/productos/".$idProducto;
			$prefijo	= "producto";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize);
			if( $imgRuta != '' ){
				$this->menu_model->insertProductoImg($idProducto,$imgRuta);
			}
		}

		insertAccion($idEmpresa, 20, null, $idProducto);
		$data['ok'] = true;
        echo json_encode($data);
	}
	
	public function productoLinkedHidden()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$idProducto	= $request->idProducto;
		$value		= $request->value;
		$nuevoValor	= $value == 1 ? 0 : 1;
		
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_LINKED', $nuevoValor);
		
		insertAccion($idEmpresa, 16, null, $idProducto);
		$data['ok'] = true;		
		echo json_encode($data);		
	}

	public function productoHidden()
	{
		$data 		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$idProducto	= $request->idProducto;
		$value		= $request->value;
		$nuevoValor	= $value == 1 ? 0 : 1;
		
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_SHOW', $nuevoValor);
		
		insertAccion($idEmpresa, 15, null, $idProducto);
		$data['ok'] = true;		
		echo json_encode($data);		
	}

	public function productoDelete()
	{
		$data		= array();
		$data['ok'] = false;

		$request 	= json_decode(file_get_contents('php://input'));
		$idEmpresa 	= $request->idEmpresa;
		$idProducto	= $request->idProducto;
		
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_FLAG', false);

		insertAccion($idEmpresa, 17, null, $idProducto);
		$data['ok'] = true;		
		echo json_encode($data);		
	}

	public function insertProducto()
	{
		$data  		= array();
		$data['ok'] = false;

		$idEmpresa		= $this->input->post("idEmpresa",true);
        $idGrupo    	= $this->input->post("idGrupo",true);
        $producto  		= json_decode($this->input->post("producto",false));
        $vp				= json_decode($this->input->post("vp",false));
        $opt			= json_decode($this->input->post("opt",true));
        $nombre    		= $producto->nombre ? $producto->nombre : null;
        $detalle    	= $producto->detalle ? $producto->detalle : null;
        $descripcion	= $producto->descripcion ? $producto->descripcion : null;
        $widthResize	= $this->input->post("widthResize",true);
        $coords			= json_decode($this->input->post("coords",true));

		//INSERT GRUPO
		$idProducto = $this->menu_model->insertProducto($idGrupo,$nombre,$detalle,$descripcion,$opt->linked,$opt->show);

		//INSERT PRECIO VARIABLE
		$base = true;
		foreach( $vp as $v ){
			$nmbProducto = $v->nombre ? $v->nombre : null;
			$this->menu_model->insertVariacionProducto($idProducto,$nmbProducto,$v->valor,$base);			
			$base = false;
		}
	
		//INSERT IMAGEN		
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "upload/empresas/".$idEmpresa."/productos/".$idProducto;
			$prefijo	= "producto";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize);
			if( $imgRuta != '' ){
				$this->menu_model->insertProductoImg($idProducto,$imgRuta);
			}			
		}

		insertAccion($idEmpresa, 12, null, $idProducto);
		$data['ok'] = true;
        echo json_encode($data);
	}
	
}