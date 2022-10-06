<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('formatoDinero'))
{
	function formatoDinero($valor)
	{
		$var = '$'.number_format($valor, 0, ",", ".");
		return $var;
	}
}

if(!function_exists('count_array'))
{
	function count_array($aArr) {
        if (is_array($aArr)) {
             return count($aArr);
        } else {
             return 0;
        }
    }
}

if(!function_exists('redondear'))
{
	function redondear($valor) {
        return round($valor);
    }
}
