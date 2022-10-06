<?php

//https://github.com/endroid/qr-code

use App\Models\EmpresaModel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\ValidationException;

use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

if(!function_exists('create_qr'))
{    
	function create_qr($idEmpresa)
	{
		$empresaMdl = new EmpresaModel();
		$empresa    = $empresaMdl->getEmpresaRow($idEmpresa)->getRow();
        $urlQR      = urlQR().$empresa->EMPRESA_SLUG;
        $logo       = $empresa->EMPRESA_LOGOTIPO;

        $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($urlQR)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(480)
                ->margin(10)
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                // ->logoPath(__DIR__.'/assets/symfony.png')
                ->validateResult(false)
                ->build();

        //CREAR DIRECTORIO SI NO EXISTE
        $directorio = "public/upload/empresas/".$idEmpresa."/qr/";
        createDir($directorio);

        // // Save it to a file
        $aleatorio	= generaRandom();
        $urlImg 	= $directorio."qr_".$aleatorio.".png";  

        $result->saveToFile($urlImg);

        //INSERT/UPDATE IN DATABASE
        $empresaMdl->updateEmpresaQRCampo($idEmpresa, 'EMP_QR_FLAG', FALSE);
        $insert = array(
            'EMPRESA_ID'	=> $idEmpresa,
            'EMP_QR_IMG'	=> $urlImg,
            'EMP_QR_DATE'   => fechaNow()
          );
        $empresaMdl->insertEmpresaQR($insert);

        return $urlImg;
	}
}