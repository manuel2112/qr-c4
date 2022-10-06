<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->membresia();
	}
	
	public function membresia()
	{
		$ahora 		= fechaNow();		
		$txtCron	= $ahora;
        $file		= "cron_test.txt";
		logCron($file,$txtCron);
		$membresias = $this->membresia_model->getMembresiaEnUso();

		foreach( $membresias as $membresia ){
			downPlan($membresia);
		}
	}

}
