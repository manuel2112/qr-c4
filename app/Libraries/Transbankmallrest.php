<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'/third_party/vendor/autoload.php';

// require_once APPPATH.'/third_party/vendor/transbank/transbank-sdk/lib/webpay/Webpay.php';
// require_once APPPATH.'/third_party/vendor/transbank/transbank-sdk/lib/webpay/Configuration.php';
use Transbank\Webpay\Options;
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

class TransbankMallRest {
    
    protected $CI;
    private $return_url;
    private $monto;
    private $buy_order;
    private $session_id;
    private $stores;
    private $produccion;

    public function __construct( $param ) {
        $this->CI =& get_instance();
        $this->produccion = $param['bool'];
        
        if( $this->produccion ){
            Transbank\Webpay\WebpayPlus::setCommerceCode('597037376841');
            Transbank\Webpay\WebpayPlus::setApiKey('2c895ffc90703259ea7ee9d75dc46543');
            Transbank\Webpay\WebpayPlus::setIntegrationType('LIVE');
        }else{
            Transbank\Webpay\WebpayPlus::setCommerceCode('597055555535');
            Transbank\Webpay\WebpayPlus::setApiKey('579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C');
            Transbank\Webpay\WebpayPlus::setIntegrationType('TEST');
        }
    }

    public function transaction() {        
        $response = Transaction::createMall($this->buy_order, $this->session_id, $this->return_url, $this->stores);
        return $response;
    }

    public function getTransactionResult( $token )
    {
        $response = Transaction::commitMall($token);
        return $response;
    }

    public function getTransactionStatus( $token )
    {
        $response = Transaction::getMallStatus($token);
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
    
    public function setStores( $stores ) {
        $this->stores = $stores;
    }

    public function setReturnUrl( $url ) {
        $this->CI->load->helper('url');
        $this->return_url = site_url($url);
    }
}