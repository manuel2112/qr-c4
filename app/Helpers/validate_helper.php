<?php

use App\Models\EmpresaModel;
use App\Models\MembresiaModel;

if(!function_exists('calcularMembresia'))
{
        function calcularMembresia($mdlPago)
        {
                $ci = &get_instance();
                $ci->load->model('membresia_model','empresa_model');

                $idEmpresa      = $mdlPago->EMPRESA_ID;
                $idMembresia    = $mdlPago->MEMBRESIA_ID;
                $idPago         = $mdlPago->PAGO_ID;
                $meses          = $mdlPago->PAGO_CANTIDAD;
                $free           = isset($mdlPago->FREE) ? TRUE : FALSE;
                
                $ci->membresia_model->updateMembresiaDownBronce($idEmpresa);

                $membresia      = $ci->membresia_model->getMembresiaInsertPlanRow($idEmpresa);
                $inicio         = !empty($membresia) ? $membresia->EMP_MEMB_HASTA : fechaNow();
                
                if( $idMembresia != 1 ){

                        for( $i = 0 ; $i < $meses ; $i++ ){
                                $attr           = calcMembresiaExistente($inicio);
                                $start          = $attr->start;
                                $end            = $attr->end;
                                $insDate        = $attr->insDate;
                                $inicio         = $end;

                                $ci->membresia_model->insertMembresia($idEmpresa,$idPago,$idMembresia,$start,$end,$insDate,$free);
                        }

                }else{
                        $attr           = calcMembresiaExistente($inicio);                    
                        $start          = $attr->start;
                        $end            = $attr->end;
                        $insDate        = $attr->insDate;

                        $ci->membresia_model->insertMembresia($idEmpresa,$idPago,$idMembresia,$start,$end,$insDate,TRUE);
                }

                $ci->empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_VISTA', TRUE);
                $ci->empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_MEMBRESIA', TRUE);

        }
}

if(!function_exists('hastaDate'))
{
	function hastaDate($date)
	{
		$var = date('Y-m-d H:i:s', strtotime($date . ' + 1 months'));
		return $var;
	}
}

if(!function_exists('calcMembresiaExistente'))
{
	function calcMembresiaExistente($inicio)
	{
		$json = '{
                                "start": "'.$inicio.'",
                                "end": "'.hastaDate($inicio).'",
                                "insDate": "'.fechaNow().'"
                        }';
		
		return json_decode($json);
	}
}

if(!function_exists('instanciarPlan'))
{
        function instanciarPlan($idEmpresa,$ahora,$plan)
        {
                $empresaMdl     = new EmpresaModel();
                $membresiaMdl   = new MembresiaModel();
                $bool = $plan != 1 ? TRUE : FALSE;

                $empresaMdl->updateEmpresaCampo($idEmpresa,'EMPRESA_MEMBRESIA',$bool);
                $empresaMdl->updateEmpresaCampo($idEmpresa,'EMPRESA_VISTA',TRUE);

                $end = hastaDate($ahora);
                
		$data = array(
                        'EMPRESA_ID'		=> $idEmpresa,
                        'PAGO_ID'		=> NULL,
                        'MEMBRESIA_ID'		=> $plan,
                        'EMP_MEMB_INSERT'       => $ahora,
                        'EMP_MEMB_HASTA'        => $end,
                        'EMP_MEMB_INSERT_DATE'  => $ahora,
                        'EMP_MEMB_FREE'         => TRUE
                );
                $membresiaMdl->insertMembresia($data);
        }
}

if(!function_exists('tieneMembresia'))
{    
        function tieneMembresia($idEmpresa)
        {
                $ci = &get_instance();
                $ci->load->model('empresa_model');
                $permiso = true;        
                $mdlEmpresa = $ci->empresa_model->getEmpresaTblRow($idEmpresa); 
                if( !$mdlEmpresa->EMPRESA_MEMBRESIA ){
                   $permiso = false;
                }
                
                return $permiso;
        }
}

if(!function_exists('avisoMembresia'))
{
        function avisoMembresia($idEmpresa)
        {
                $ci = &get_instance();
                $ci->load->model('membresia_model');

                $msn                    = '';
                $diasAviso              = 5;
                $membresiaActual        = $ci->membresia_model->getMembresiaEmpresaEnUso($idEmpresa);
                $membresiasTotal        = $ci->membresia_model->getMembresiasPlan($idEmpresa);

                if( $membresiaActual->MEMBRESIA_ID == 1 ){
                        $msn  = '<div class="alert alert-warning alert-dismissible fade show">';
                        $msn .= '<h2 class=text-center><strong>ESTÁS EN PLAN BRONCE,<br> MEJORA TU EXPERIENCIA CONTRATANDO TU MEMBRESÍA</strong></h2>';
                        $msn .= '</div>';
                }else{
                        $diasResta  = diffEntreDosfecha($membresiaActual->EMP_MEMB_HASTA);
                        if( ($diasResta <= $diasAviso) && (count($membresiasTotal) == 1) ){
                                $msn  = '<div class="alert alert-warning alert-dismissible fade show">';
                                $msn .= '<h2 class=text-center><strong>TE QUEDAN '.$diasResta.' DÍAS DE TU PLAN '.$membresiaActual->MEMBRESIA_NOMBRE.', <br> RENUÉVALA AHORA.</strong></h2>';
                                $msn .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                $msn .= '</div>';
                        }
                }

                return $msn;
        }
}

