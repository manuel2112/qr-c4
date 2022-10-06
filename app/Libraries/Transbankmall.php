<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'/third_party/vendor/autoload.php';

require_once APPPATH.'/third_party/vendor/transbank/transbank-sdk/lib/webpay/Webpay.php';
require_once APPPATH.'/third_party/vendor/transbank/transbank-sdk/lib/webpay/Configuration.php';
use Transbank\webpay\webpay;
use Transbank\webpay\Configuration;

class TransbankMall {
    
    protected $CI;
    private $tbk;
    private $result;
    private $return_url;
    private $end_url;
    private $error_url;
    private $monto;
    private $buy_order;
    private $stores;
    private $session_id;
    private $transaction;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function transaction()
    {
        $this->transaction = new Webpay(Configuration::forTestingWebpayPlusMall());
        return $this->transaction;
    }

    public function init( $args ) {
        $this->tbk = new Webpay($args);
    }

    public function startTransaction()
    {
        $this->result = $this->transaction->getMallNormalTransaction()->initTransaction($this->buy_order, $this->session_id, $this->return_url, $this->end_url, $this->stores);
        return $this->result;
    }

    public function getTransactionResult( $token )
    {
        $result = $this->transaction->getMallNormalTransaction()->getTransactionResult($token);
        return $result;
    }

    public function setMonto( $monto ) {
        $this->monto = $monto;
    }
    
    public function buyOrder( $buyOrder ) {
        $this->buy_order = $buyOrder;
    }
    
    public function stores( $stores ) {
        $this->stores = $stores;
    }
    
    public function session( $session ) {
        $this->session = $session;
    }

    public function setReturnUrl( $url ) {
        $this->CI->load->helper('url');
        $this->return_url = site_url($url);
    }

    public function setEndUrl( $url ) {
        $this->CI->load->helper('url');
        $this->end_url = site_url($url);
    }

    public function setErrorUrl( $url ) {
        $this->CI->load->helper('url');
        $this->error_url = site_url($url);
    }
}