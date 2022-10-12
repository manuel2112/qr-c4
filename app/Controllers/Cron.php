<?php

namespace App\Controllers;

use App\Models\MembresiaModel;

class Cron extends BaseController {

	public $membresia_model;
	
	public function __construct()
	{
		$this->membresia_model = new MembresiaModel();
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
		$this->membresias = $this->membresia_model->getMembresiaEnUso()->getResult();

		foreach( $this->membresias as $membresia ){
			downPlan($membresia);
		}
	}

}
