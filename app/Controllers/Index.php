<?php

namespace App\Controllers;

class Index extends BaseController {
	
	public function __construct()
	{		
		parent::__construct();
		redirect(base_url('home'));
		return;
	}
	
	public function index()
	{
		$this->layout->view('index');
	}
	
}
