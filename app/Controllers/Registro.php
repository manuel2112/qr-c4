<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\EmpresaModel;

class Registro extends BaseController {

	public $empresaMdl;
	public $menuMdl;
	
	public function __construct()
	{
		helper(['validate','string','random','fecha','qr','base','file','instanciar','email','emailBody']);
		$this->empresaMdl = new EmpresaModel();
		$this->menuMdl = new MenuModel();
	}

	public function index()
	{
		$this->layout->view('index');
	}

	public function ingreso()
	{
		$data  				= array();
		$data['ok'] 		= false;
		$data['errormail'] 	= false;

        $request    	= json_decode(file_get_contents('php://input'));
		$nombre	    	= $request->registro->nombre;
		$direccion  	= !empty($request->registro->direccion) ? $request->registro->direccion : null ;
		$ciudad	    	= $request->registro->ciudad;
		$fono	    	= $request->registro->fono;
		$email	    	= $request->registro->email;
		$pass	    	= md5($request->registro->pass01);
		$referido		= $request->registro->referido;
		$responsable	= $request->registro->responsable;

		$slug		= slugify($nombre);
		$slug		= $this->existeSlug($slug);
		$ingreso 	= fechaNow();
		$isAdmin	= false;
		$membresia	= true;
		$codReg		= generaRandom();

		$existeEmail = existeEmailRegistro($email);

		if( !$existeEmail ){
			
			//INGRESAR Y VALIDAR DATOS
			$insert = [
				'EMPRESA_NOMBRE'		=> $nombre,
				'EMPRESA_DIRECCION'		=> $direccion,
				'EMPRESA_FONO'		    => $fono,
				'EMPRESA_EMAIL'		    => $email,
				'EMPRESA_PASS'		    => $pass,
				'EMPRESA_SLUG'		    => $slug,
				'CIUDAD_ID'			    => $ciudad,
				'EMPRESA_INGRESO'	    => $ingreso,
				'EMPRESA_ADMIN'		    => $isAdmin,
				'EMPRESA_MEMBRESIA'	    => $membresia,
				'EMPRESA_COD_REG'	    => $codReg,
				'EMPRESA_REFERIDO'      => $referido,
				'EMPRESA_RESPONSABLE'	=> $responsable
			];
			$idEmpresa = $this->empresaMdl->insertEmpresa($insert);
	
			//CREATE QR
			create_qr($idEmpresa);
	
			// //INSTANCIAR MENÚ
			$this->instanciarMenu($idEmpresa);
	
			//REGALAR PLAN PLATA
			instanciarPlan($idEmpresa,$ingreso,2);
	
			//ENVIAR EMAIL PARA DAR EL ALTA
			$urlCodReg = urlAdmin()."login?cod=".$codReg;
			email_registro($nombre,$email,$urlCodReg);

			$data['ok'] = true;

		}else{
			$data['errormail'] = true;
		}

		return $this->response->setJSON($data);
	}

	public function existeEmail()
	{
		$data  		= array();
        $request    = json_decode(file_get_contents('php://input'));
		$email	    = $request->email;
		
		$data['existe'] = existeEmailRegistro($email);

        return $this->response->setJSON($data);

	}
	
	public function existeSlug($slug)
	{
		$query  = $this->empresaMdl->getEmpresaExisteCampo('EMPRESA_SLUG',$slug)->getResult();
		$existe = count($query) > 0 ? TRUE : FALSE;

		if( $existe ){
			$i = 1;
			while( $i <= 100 ){
				$newSlug = $slug.'-'.$i++;				
				$query2 = $this->empresaMdl->getEmpresaExisteCampo('EMPRESA_SLUG',$newSlug)->getResult();
				$existe2 = count($query2) > 0 ? TRUE : FALSE;

				if( !$existe2 ){
					return $newSlug;
				}
			}
		}

		return $slug;

	}
	
	// public function nuevoSlug($slug,$i)
	// {
	// 	$newSlug = $slug.$i;
	// 	existeSlug($slug,++$i);
	// }
	
	public function instanciarMenu($idEmpresa)
	{
		//INSTANCIAR MENÚ
		$json = menuInstanciar();
		$data = json_decode($json,true);

		foreach($data as $item) {

			$imgGrupo = $item['imagen'] ? $item['imagen'] : null;
			$dataGrupo = array(
				'GRUPO_NOMBRE'	=> $item['grupo'],
				'GRUPO_IMG'	    => $imgGrupo,
				'EMPRESA_ID'    => $idEmpresa
			  );
			  
			$idGrupo = $this->menuMdl->insertGrupo($dataGrupo);

			foreach( $item['producto'] as $producto ){
				$dataProducto = array(
                    'GRUPO_ID'        => $idGrupo,
                    'PRODUCTO_NOMBRE' => $producto['nombre'],
                    'PRODUCTO_DET'    => $producto['detalle'],
                    'PRODUCTO_DESC'   => $producto['descripcion'],
                    'PRODUCTO_LINKED' => $producto['link'],
                    'PRODUCTO_SHOW'   => $producto['show']
                  );
				$idProducto = $this->menuMdl->insertProductoInt($dataProducto);

				foreach( $producto['precios'] as $precio ){
					$dataPrecios = array(
						'PROVAR_NOMBRE' => $precio['nombre'],
						'PROVAR_VALOR'  => $precio['valor'],
						'PROVAR_BASE'   => $precio['base'],
						'PRODUCTO_ID'   => $idProducto,
						'PROVAR_SHOW'   => $precio['show']
					  );
					$this->menuMdl->insertVariacionProductoIns($dataPrecios);
				}

				foreach( $producto['imagenes'] as $imagen ){
					$dataImagen = array(
						'PRODUCTO_ID' => $idProducto,
						'PROIMG_RUTA' => $imagen['imagen']
					  );
					$this->menuMdl->insertProductoImg($dataImagen);
				}

			}

		}

	}	
	
}
