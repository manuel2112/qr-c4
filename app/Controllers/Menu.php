<?php

namespace App\Controllers;

use App\Models\MembresiaModel;
use App\Models\MenuModel;

class Menu extends BaseController {

	public $menu_model;
	public $membresia_model;
	
	public function __construct()
	{
		if (!session('usuario')) {
			header('Location: '.base_url('login'));
			exit();
		}

		$this->menu_model 		= new MenuModel();
		$this->membresia_model 	= new MembresiaModel();

		$session = session();
		$this->session_id 		= $session->get('usuario')['idqrsession'];
	}
	
	public function index()
	{
		if( !tieneMembresia($this->session_id) ){
			session()->setFlashdata('sinMembresia', true);
			return redirect()->to(base_url('pagos'));
		}

		return view('menu/index');
	}

	public function instanciar()
	{
		$data 		= array();
		$arreglo 	= array();
		$idEmpresa	= $this->session_id;

		$grupos 		= $this->menu_model->getGrupoPorEmpresa($idEmpresa)->getResult();
		$data['plan'] 	= $this->membresia_model->getMembresiaEmpresaEnUso($idEmpresa)->getRow();

		$i = 0;
		foreach( $grupos as $grupo ){
			$arreglo[$i]['GRUPO'] = $grupo;
			$productos = $this->menu_model->getProductoPorGrupo($grupo->GRUPO_ID)->getResult();
			$arreglo[$i]['COUNT_PRODUCTOS'] = count($productos);

			foreach( $productos as $producto ){
				$arreglo[$i]['PRODUCTOS'][] = $producto;
			}
			$i++;
		}

		$data['grupos'] = $arreglo;
        return $this->response->setJSON($data);
	}

