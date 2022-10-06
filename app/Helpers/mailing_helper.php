<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('esMicrosoft'))
{
	function esMicrosoft($email)
	{
		$es     = false;
        $key_1  = 'hotmail';
        $key_2  = 'outlook';

        if( (strpos($email, $key_1) !== false) || strpos($email, $key_2) !== false){
            $es = true;
        }

        return $es;
	}
}

if(!function_exists('nmbEstado'))
{
	function nmbEstado($idEstado)
	{
        $ci = &get_instance();
        $ci->load->model('mailing_model');
        $estado = $ci->mailing_model->getStatusRow($idEstado);

        return $estado->MAILING_ESTADO_NMB;
	}
}