if(!function_exists('downPlan'))
{
        function downPlan($mdl)
        {
                $ci = &get_instance();
                $ci->load->model('membresia_model');

				$ahora 		= fechaNow();
				$hasta      = $mdl->EMP_MEMB_HASTA;
				$txtCron    = '';
				$file		= "cron_membresia.txt";

				if( $ahora > $hasta ){
					$plan		= $mdl->MEMBRESIA_ID;
					$idEmpresa	= $mdl->EMPRESA_ID;
					$idEmpMem	= $mdl->EMP_MEMB_ID;
					$existe 	= FALSE;

					$ci->membresia_model->updateMembresiaPorCampo('EMP_MEMB_ID',$idEmpMem,'EMP_MEMB_FLAG',FALSE);

					$res = $ci->membresia_model->getMembresiasPlan($idEmpresa);
					if( count($res) == 0 ){
						instanciarPlan($idEmpresa,$ahora,1);
					}

					$txtCron = $ahora . ' EMPRESA: ' . $idEmpresa . ' IDCAMPO: '.$idEmpMem.' PLAN: ' .$plan. "\n";
								logCron($file,$txtCron);
				}
        }
}

if(!function_exists('updatePlanes'))
{
        function updatePlanes($idEmpresa)
        {
                $ci = &get_instance();
                $ci->load->model('membresia_model');
                $planes = $ci->membresia_model->getMembresiasPlan($idEmpresa);		
		$inicio = fechaNow();

		foreach($planes as $plan){
			if( $plan->MEMBRESIA_ID != 1 ){
				$ci->membresia_model->updateMembresiaPorCampo('EMP_MEMB_ID',$plan->EMP_MEMB_ID,'EMP_MEMB_INSERT',$inicio);
                                $hasta = hastaDate($inicio);
				$ci->membresia_model->updateMembresiaPorCampo('EMP_MEMB_ID',$plan->EMP_MEMB_ID,'EMP_MEMB_HASTA',$hasta);
                                $inicio = $hasta;
			}
		}
        }
}

if(!function_exists('existeEmailRegistro'))
{
        function existeEmailRegistro($email)
        {
		$empresaMdl = new EmpresaModel();
		$query = $empresaMdl->getEmpresaExisteCampoRow('EMPRESA_EMAIL',$email)->getResult();
		$existe = $query ? TRUE : FALSE;

                return $existe;
        }
}

if(!function_exists('insertAccion'))
{
        function insertAccion($idEmpresa,$accion,$idGrupo,$idProducto)
        {
                $ci = &get_instance();
                $ci->load->model('accion_model');
                $date = fechaNow();
                $txt  = null;

                switch ($accion) {
                        case 1:
                                $txt = "HA INICIADO SESIÓN";
                                break;
                        case 2:
                                $txt = "SE HAN EDITADO LOS DATOS";
                                break;
                        case 3:
                                $txt = "SE HAN EDITADO LAS RRSS";
                                break;
                        case 4:
                                $txt = "SE HA EDITADO EL PASSWORD";
                                break;
                        case 5:
                                $txt = "SE HA SUBIDO EL LOGOTIPO";
                                break;
                        case 6:
                                $txt = "SE HA ELIMINADO EL LOGOTIPO";
                                break;
                        case 7:
                                $txt = "SE HA CREADO EL GRUPO ID:" . $idGrupo;
                                break;
                        case 8:
                                $txt = "SE HA EDITADO EL GRUPO ID:" . $idGrupo;
                                break;
                        case 9:
                                $txt = "SE HA CAMBIADO EL ORDEN DE LOS GRUPOS";
                                break;
                        case 10:
                                $txt = "SE ACTIVO LA ACCIÓN GRUPO_SHOW DEL GRUPO ID:" . $idGrupo;
                                break;
                        case 11:
                                $txt = "SE HA ELIMINADO EL GRUPO ID:" . $idGrupo;
                                break;
                        case 12:
                                $txt = "SE HA CREADO EL PRODUCTO ID:" . $idProducto;
                                break;
                        case 13:
                                $txt = "SE HA CAMBIADO EL ORDEN DE LOS PRODUCTOS";
                                break;
                        case 14:
                                $txt = "SE HA EDITADO EL PRODUCTO ID:" . $idProducto;
                                break;
                        case 15:
                                $txt = "SE ACTIVO LA ACCIÓN PRODUCTO_SHOW DEL PRODUCTO ID:" . $idProducto;
                                break;
                        case 16:
                                $txt = "SE ACTIVO LA ACCIÓN PRODUCTO_LINKED DEL PRODUCTO ID:" . $idProducto;
                                break;
                        case 17:
                                $txt = "SE HA ELIMINADO EL PRODUCTO ID:" . $idProducto;
                                break;
                        case 18:
                                $txt = "SE HA EDITADO LA VARIACIÓN DE PRECIO DEL PRODUCTO ID:" . $idProducto;
                                break;
                        case 19:
                                $txt = "SE HA ELIMINADO IMAGEN DE UNA GALERÍA DE PRODUCTOS";
                                break;
                        case 20:
                                $txt = "SE HA AGREGADO IMAGEN DE UNA GALERÍA DEL PRODUCTO ID:" . $idProducto;
                                break;
                        case 21:
                                $txt = "SE HA DADO DE BAJA EL PLAN";
                                break;
                        case 22:
                                $txt = "PLATAFORMA DE PAGO ACTIVADA";
                                break;
                        case 23:
                                $txt = "PLATAFORMA DE PAGO DESACTIVADA";
                                break;
                        case 24:
                                $txt = "ACCIÓN PLATAFORMA GENERADA";
                                break;
                        case 25:
                                $txt = "INFOMACIÓN EDITADA EN PAGO";
                                break;
                }
                
                $ci->accion_model->insertAccion($idEmpresa, $txt, $date);
        }
}