	public function insertGrupo()
	{
		$data  		= array();
		$idEmpresa	= $this->session_id;
		$imgRuta	= null;
		$data['ok'] = false;

        $grupo    		= $_POST["grupo"];
        $widthResize	= $_POST["widthResize"];
        $coords			= json_decode($_POST["coords"]);
	
		//VALIDAR IMAGEN
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "public/upload/empresas/".$idEmpresa."/grupo";
			$prefijo	= "grupo";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize,TRUE);
		}

		//INSERT GRUPO
		$dataGrupo = array(
			'GRUPO_NOMBRE'	=> $grupo,
			'GRUPO_IMG'	    => $imgRuta,
			'EMPRESA_ID'    => $idEmpresa
		  );		  
		$idGrupo = $this->menu_model->insertGrupo($dataGrupo);

		insertAccion($idEmpresa, 7, $idGrupo, null);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function editGrupo()
	{
		$data  		= array();
		$idEmpresa	= $this->session_id;
		$imgRuta	= null;
		$data['ok'] = false;
        
        $grupo    		= json_decode(stripslashes($_POST["grupo"]));
        $widthResize	= $_POST["widthResize"];
        $coords			= json_decode($_POST["coords"]);

		$idGrupo	= $grupo->GRUPO_ID;
		$nmbGrupo	= $grupo->GRUPO_NOMBRE_EDIT;

		//EDIT GRUPO
		$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_NOMBRE', $nmbGrupo);

		if( $grupo->GRUPO_IMG_EDIT == '' ){
			$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_IMG', $imgRuta);
			$grupo->GRUPO_IMG ? deleteFile($grupo->GRUPO_IMG) : '';
		}
	
		//INSERT IMAGEN		
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "public/upload/empresas/".$idEmpresa."/grupo";
			$prefijo	= "grupo";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize,TRUE);
			if( $imgRuta != '' ){
				$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_IMG', $imgRuta);
			}			
		}

		insertAccion($idEmpresa, 8, $idGrupo, null);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}
	
	public function orderGrupo()
	{
		$data 		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request = json_decode(file_get_contents('php://input')); 
		$grupos = $request->grupos;

		$i = $this->menu_model->getCountProductos($idEmpresa);
		foreach( $grupos as $grupo ){
			$this->menu_model->updateGrupoCampo($grupo->GRUPO->GRUPO_ID, 'GRUPO_ORDEN', $i--);
		}
		
		insertAccion($idEmpresa, 9, null, null);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function grupoHidden()
	{
		$data 		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request 	= json_decode(file_get_contents('php://input'));
		$idGrupo	= trim($request->idGrupo);
		$value		= trim($request->value);
		$nuevoValor	= $value == 1 ? 0 : 1;
		
		$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_SHOW', $nuevoValor);

		insertAccion($idEmpresa, 10, $idGrupo, null);		
		$data['ok'] = true;		
		return $this->response->setJSON($data);		
	}

	public function grupoDelete()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request 	= json_decode(file_get_contents('php://input'));
		$idGrupo	= trim($request->idGrupo);
		
		$this->menu_model->updateGrupoCampo($idGrupo, 'GRUPO_FLAG', false);

		insertAccion($idEmpresa, 11, $idGrupo, null);
		$data['ok'] = true;		
		return $this->response->setJSON($data);		
	}

	public function insertProducto()
	{
		$data  		= array();
		$data['ok'] = false;

		$idEmpresa		= $this->session_id;
        $idGrupo    	= $_POST['idGrupo'];
        $producto  		= json_decode($_POST['producto']);
        $vp				= json_decode($_POST['vp']);
        $opt			= json_decode($_POST['opt']);
        $nombre    		= $producto->nombre ? $producto->nombre : null;
        $detalle    	= $producto->detalle ? $producto->detalle : null;
        $descripcion	= $producto->descripcion ? $producto->descripcion : null;
        $widthResize	= $_POST['widthResize'];
        $coords			= json_decode($_POST['coords']);

		//INSERT PRODUCTO
		$dataProducto = array(
			'GRUPO_ID'        => $idGrupo,
			'PRODUCTO_NOMBRE' => $nombre,
			'PRODUCTO_DET'    => $detalle,
			'PRODUCTO_DESC'   => $descripcion,
			'PRODUCTO_LINKED' => $opt->linked,
			'PRODUCTO_SHOW'   => $opt->show
		  );		  
		$idProducto = $this->menu_model->insertProducto($dataProducto);

		//INSERT PRECIO VARIABLE
		$base = true;
		foreach( $vp as $v ){
			$nmbProducto = $v->nombre ? $v->nombre : null;
			$dataVP = array(
				'PROVAR_NOMBRE' => $nmbProducto,
				'PROVAR_VALOR'  => $v->valor,
				'PROVAR_BASE'   => $base,
				'PRODUCTO_ID'   => $idProducto
			  );		  
			$this->menu_model->insertVariacionProducto($dataVP);			
			$base = false;
		}
	
		//INSERT IMAGEN		
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "public/upload/empresas/".$idEmpresa."/productos/".$idProducto;
			$prefijo	= "producto";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize);
			if( $imgRuta != '' ){
				$dataImagen = array(
					'PRODUCTO_ID' => $idProducto,
					'PROIMG_RUTA' => $imgRuta
				  );
				$this->menu_model->insertProductoImg($dataImagen);
			}			
		}

		insertAccion($idEmpresa, 12, null, $idProducto);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}
	
	public function orderProductos()
	{
		$data 		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request = json_decode(file_get_contents('php://input')); 
		$productos = $request->productos;

		$i = count($productos);
		foreach( $productos as $producto ){
			$this->menu_model->updateProductoCampo($producto->PRODUCTO_ID , 'PRODUCTO_ORDEN', $i--);
		}
	
		insertAccion($idEmpresa, 13, null, null);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function editProducto()
	{
		$data  		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;
		
        $producto	= json_decode($_POST["producto"]);
		$idProducto = $producto->PRODUCTO_ID;
        $detalle	= $producto->PRODUCTO_DET ? $producto->PRODUCTO_DET : null;
        $desc		= $producto->PRODUCTO_DESC ? $producto->PRODUCTO_DESC : null;

		//EDIT PRODUCTO
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_NOMBRE', $producto->PRODUCTO_NOMBRE);
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_DET', $detalle);
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_DESC', $desc);

		insertAccion($idEmpresa, 14, null, $idProducto);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function productoHidden()
	{
		$data 		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request 	= json_decode(file_get_contents('php://input'));
		$idProducto	= trim($request->idProducto);
		$value		= trim($request->value);
		$nuevoValor	= $value == 1 ? 0 : 1;
		
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_SHOW', $nuevoValor);
		
		insertAccion($idEmpresa, 15, null, $idProducto);
		$data['ok'] = true;		
		return $this->response->setJSON($data);		
	}
	
	public function productoLinkedHidden()
	{
		$data 		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request 	= json_decode(file_get_contents('php://input'));
		$idProducto	= trim($request->idProducto);
		$value		= trim($request->value);
		$nuevoValor	= $value == 1 ? 0 : 1;
		
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_LINKED', $nuevoValor);
		
		insertAccion($idEmpresa, 16, null, $idProducto);
		$data['ok'] = true;		
		return $this->response->setJSON($data);		
	}

	public function productoDelete()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request 	= json_decode(file_get_contents('php://input'));
		$idProducto	= trim($request->idProducto);
		
		$this->menu_model->updateProductoCampo($idProducto, 'PRODUCTO_FLAG', false);

		insertAccion($idEmpresa, 17, null, $idProducto);
		$data['ok'] = true;		
		return $this->response->setJSON($data);		
	}

	public function getProducto()
	{
		$data 		= array();
		$arreglo 	= array();

		$request 	= json_decode(file_get_contents('php://input'));
		$idProducto	= trim($request->idProducto);
		$limit		= trim($request->limit);

		$data['vps']		= $this->menu_model->getVariacionPorProducto($idProducto)->getResult();
		$data['imagenes']	= $this->menu_model->getImgPorProducto($idProducto,$limit)->getResult();
		
        return $this->response->setJSON($data);
	}

	public function editVP()
	{
		$data  		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request 	= json_decode(file_get_contents('php://input'));
		$idProducto	= $request->idProducto;
		$vps		= json_decode($request->vps);

		//DELETE VP EXISTENTES
		$this->menu_model->deleteVariacionPorProducto($idProducto);

		//INSERT PRECIO VARIABLE
		$base = true;
		foreach( $vps as $v ){
			if( $base ){
				$nmbProducto = $v->nombre ? $v->nombre : null;
				$dataVP = array(
					'PROVAR_NOMBRE' => $nmbProducto,
					'PROVAR_VALOR'  => $v->valor,
					'PROVAR_BASE'   => $base,
					'PRODUCTO_ID'   => $idProducto
				  );		  
				$this->menu_model->insertVariacionProducto($dataVP);
			}else{
				if( $v->nombre && $v->valor ){
					$dataVP = array(
						'PROVAR_NOMBRE' => $v->nombre,
						'PROVAR_VALOR'  => $v->valor,
						'PROVAR_BASE'   => $base,
						'PRODUCTO_ID'   => $idProducto
					);		  
					$this->menu_model->insertVariacionProducto($dataVP);
				}
			}			
			$base = false;
		}

		insertAccion($idEmpresa, 18, null, $idProducto);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}

	public function imagenDelete()
	{
		$data		= array();
		$data['ok'] = false;
		$idEmpresa	= $this->session_id;

		$request	= json_decode(file_get_contents('php://input'));
		$img		= $request->img;

		$this->menu_model->updateImagenCampo($img->PROIMG_ID, 'PROIMG_FLAG', false);
		deleteFile($img->PROIMG_RUTA);

		insertAccion($idEmpresa, 19, null, null);
		$data['ok'] = true;
		return $this->response->setJSON($data);
	}

	public function editGaleriaProductos()
	{
		$data  		= array();
		$data['ok'] = false;
		
		$idEmpresa		= $this->session_id;
        $idProducto		= $_POST["idProducto"];
        $widthResize	= $_POST["widthResize"];
        $coords			= json_decode($_POST["coords"]);

		//INSERTAR IMAGEN
		if( isset($_FILES["imagen"]["tmp_name"]) ){
			$imgType 	= $_FILES['imagen']['type'];
			$imgTemp 	= $_FILES['imagen']['tmp_name'];
			$directorio = "public/upload/empresas/".$idEmpresa."/productos/".$idProducto;
			$prefijo	= "producto";
			$imgRuta 	= fileUpload($imgTemp,$imgType,$idEmpresa,$directorio,$prefijo,false,$coords,$widthResize);
			if( $imgRuta != '' ){
				$dataImagen = array(
					'PRODUCTO_ID' => $idProducto,
					'PROIMG_RUTA' => $imgRuta
				  );
				$this->menu_model->insertProductoImg($dataImagen);
			}
		}

		insertAccion($idEmpresa, 20, null, $idProducto);
		$data['ok'] = true;
        return $this->response->setJSON($data);
	}

	/*=============================================
	HELP
	=============================================*/
	
	public function help()
	{
        $this->load->view('layouts/help/header');
        $this->load->view('menu/help');
        $this->load->view('layouts/help/footer');
	}
	
}
