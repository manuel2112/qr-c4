<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('logCron'))
{
	function logCron($file,$texto)
	{
		$directorio = dirTxt()."cron/";
		createDir($directorio);		
		$texto 		= $texto.PHP_EOL;
        $ruta 		= $directorio . $file;
		$myfile     = fopen($ruta, "a+") or die("Unable to open file!");
		fwrite($myfile, $texto);
		fclose($myfile);
	}
}

if(!function_exists('logMailing'))
{
	function logMailing($file,$texto)
	{
		$directorio = dirTxt()."mail/";
		createDir($directorio);		
		$texto 		= $texto.PHP_EOL;
        $ruta 		= $directorio . $file;
		$myfile     = fopen($ruta, "w") or die("Unable to open file!");
		fwrite($myfile, $texto);
		fclose($myfile);
	}
}

if(!function_exists('exportFile'))
{
	function exportFile($file,$texto)
	{
		$directorio = dirTxt()."export/";
		createDir($directorio);		
		$texto 		= $texto.PHP_EOL;
        $ruta 		= $directorio . $file;
		$myfile     = fopen($ruta, "a+") or die("Unable to open file!");
		fwrite($myfile, $texto);
		fclose($myfile);

		return $ruta;
	}
}

if(!function_exists('logCompra'))
{
	function logCompra($orden,$texto)
	{
		$directorio = dirTxt()."buy/";
		createDir($directorio);
		$ruta 		= $directorio . "log_". $orden .".txt";
		$myfile     = fopen($ruta, "a+") or die("Unable to open file!");
		fwrite($myfile, $texto);
		fclose($myfile);
	}
}