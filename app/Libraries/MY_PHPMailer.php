<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once APPPATH."/libraries/PHPMailer/PHPMailerAutoload.php";
 
class MY_PHPMailer extends phpmailer{
        public function __construct() {
            parent::__construct();
        }
}