<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'/third_party/vendor/autoload.php';

use Transbank\Webpay\Options;
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

class TransbankRest {
    
    protected $CI;
    private $return_url;
    private $monto;
    private $buy_order;
    private $session_id;

    public function __construct() {
        $this->CI =& get_instance();
        $ci = &get_instance();
        $ci->load->model('parametro_model');
        $parametro 	= $ci->parametro_model->getParametro();
		$bool 		= $parametro->PARAMETRO_TRANSBANK;
        if( $bool ){
            Transbank\Webpay\WebpayPlus::setCommerceCode('597037288527');
            Transbank\Webpay\WebpayPlus::setApiKey('3f75b2cd339c0f5b3ecb62e1084a9403');
            Transbank\Webpay\WebpayPlus::setIntegrationType('LIVE');
        }else{
            Transbank\Webpay\WebpayPlus::setCommerceCode('597055555532');
            Transbank\Webpay\WebpayPlus::setApiKey('579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C');
            Transbank\Webpay\WebpayPlus::setIntegrationType('TEST');
        }
    }

    public function transaction() {
        $response = Transaction::create($this->buy_order, $this->session_id, $this->monto, $this->return_url);
        return $response;
    }

    public function getTransactionResult( $token )
    {
        $response = Transaction::commit($token);
        return $response;
    }

    public function getTransactionStatus( $token )
    {
        $response = Transaction::getStatus($token);
        return $response;
    }

    public function setMonto( $monto ) {
        $this->monto = $monto;
    }
    
    public function setBuyOrder( $buyOrder ) {
        $this->buy_order = $buyOrder;
    }
    
    public function setSession( $session_id ) {
        $this->session_id = $session_id;
    }

    public function setReturnUrl( $url ) {
        $this->CI->load->helper('url');
        $this->return_url = site_url($url);
    }
}