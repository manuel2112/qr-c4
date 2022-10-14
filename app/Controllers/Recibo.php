<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\PagoModel;

class Recibo extends BaseController {

	function __construct()
	{
	}

	public function index()
	{	
	}

	public function cliente()
	{
		$data       = array();
		$uri 		= new \CodeIgniter\HTTP\URI(uri_string());
		$buyOrder 	= $uri->getSegment(3);

		$pago_model 	= new PagoModel();
		$data['compra']	= $pago_model->getPagoRecibo( 'PAGO_ORDEN', $buyOrder )->getRow();
		$filename 		= 'COMPRA_' . $buyOrder;
		
		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);

		$dompdf = new Dompdf($options);
		$dompdf->loadHtml(view("pdf/index", $data));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($filename);
	}

	public function exportFile()
	{
		$data           = array();
        $data['ok']     = false;
		$ruta			= '';
		$request        = json_decode(file_get_contents('php://input')); 
		$texto          = $request->texto;
		
		$file = time().".txt";
		foreach( $texto as $email ){
			$ruta = exportFile($file,$email->MAILING_TXT);
		}		
        
        $data['ruta'] = base_url($ruta);
        $data['ok']   = true;
        return $this->response->setJSON($data);
	}


}
