<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class ApiRest extends REST_Controller {
	
	public function __construct()
	{
		
		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header("Access-Control-Allow-Origin: *");
	
		parent::__construct();
				
	}
	
	public function index_post( )
	{
		$data = json_decode( file_get_contents("php://input") );
		$slug = $data->slug;
		$arreglo = array();
		$menu 	 = array();

		$empresa	= $this->empresa_model->getEmpresaSlugRow($slug);

		//EMPRESA NO EXISTENTE
		if( !isset($empresa) ){
			$arreglo['existe']	= FALSE;
			$arreglo['limite']	= FALSE;
			$respuesta = array( 'error' => TRUE, 'info' => $arreglo );
			$this->response($respuesta);
			return;
		}

		//EMPRESA CON VISTAS EXCEDIDO
		if( !$empresa->EMPRESA_VISTA ){
			$arreglo['existe']	= TRUE;
			$arreglo['limite']	= TRUE;
			$respuesta = array( 'error' => TRUE, 'info' => $arreglo );
			$this->response($respuesta);
			return;
		}

		$miembro			= $empresa->EMPRESA_STATUS;
		$arreglo['empresa']	= null;
		$arreglo['menu']	= null;

		if( $miembro ){
			
			$arreglo['empresa']	= $empresa;

			$grupos 	= $this->menu_model->getGrupoPorEmpresaShow($empresa->EMPRESA_ID);
			$plan 		= $this->membresia_model->getMembresiaEmpresaEnUso($empresa->EMPRESA_ID);
			$limitImg	= $plan->MEMBRESIA_IMG;

			$i = 0;
			foreach( $grupos as $grupo ){
				$menu[$i]['GRUPO'] = $grupo;
				$productos = $this->menu_model->getProductoPorGrupoShow($grupo->GRUPO_ID);
				$menu[$i]['COUNT_PRODUCTOS'] = count($productos);

				$j = 0;
				foreach( $productos as $producto ){
					
					$menu[$i]['PRODUCTOS'][] = array( 
														'PRODUCTO_ID'		=> $producto->PRODUCTO_ID, 
														'PRODUCTO_NOMBRE'	=> $producto->PRODUCTO_NOMBRE, 
														'PRODUCTO_DET' 		=> $producto->PRODUCTO_DET, 
														'PRODUCTO_DESC' 	=> $producto->PRODUCTO_DESC, 
														'PRODUCTO_LINKED' 	=> $producto->PRODUCTO_LINKED,
														'PRODUCTO_BASE' 	=> $this->menu_model->getValorBaseProducto($producto->PRODUCTO_ID), 
														'VALORES' 			=> $this->menu_model->getVariacionPorProducto($producto->PRODUCTO_ID), 
														'IMAGENES' 			=> $this->menu_model->getImgPorProducto($producto->PRODUCTO_ID,$limitImg)
													);
				}
				$i++;
			}
			
			$arreglo['menu']		= $menu;
			$arreglo['tipoEntrega']	= $this->tipopago_model->getApiTipoEntregaEmpresa($empresa->EMPRESA_ID);
			$arreglo['tipoPago']	= $this->tipopago_model->getApiTipoPagoEmpresa($empresa->EMPRESA_ID);

		}

		if( count($arreglo) == 0 ){
			$respuesta = array(
								'error'		=> TRUE,
								'mensaje'	=> 'No existen empresa solicitada'
							   );
			$this->response($respuesta);
			return;
		}

		$respuesta = array(
							'error'		=> FALSE, 
							'info' 		=> $arreglo
						   );
		$this->response($respuesta);
	}
	
	function vista_post( )
	{
		$data 		= json_decode( file_get_contents("php://input") );
		$idEmpresa 	= $data->idEmpresa;
		$arreglo 	= array();

		//INSERT VISTA
		$this->vista_model->insertVista($idEmpresa, fechaNow());

		//GET MEMBRESÍA
		$arreglo['vista'] = countVistas($idEmpresa);

		$respuesta = array(
								'error'		=> FALSE,
								'info' 		=> $arreglo
							);

		$this->response($respuesta);
	}
	
	function pedido_post()
	{
		$data 		= json_decode( file_get_contents("php://input") );
		$detalle 	= $data->value->detalle;
		$cliente 	= $data->value->persona;
		$shop 		= $data->value->shop;
		$date 		= fechaNow();
		$process	= FALSE;

		//INSERT CLIENTE
		$direccion = isset($cliente->direccion) ? $cliente->direccion : NULL;
		$idCliente = $this->cliente_model->insertCliente($cliente->nombre, $cliente->email, $cliente->celular, $direccion, $cliente->comentario, $date, $date);

		//INSERT PEDIDO
		$idPedido = $this->pedido_model->insertPedido($detalle->idEmpresa, $idCliente, $detalle->entrega->TIPO_ENTREGA_ID, $detalle->pago->TIPO_PAGO_ID, $detalle->total, $date, $date, $date);

		//INSERT DETALLE
		foreach( $shop as $item ){
			$total = $item->PROVAR_VALOR * $item->CANTIDAD;
			$this->pedido_model->insertPedidoDetalle($idPedido, $item->PROVAR_ID, $item->PRODUCTO_NOMBRE, $item->PROVAR_NOMBRE, $item->PROVAR_VALOR, $item->CANTIDAD, $total, $item->COMENTARIO, $date, $date);
		}

		// ENVIAR EMAIL DE AVISO DE VENTA
		email_pedido($data->value);

		$process	= TRUE;

		$respuesta = array(
							'error'		=> FALSE, 
							'info' 		=> $process 
						);
		$this->response($respuesta);
	}
	
}
