<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('crearLogPlus'))
{    
	function crearLogPlus($log,$status)
	{
        $ci = &get_instance();
        $ci->load->helper('file');
        $ci->load->model('pago_model');
        $mdlPago = $ci->pago_model->getPagoRow( 'PAGO_ORDEN', $log->buyOrder );
        if( $mdlPago ){
            $ci->pago_model->insertPagoRequest( $mdlPago->PAGO_ID, $log, $status );
        }
        
        $var  = '';
        $var .= 'FECHA: ' . fechaNow() ."\n";
        $var .= 'vci: ' . $log->vci ."\n";
        $var .= 'amount: ' . $log->amount ."\n";
        $var .= 'status: ' . $log->status ."\n";
        $var .= 'buyOrder: ' . $log->buyOrder ."\n";
        $var .= 'sessionId: ' . $log->sessionId ."\n";
        $var .= 'card_number: ' . $log->cardDetail['card_number'] ."\n";
        $var .= 'accountingDate: ' . $log->accountingDate ."\n";
        $var .= 'transactionDate: ' . $log->transactionDate ."\n";
        $var .= 'authorizationCode: ' . $log->authorizationCode ."\n";
        $var .= 'paymentTypeCode: ' . $log->paymentTypeCode ."\n";
        $var .= 'responseCode: ' . $log->responseCode ."\n";
        $var .= 'installmentsAmount: ' . $status->installmentsAmount ."\n";
        $var .= 'installmentsNumber: ' . $status->installmentsNumber ."\n";
        $var .= 'balance: ' . $status->balance ."\n";
        
        logCompra($log->buyOrder,$var);
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

        return utf8_decode($var);
	}
}