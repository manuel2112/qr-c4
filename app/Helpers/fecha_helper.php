<?php

use App\Models\ParametroModel;

if(!function_exists('zonaHoraria'))
{	
	function zonaHoraria(){
		$parametroMdl = new ParametroModel();
		$param = $parametroMdl->getParametro(1)->getRow();
		$zona  = date_default_timezone_set($param->PARAMETRO_ZONA_HORARIA);
		return $zona;
	}
}

if(!function_exists('fechaNowPass'))
{	
	function fechaNowPass(){
		zonaHoraria();
		$var = date("H").date("d").date("m");
		return $var;
	}		
}

if(!function_exists('fechaNow'))
{	
	function fechaNow(){
		zonaHoraria();
		$var = date("Y-m-d H:i:s");
		return $var;
	}		
}

if(!function_exists('fechaNowPermiso'))
{	
	function fechaNowPermiso(){
		zonaHoraria();
		$var = date("H").date("i").date("d").date("m").date("Y");
		return $var;
	}		
}

if(!function_exists('fechaNowTxt'))
{	
	function fechaNowTxt(){
		zonaHoraria();
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$var = date("d ").$meses[date('n')-1].date(", Y");
		return $var;
	}		
}

if(!function_exists('diffEntreDosfecha'))
{
	function diffEntreDosfecha($fecha)
	{
		$date1 = new DateTime(fechaNow());
		$date2 = new DateTime($fecha);
		$diff = $date1->diff($date2);
		
		return $diff->days;
	}
}

if(!function_exists('diffSegundos'))
{
	function diffSegundos($fecha)
	{
		$date = new DateTime( $fecha );
		$date2 = new DateTime( fechaNow() );
		$diff = $date2->getTimestamp() - $date->getTimestamp();
		
		return $diff;
	}
}

if(!function_exists('fechaLatinaConHora'))
{
	function fechaLatinaConHora($fecha)
	{
		$day=substr($fecha,8,2);
		$month=substr($fecha,5,2);
		$year=substr($fecha,0,4);
		$hour = substr($fecha,11,5);
		$datetime_format = $day."-".$month."-".$year.' '.$hour;
		if( $fecha == '' ){
			$datetime_format = '';
		}
		return $datetime_format;
	}
}

if(!function_exists('fechaLatinaSinHora'))
{
	function fechaLatinaSinHora($fecha)
	{
		$day=substr($fecha,8,2);
		$month=substr($fecha,5,2);
		$year=substr($fecha,0,4);
		$hour = substr($fecha,11,5);
		$datetime_format = $day."/".$month."/".$year;
		if( $fecha == '' ){
			$datetime_format = '';
		}
		return $datetime_format;
	}
}

if(!function_exists('fechaDown'))
{	
	function fechaDown(){
		zonaHoraria();
		$var = date('Y-m-d H:i:s', strtotime('-1 minutes'));
		return $var;
	}		
}