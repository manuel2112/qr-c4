<?php

use App\Models\MailingModel;

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
        $mailing_model = new MailingModel();
        
        $estado = $mailing_model->getStatusRow($idEstado)->getRow();

        return $estado->MAILING_ESTADO_NMB;
	}
}