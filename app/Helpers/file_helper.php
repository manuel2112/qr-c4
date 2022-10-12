<?php

if(!function_exists('fileUpload'))
{
	function fileUpload($fileTemp,$fileType,$idEmpresa,$directorio,$prefijo,$logo,$coords,$widthResize,$isGroup = false)
	{
        $fileTemp = $coords ? cutImg($logo,$fileTemp,$fileType,$coords,$widthResize) : $fileTemp;

        list($orig_w, $orig_h) = getimagesize($fileTemp);

        $output_w = 500;
        $output_h = 500;
        
        if ($orig_h > $orig_w) {
            $scale = $output_h/$orig_h;
        } else {
            $scale = $output_w/$orig_w;
        }

        if( $isGroup && $coords ){
            $output_h =  round(($orig_h * $output_w) / $orig_w);
            
            $new_w =  $output_w;
            $new_h =  $output_h;
            
            $offset_x = 0;
            $offset_y = 0;
        }else{
            $new_w =  round($orig_w * $scale);
            $new_h =  round($orig_h * $scale);
            
            $offset_x = round(($output_w - $new_w) / 2);
            $offset_y = round(($output_h - $new_h) / 2);
        }

        if( $fileType == "image/jpeg" ){
            $ruta		= createNameFile($directorio, $prefijo, 'jpg');
            uploadJPG($logo, $fileTemp, $ruta, $offset_x, $offset_y, 0, 0, $new_w, $new_h, $orig_w, $orig_h, $output_w, $output_h );
        }
                
        if( $fileType == "image/png" ){
            $ruta       = createNameFile($directorio, $prefijo, 'png');
            uploadPNG($logo, $fileTemp, $ruta, $offset_x, $offset_y, 0, 0, $new_w, $new_h, $orig_w, $orig_h, $output_w, $output_h );
        }

        deleteFile($fileTemp);
        return $ruta;
        // return $ruta;
	}
}

if(!function_exists('uploadJPG'))
{
	function uploadJPG($logo, $fileTemp, $ruta, $x1, $x2, $x3, $x4, $x5, $x6, $x7, $x8, $x9, $x10 )
	{
        $orig_img   = imagecreatefromjpeg($fileTemp);

        if( $logo ){
            $new_img	= imagecreatetruecolor($x5,$x6);				
            imagecopyresized($new_img, $orig_img, 0, 0, $x3, $x4, $x5, $x6, $x7, $x8);
        }else{
            $new_img    = imagecreatetruecolor($x9, $x10);
            $color      = imagecolorallocate($new_img, 255, 255, 255);
            imagefill($new_img, 0, 0, $color);
            imagecopyresampled($new_img, $orig_img, $x1, $x2, $x3, $x4, $x5, $x6, $x7, $x8);
        }
        imagejpeg($new_img, $ruta, 100);
	}
}

if(!function_exists('uploadPNG'))
{
	function uploadPNG($logo, $fileTemp, $ruta, $x1, $x2, $x3, $x4, $x5, $x6, $x7, $x8, $x9, $x10 )
	{
        $orig_img   = @imagecreatefrompng($fileTemp);
        $new_img    = imagecreatetruecolor($x9,$x10);
        imagealphablending($new_img, false);
        imagesavealpha($new_img,true);
        $color    = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
        imagefill($new_img, 0, 0, $color);       
        imagecopyresampled($new_img, $orig_img, $x1, $x2, $x3, $x4, $x5, $x6, $x7, $x8);
        imageresolution($new_img, 96, 96);
        imagepng($new_img, $ruta, 9);
	}
}

if(!function_exists('cutImg'))
{
	function cutImg($logo,$fileTemp,$fileType,$coords,$widthResize)
	{

        $widthResize = $widthResize - 8;
        list($or_width, $or_height) = getimagesize($fileTemp);
        $heightResize = ceil(($or_height * $widthResize) / $or_width);
        $CX = ceil(($or_width * $coords->x) / $widthResize);
        $CY = ceil(($or_height * $coords->y) / $heightResize);
        $CW = ceil(($or_width * $coords->w) / $widthResize);
        $CH = ceil(($or_height * $coords->h) / $heightResize);

        if( $fileType == "image/jpeg" ){
            $ruta   = createNameFile('public/upload/temps/', 'temp', 'jpg');
            uploadJPG( $logo, $fileTemp, $ruta, 0, 0, $CX, $CY, $CW, $CH, $CW, $CH, $CW, $CH );
        }

        if( $fileType == "image/png" ){
            $ruta   = createNameFile('public/upload/temps/', 'temp', 'png');
            uploadPNG( $logo, $fileTemp, $ruta, 0, 0, $CX, $CY, $CW, $CH, $CW, $CH, $CW, $CH );
        }

        deleteFile($fileTemp);
        return $ruta;
	}
}

if(!function_exists('resizeImage'))
{
	function resizeImage($logo,$fileTemp,$fileType)
	{
        list($or_width, $or_height) = getimagesize($fileTemp);
        
        $new_width  = $or_width;
        $new_height = $or_height;

        if( $fileType == "image/jpeg" ){
            $ruta   = createNameFile('public/upload/temps/', 'resize', 'jpg');
            uploadJPG( $logo, $fileTemp, $ruta, 0, 0, 0, 0, $new_width, $new_height, $or_width, $or_height, $new_width, $new_height);
        }

        if( $fileType == "image/png" ){
            $ruta   = createNameFile('public/upload/temps/', 'resize', 'png');
            uploadPNG( $logo, $fileTemp, $ruta, 0, 0, 0, 0, $new_width, $new_height, $or_width, $or_height, $new_width, $new_height );
        }

        return $ruta;
	}
}

if(!function_exists('deleteFile'))
{
	function deleteFile($file)
	{
        if ( file_exists($file) ) {
            fopen($file, 'a');
            unlink($file); 
        }      
	}
}

if(!function_exists('limpiarCarpeta'))
{
	function limpiarCarpeta($directorio)
	{
		$files = glob( $directorio . '/*' );
		foreach($files as $file){
			if(is_file($file))
			unlink($file);
		}        
	}
}

if(!function_exists('sizeLogoQr'))
{
	function sizeLogoQr($img)
	{
        list($width, $height, $type, $attr) = getimagesize(base_url().$img);
        $ratio  = $width / $height;

        if( $ratio >= 1 ){
            return 150;
        }
        elseif( 1 > $ratio && $ratio >= 0.5 ){
            return 100;
        }
        else{
            return 70;
        }
	}
}

if(!function_exists('createNameFile'))
{
	function createNameFile($directorio,$prefijo,$ext)
	{
        createDir($directorio);        
        $aleatorio	= generaRandom();
        $ruta 	= $directorio.'/'.$prefijo.'_'.$aleatorio.'.'.$ext;

        return $ruta;
	}
}

if(!function_exists('createDir'))
{
	function createDir($directorio)
	{
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }
	}
}