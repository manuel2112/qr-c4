<?php

namespace App\Controllers;

use App\Models\CiudadModel;

class Geo extends BaseController {

	public $geoMdl;
	
	public function __construct()
	{
		$this->geoMdl = new CiudadModel();		
	}

	public function index()
	{
		$this->layout->view('index');
	}

	public function ciudadPorRegion()
	{
		$data  		= array();
        $request	= json_decode(file_get_contents('php://input'));
		$idRegion	= $request->region;

        $data['ciudades'] = $this->geoMdl->getCiudadPorRegion($idRegion)->getResult();

        return $this->response->setJSON($data);
	}
	
}
