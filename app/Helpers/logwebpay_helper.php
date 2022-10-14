<?php

use App\Models\PagoModel;

if(!function_exists('crearLogPlus'))
{    
	function crearLogPlus($response)
	{
		$pago_model   	= new PagoModel();
        
        $mdlPago = $pago_model->getPagoRow( 'PAGO_ID', $response->buyOrder )->getRow();
        
        $var  = '';
        $var .= 'FECHA: ' . fechaNow() ."\n";
        $var .= 'vci: ' . $response->vci ."\n";
        $var .= 'amount: ' . $response->amount ."\n";
        $var .= 'status: ' . $response->status ."\n";
        $var .= 'buyOrder: ' . $response->buyOrder ."\n";
        $var .= 'sessionId: ' . $response->sessionId ."\n";
        $var .= 'card_number: ' . $response->cardDetail['card_number'] ."\n";
        $var .= 'accountingDate: ' . $response->accountingDate ."\n";
        $var .= 'transactionDate: ' . $response->transactionDate ."\n";
        $var .= 'authorizationCode: ' . $response->authorizationCode ."\n";
        $var .= 'paymentTypeCode: ' . $response->paymentTypeCode ."\n";
        $var .= 'responseCode: ' . $response->responseCode ."\n";
        $var .= 'installmentsAmount: ' . $response->installmentsAmount ."\n";
        $var .= 'installmentsNumber: ' . $response->installmentsNumber ."\n";
        $var .= 'balance: ' . $response->balance ."\n";
        
        logCompra($mdlPago->PAGO_ORDEN,$var);
	}
}

if(!function_exists('tipoPago'))
{    
	function tipoPago($tipo)
	{
        switch ($tipo) {
            case 'VD':
                $var = 'VENTA DÉBITO';
                break;
            case 'VN':
                $var = 'VENTA NORMAL';
                break;
            case 'VC':
                $var = 'VENTA EN CUOTAS';
                break;
            case 'SI':
                $var = '3 CUOTAS SIN INTERÉS';
                break;
            case 'S2':
                $var = '2 CUOTAS SIN INTERÉS';
                break;
            case 'NC':
                $var = 'N CUOTAS SIN INTERÉS';
                break;
            case 'VP':
                $var = 'VENTA PREPAGO';
                break;
            default:
            $var = '';
        }

        return $var;
	}
}