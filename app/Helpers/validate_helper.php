<?php

use App\Models\AccionModel;
use App\Models\EmpresaModel;
use App\Models\MembresiaModel;

if(!function_exists('calcularMembresia'))
{
        function calcularMembresia($mdlPago)
        {
                $empresa_model     = new EmpresaModel();
                $membresia_model   = new MembresiaModel();

                $idEmpresa      = $mdlPago->EMPRESA_ID;
                $idMembresia    = $mdlPago->MEMBRESIA_ID;
                $idPago         = $mdlPago->PAGO_ID;
                $meses          = $mdlPago->PAGO_CANTIDAD;
                $free           = isset($mdlPago->FREE) ? TRUE : FALSE;
                
                $membresia_model->updateMembresiaDownBronce($idEmpresa);

                $membresia      = $membresia_model->getMembresiaInsertPlanRow($idEmpresa)->getRow();
                $inicio         = !empty($membresia) ? $membresia->EMP_MEMB_HASTA : fechaNow();
                
                if( $idMembresia != 1 ){

                        for( $i = 0 ; $i < $meses ; $i++ ){
                                $attr           = calcMembresiaExistente($inicio);
                                $start          = $attr->start;
                                $end            = $attr->end;
                                $insDate        = $attr->insDate;
                                $inicio         = $end;
                
                                $data = array(
                                        'EMPRESA_ID'		=> $idEmpresa,
                                        'PAGO_ID'		=> $idPago,
                                        'MEMBRESIA_ID'		=> $idMembresia,
                                        'EMP_MEMB_INSERT'       => $start,
                                        'EMP_MEMB_HASTA'        => $end,
                                        'EMP_MEMB_INSERT_DATE'  => $insDate,
                                        'EMP_MEMB_FREE'         => TRUE
                                );
                                $membresia_model->insertMembresia($data);
                        }

                }else{
                        $attr           = calcMembresiaExistente($inicio);                    
                        $start          = $attr->start;
                        $end            = $attr->end;
                        $insDate        = $attr->insDate;
                
                        $data = array(
                                'EMPRESA_ID'		=> $idEmpresa,
                                'PAGO_ID'		=> $idPago,
                                'MEMBRESIA_ID'		=> $idMembresia,
                                'EMP_MEMB_INSERT'       => $start,
                                'EMP_MEMB_HASTA'        => $end,
                                'EMP_MEMB_INSERT_DATE'  => $insDate,
                                'EMP_MEMB_FREE'         => TRUE
                        );
                        $membresia_model->insertMembresia($data);

                        $membresia_model->insertMembresia($idEmpresa,$idPago,$idMembresia,$start,$end,$insDate,TRUE);
                }

                $empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_VISTA', TRUE);
                $empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_MEMBRESIA', TRUE);

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
                $empresaMdl = new EmpresaModel();
                $permiso = true;        
                $mdlEmpresa = $empresaMdl->getEmpresaTblRow($idEmpresa)->getRow(); 
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
                $membresiaMdl = new MembresiaModel();

                $msn                    = '';
                $diasAviso              = 5;
                $membresiaActual        = $membresiaMdl->getMembresiaEmpresaEnUso($idEmpresa)->getRow();
                $membresiasTotal        = $membresiaMdl->getMembresiasPlan($idEmpresa)->getResult();

                if( $membresiaActual->MEMBRESIA_ID == 1 ){
                        $msn  = '<div class="alert alert-warning alert-dismissible fade show">';
                        $msn .= '<h2 class=text-center><strong>EST??S EN PLAN BRONCE,<br> MEJORA TU EXPERIENCIA CONTRATANDO TU MEMBRES??A</strong></h2>';
                        $msn .= '</div>';
                }else{
                        $diasResta  = diffEntreDosfecha($membresiaActual->EMP_MEMB_HASTA);
                        if( ($diasResta <= $diasAviso) && (count($membresiasTotal) == 1) ){
                                $msn  = '<div class="alert alert-warning alert-dismissible fade show">';
                                $msn .= '<h2 class=text-center><strong>TE QUEDAN '.$diasResta.' D??AS DE TU PLAN '.$membresiaActual->MEMBRESIA_NOMBRE.', <br> RENU??VALA AHORA.</strong></h2>';
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
                $membresiaMdl = new MembresiaModel();

                $ahora          = fechaNow();
                $hasta          = $mdl->EMP_MEMB_HASTA;
                $txtCron        = '';
                $file		= "cron_membresia.txt";

                if( $ahora > $hasta ){
                        $plan		= $mdl->MEMBRESIA_ID;
                        $idEmpresa	= $mdl->EMPRESA_ID;
                        $idEmpMem	= $mdl->EMP_MEMB_ID;
                        $existe 	= FALSE;

                        $membresiaMdl->updateMembresiaPorCampo('EMP_MEMB_ID',$idEmpMem,'EMP_MEMB_FLAG',FALSE);

                        $res = $membresiaMdl->getMembresiasPlan($idEmpresa)->getResult();
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
                $membresiaMdl = new MembresiaModel();

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
		$accionMdl = new AccionModel();
                $date = fechaNow();
                $txt  = null;

                switch ($accion) {
                        case 1:
                                $txt = "HA INICIADO SESI??N";
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
                                $txt = "SE ACTIVO LA ACCI??N GRUPO_SHOW DEL GRUPO ID:" . $idGrupo;
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
                                $txt = "SE ACTIVO LA ACCI??N PRODUCTO_SHOW DEL PRODUCTO ID:" . $idProducto;
                                break;
                        case 16:
                                $txt = "SE ACTIVO LA ACCI??N PRODUCTO_LINKED DEL PRODUCTO ID:" . $idProducto;
                                break;
                        case 17:
                                $txt = "SE HA ELIMINADO EL PRODUCTO ID:" . $idProducto;
                                break;
                        case 18:
                                $txt = "SE HA EDITADO LA VARIACI??N DE PRECIO DEL PRODUCTO ID:" . $idProducto;
                                break;
                        case 19:
                                $txt = "SE HA ELIMINADO IMAGEN DE UNA GALER??A DE PRODUCTOS";
                                break;
                        case 20:
                                $txt = "SE HA AGREGADO IMAGEN DE UNA GALER??A DEL PRODUCTO ID:" . $idProducto;
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
                                $txt = "ACCI??N PLATAFORMA GENERADA";
                                break;
                        case 25:
                                $txt = "INFOMACI??N EDITADA EN PAGO";
                                break;
                }
                
                $dataAccion = [
                        "EMPRESA_ID"    => $idEmpresa,
                        "ACCION_TXT"    => $txt,
                        "ACCION_DATE"   => $date
                ];
                $accionMdl->insertAccion($dataAccion);
        }
}