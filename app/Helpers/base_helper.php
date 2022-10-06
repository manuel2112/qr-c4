<?php

use App\Models\ParametroModel;

if(!function_exists('title'))
{    
	function title()
	{
		$var = 'FACILBAK QR';
		return $var;
	}
}

if(!function_exists('imgDefecto'))
{    
	function imgDefecto()
	{
		$var = base_url('public/images/default.png');
		return $var;
	}
}

if(!function_exists('imgLogo'))
{
	function imgLogo()
	{
		$version = 1;
		$var = base_url('public/images/logo.png?v='.$version);
		return $var;
	}
}

if(!function_exists('urlAdmin'))
{    
	function urlAdmin()
	{
		$var = 'https://www.facilbak.cl/admin/';
		return $var;
	}
}

if(!function_exists('urlSite'))
{    
	function urlSite()
	{
		$var = 'https://www.facilbak.cl/';
		return $var;
	}
}

if(!function_exists('urlSiteBase'))
{    
	function urlSiteBase()
	{
		$var = 'https://www.facilbak.cl/';
		return $var;
	}
}

if(!function_exists('urlQR'))
{    
	function urlQR()
	{
		$whitelist = array( '127.0.0.1', '::1' );
		
		if ( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {			
			$var = 'http://localhost:8081/#/';			
		}else{
			$var = 'https://www.facilbak.cl/qr/#/';
		}
		return $var;
	}
}

if(!function_exists('dirTxt'))
{    
	function dirTxt()
	{
		$whitelist = array( '127.0.0.1', '::1' );
		
		if ( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {			
			$var = 'upload/txt/';			
		}else{
			// $var = '/home/facilbak/public_html/app/upload/txt/';
			$var = 'upload/txt/';
		}
		return $var;
	}
}

if(!function_exists('iva'))
{
	function iva()
	{
		$parametroMdl = new ParametroModel();
		$param 	= $parametroMdl->getParametro(1)->getRow();
		$iva	= $param->PARAMETRO_IVA;
		return $iva;
	}
}

if(!function_exists('nmbEmpresa'))
{    
	function nmbEmpresa()
	{
		$var = 'FACILBAK QR';
		return $var;
	}
}

if(!function_exists('attEmail'))
{
	function attEmail()
	{
		$json = '{
					"host": "mail.facilbak.cl",
					"username": "qr@facilbak.cl",
					"password": "T{e[hM4GP)_W",
					"from": "qr@facilbak.cl",
					"fromname": "FACILBACK QR"
				}';
		
		return json_decode($json);
	}
}