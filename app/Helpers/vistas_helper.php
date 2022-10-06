<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('planActual'))
{
        function planActual($idEmpresa)
        {
            $ci = &get_instance();
            $ci->load->model('membresia_model','vista_model');

            $membresia  = $ci->membresia_model->getMembresiaEmpresaEnUso($idEmpresa);
            $plan       = $membresia->MEMBRESIA_ID;
            $inicio     = $membresia->EMP_MEMB_INSERT;
            $fin        = $membresia->EMP_MEMB_HASTA;
            $maxVistas  = $membresia->MEMBRESIA_VISTAS;
            $vistas     = $ci->vista_model->getVistaPlanActual($idEmpresa,$inicio,$fin);
            $counter    = count($vistas);

            $arr = array(
                            'inicio'    => $inicio, 
                            'fin'       => $fin, 
                            'vistas'    => $vistas, 
                            'counter'   => $counter, 
                            'maximo'    => $maxVistas,
                            'plan'      => $plan
                        );

            return $arr;
        }
}

if(!function_exists('countVistas'))
{
        function countVistas($idEmpresa)
        {
                $ci = &get_instance();
                $ci->load->model('membresia_model','vista_model','empresa_model');

                $permiso    = true;
                $attr       = planActual($idEmpresa);
                $inicio     = $attr['inicio'];
                $fin        = $attr['fin'];
                $counter    = $attr['counter'];
                $maximo     = $attr['maximo'];
                $plan       = $attr['plan'];
                $isPlatino  = TRUE;

                if( ($plan != 6) && ($plan != 7) ){
                        $isPlatino  = FALSE;
                        if( $counter > $maximo ){
                                $ci->empresa_model->updateEmpresaCampo($idEmpresa, 'EMPRESA_VISTA', FALSE);
                                $permiso = 0;
                        }
                }

		$json = '{
                                "inicio": "'.$inicio.'",
                                "fin": "'.$fin.'",
                                "maximo": "'.$maximo.'",
                                "count": "'.$counter.'",
                                "permiso": "'.$permiso.'",
                                "plan": "'.$plan.'",
                                "isPlatino": "'.$isPlatino.'"
                        }';
		
		return json_decode($json);
        }
}