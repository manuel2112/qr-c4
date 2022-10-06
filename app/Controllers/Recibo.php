<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recibo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');	
	}

	public function index()
	{	
	}

	public function cliente()
	{
		$buyOrder 	= $this->uri->segment(3);
		$compra		= $this->pago_model->getPagoRow( 'PAGO_ORDEN', $buyOrder );
		$request	= $this->pago_model->getPagoRequestRow( 'PAGO_REQ_BUY_ORDER', $buyOrder );

		if( !$compra ){
			redirect(base_url('my404'));
			exit();
		}

		$this->pdf = new PDF();
		$this->pdf->AliasNbPages();
		$this->pdf->AddPage();
		
		//HEADER
		$this->pdf->Image('public/images/logo.png',10,6,20);
		$this->pdf->SetFont('Arial','B',15);
		$this->pdf->Cell(80);
		$this->pdf->Cell(30,10,utf8_decode('COMPROBANTE DE PAGO'),0,0,'C');
		$this->pdf->Ln(10);
		$this->pdf->SetFont('Arial','B',14);
		$this->pdf->Cell(80);
		$this->pdf->Ln(0);

		$this->pdf->SetDrawColor(11,60,93);
		$this->pdf->SetLineWidth(0.5);
		$this->pdf->Line(10, 35, 210-10, 35);
		$this->pdf->Ln(20);
		
		//BODY
		$this->pdf->SetFont('Arial','B',14);
		$this->pdf->Cell(80);
		$this->pdf->Cell(30,10,utf8_decode('DETALLE'),0,0,'C');
		$this->pdf->Ln(10);
		
		$this->pdf->SetFont('Arial','',12);
		$this->pdf->SetDrawColor(0,0,0);
		$this->pdf->SetLineWidth(0.2);
		
		$this->pdf->Cell(95,8,'ORDEN DE COMPRA',1,0,'R',0);
		$this->pdf->Cell(95,8, $buyOrder ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8,'PLAN',1,0,'R',0);
		$this->pdf->Cell(95,8, $compra->MEMBRESIA_NOMBRE ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8,'CANTIDAD',1,0,'R',0);
		$this->pdf->Cell(95,8, $compra->PAGO_CANTIDAD ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8,'NETO',1,0,'R',0);
		$this->pdf->Cell(95,8, formatoDinero($compra->PAGO_NETO) ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8,'IVA',1,0,'R',0);
		$this->pdf->Cell(95,8, formatoDinero($compra->PAGO_IVA) ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8,'TOTAL',1,0,'R',0);
		$this->pdf->Cell(95,8, formatoDinero($compra->PAGO_TOTAL) ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8,'FECHA',1,0,'R',0);
		$this->pdf->Cell(95,8, $compra->PAGO_FECHA ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8,'PAGO CON',1,0,'R',0);
		$this->pdf->Cell(95,8, 'WEBPAY' ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8, utf8_decode('TARJETA N°') ,1,0,'R',0);
		$this->pdf->Cell(95,8, '**** **** **** '.$request->PAGO_REQ_CARD_NUMBER ,1,0,'R',0);
		$this->pdf->Ln();

		$this->pdf->Cell(95,8, 'TIPO DE PAGO' ,1,0,'R',0);
		$this->pdf->Cell(95,8, tipoPago($request->PAGO_REQ_PAY_TYPE_CODE) ,1,0,'R',0);
		$this->pdf->Ln();

		if( $request->PAGO_REQ_INSTALLMENTS_AMOUNT ){
			$this->pdf->Cell(95,8, utf8_decode('N° DE CUOTAS') ,1,0,'R',0);
			$this->pdf->Cell(95,8, $request->PAGO_REQ_INSTALLMENTS_NUMBER ,1,0,'R',0);
			$this->pdf->Ln();

			$this->pdf->Cell(95,8, utf8_decode('MONTO CUOTA') ,1,0,'R',0);
			$this->pdf->Cell(95,8, formatoDinero($request->PAGO_REQ_INSTALLMENTS_AMOUNT) ,1,0,'R',0);
			$this->pdf->Ln();
		}

        $this->pdf->Output('COMPRA_' . $buyOrder . '.pdf', 'I');
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
        echo json_encode($data);
	}


}
