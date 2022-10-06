<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailing extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('isadminqrsession')) {
			$this->session->set_userdata('', current_url());
			redirect(base_url('login'));
		}
		$this->session_id 			= $this->session->userdata('idqrsession');
		$this->session_nmb 			= $this->session->userdata('nmbqrsession');
		$this->isadminqrsession 	= $this->session->userdata('isadminqrsession');
	}
	
	public function index()
	{
		$this->layout->view('index');
	}

	public function instanciar()
	{
		$data = array();

        $data['estados']        = $this->mailing_model->getStatus();
		$data['total']          = $this->mailing_model->getCorreos();
		$data['activo']         = $this->mailing_model->getCorreoCountCampo('MAILING_ESTADO_ID',1);
		$data['listaNegra']     = $this->mailing_model->getCorreoCountCampo('MAILING_ESTADO_ID',2);
		$data['rebotado']       = $this->mailing_model->getCorreoCountCampo('MAILING_ESTADO_ID',3);
		$data['inactivo']       = $this->mailing_model->getCorreoCountCampo('MAILING_ESTADO_ID',4);
		$data['spam']           = $this->mailing_model->getCorreoCountCampo('MAILING_ESTADO_ID',5);
		$data['baja']           = $this->mailing_model->getCorreoCountCampo('MAILING_ESTADO_ID',6);
		$data['mailrelaey']     = $this->mailing_model->getCorreoCountCampo('MAILING_MAILRELAY_STATUS',TRUE);
		$data['nomailrelaey']   = $this->mailing_model->getCorreoCountCampo('MAILING_MAILRELAY_STATUS',FALSE);
        
        echo json_encode($data);
	}

	public function insertEmail()
	{
		$data           = array();
        $data['ok']     = false;
        $data['existe'] = false;
		$request        = json_decode(file_get_contents('php://input')); 
		$email          = $request->email;

		$total  = $this->mailing_model->getCorreoSearch($email);
		if( $total > 0 ){
            $data['existe'] = true;
        }else{
            $bool = esMicrosoft($email);
            $this->mailing_model->insertEmail($email,$bool);
        }
        
        $data['ok'] = true;
        echo json_encode($data);
	}
    
	public function insertGrupo()
	{
        $data           = array();
        $data['ok']     = false;
        $noValido       = '';
        $countNoValido  = 0;
        $countValido    = 0;
        $existente      = '';
        $countExistente = 0;
        $i              = 0;
        $msn            = '';
        $request        = json_decode(file_get_contents('php://input')); 
        $grupo          = $request->grupo;
        $textAr         = explode("\n", $grupo);
        $textAr         = array_filter($textAr, 'trim');

        foreach ($textAr as $email) {
            $email  = strtolower(trim($email));
            $existe = $this->mailing_model->getCorreoSearch($email);

            if( $email != '' && !filter_var($email,FILTER_VALIDATE_EMAIL) ){
                $noValido    .= $email.'<br>';
                $countNoValido++;
            }
            if( $existe > 0 ){
                $existente    .= $email.'<br>';
                $countExistente++;
            }
            if( $email != '' && filter_var($email,FILTER_VALIDATE_EMAIL) && ( $existe == 0 ) ){
                $bool = esMicrosoft($email);
                $this->mailing_model->insertEmail($email,$bool);
                $countValido++;
            }
            $i++;
        }
        
        $msn .= '<strong>EMAILS LEIDOS:</strong> '.$i.'<br>';
        $msn .= '<strong>EMAILS INGRESADOS:</strong> '.$countValido.'<br>';
        $msn .= '<strong>N° EXISTENTES:</strong> '.$countExistente.'<br>';
        $msn .= '<strong>Nº NO VÁLIDOS:</strong> '.$countNoValido.'<br>';
        $msn .= '<strong>EMAILS NO VÁLIDOS:</strong><br>'.$noValido.'<br>';
        // $msn .= '<strong>EMAILS EXISTENTES:</strong> '.$existente.'<br>';

        $data['ok']  = true;
        $data['msn'] = $msn;

        echo json_encode($data);
	}

	public function searchEmail()
	{
		$data           = array();
        $data['ok']     = false;
        $data['existe'] = false;
		$request        = json_decode(file_get_contents('php://input')); 
		$email          = $request->email;

		$correo  = $this->mailing_model->getCorreoSearchRow($email);

        if( !$correo->MAILING_ESTADO_ID ){
            $correo->MAILING_ESTADO_ID = '';
            $correo->MAILING_ESTADO_NMB = '';
        }

		if( $correo ){
            $data['existe'] = true;
            $data['resp']   = $correo;
            $data['edit']   = $correo;
        }
        
        $data['ok'] = true;
        echo json_encode($data);
	}

	public function searchGrupo()
	{
		$data               = array();
        $data['ok']         = false;
        $data['existe']     = false;
		$request            = json_decode(file_get_contents('php://input')); 
		$grupo              = $request->grupo;        
        $data['caption']    = $grupo;
		$paquete            = $request->paquete;

        $grupo = $grupo == 1 ? 0 : ($grupo - 1) * $paquete;

		$correos  = $this->mailing_model->getCorreoGrupo($paquete, $grupo);
		if( $correos ){
            $data['existe']  = true;
            $data['correos'] = $correos;
        }
        
        $data['ok'] = true;
        echo json_encode($data);
	}

	public function getGrupoStatus()
	{
		$data               = array();
        $data['ok']         = false;
        $data['existe']     = false;
		$request            = json_decode(file_get_contents('php://input')); 
		$idEstado            = $request->idEstado;

		$data['correos'] = $this->mailing_model->getCorreoStatus($idEstado);
        $data['existe']  = true;        
        $data['caption']    = nmbEstado($idEstado);
        $data['ok']         = true;
        echo json_encode($data);
	}
    
	public function changeState()
	{
        $start              = fechaNow();
        $data               = array();
        $data['ok']         = false;
        $countEditado       = 0;
        $noExistente        = '';
        $countNoExistente   = 0;
        $i                  = 0;
        $msn                = '';
        $request            = json_decode(file_get_contents('php://input')); 
        $grupo              = $request->grupo;
        $state              = $request->state;
        $textAr             = explode("\n", $grupo);
        $textAr             = array_filter($textAr, 'trim');

        foreach ($textAr as $email) {
            $email  = strtolower(trim($email));

            $existe = $this->mailing_model->getCorreoSearchRow($email);
            
            if( $existe ){
                if( $state == 1 ){
                    if( $existe->MAILING_ESTADO_ID != 1 ){
                        $this->mailing_model->updateCorreoState($existe->MAILING_ID,$state);
                        $countEditado++;
                    }
                }
                elseif( ($state != 1) && ($existe->MAILING_MAILRELAY_STATUS == TRUE) ){
                    $this->mailing_model->updateCorreoState($existe->MAILING_ID,$state);
                    $countEditado++;
                }else{}
            }else{
                $noExistente .= $email.'<br>';
                $countNoExistente++;
            }
            
            $i++;
        }

        $msn .= '<strong>ESTADO:</strong> '.nmbEstado($state).'<br>';
        $msn .= '<strong>SEGUNDOS PROCESADOS:</strong> '.diffSegundos($start).'<br>';
        $msn .= '<strong>N° LEIDOS:</strong> '.$i.'<br>';
        $msn .= '<strong>N° EDITADOS:</strong> '.$countEditado.'<br>';
        $msn .= '<strong>Nº NO EXISTENTES:</strong> '.$countNoExistente.'<br>';
        $msn .= '<strong>EMAILS NO EXISTENTES:</strong><br>'.$noExistente.'<br>';

        $data['ok']  = true;
        $data['msn'] = $msn;

        echo json_encode($data);
	}

    public function status()
    {
        $status = 1; //ACTIVO
        // $status = 2; //LISTA NEGRA
        // $status = 3; //REBOTADO
        // $status = 4; //INACTIVO
        // $status = 5; //SPAM
        // $status = 6; //BAJA

        return $status;
    }

    public function automated()
    {
        $start              = fechaNow();
        $data               = array();
        $status             = $this->status();
        $i                  = 0;
        $msn                = '';
        $error              = '';
        $countEditado       = 0;
        $countNoExistente   = 0;
        $porLeer            = 0;
        $action             = true;
        $path               = dirTxt()."mail/upload.txt";
        $maxTime            = 100;
        $execTime           = 0;

        $myFile     = file_get_contents($path);
        $content    = explode("\r\n", $myFile);

        foreach( $content as $email ){

            if( $execTime >= $maxTime ){
                break;
            }

            $email  = strtolower(trim($email));

            if( filter_var($email,FILTER_VALIDATE_EMAIL) ){

                $existe = $this->mailing_model->getCorreoSearchRow($email);
                
                if( $existe ){
                    if( $existe->MAILING_ESTADO_ID != $status ){
                        $this->mailing_model->updateCorreoState($existe->MAILING_ID, $status);
                        $countEditado++;
                    }
                }else{
                    $bool = esMicrosoft($email);
                    $this->mailing_model->insertEmailStatus($email, $bool, $status);
                    $countNoExistente++;
                }
            }else{
                $error .= $email.'<br>';
            }

            $execTime   = diffSegundos($start);
            $i++;
        }
        
        //RECARGAR NUEVOS DATOS EN EL ARCHIVO
        $upFile     = "upload.txt";
        $existen    = file($path, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);

        if( count($existen) > 0 ){
            $content = file($path);
            array_splice($content, 0, ++$i);
            $upContent = implode("",$content);
            logMailing($upFile,$upContent);
            $action     = true;
        }else{
            logMailing($upFile,NULL);
            $action = false;
        }

        $existen    = file($path, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
        $porLeer    = count($existen);
        
        // //COUNT POR LEER

        $msn .= '<strong>ESTADO:</strong> '.nmbEstado($status).'<br>';
        $msn .= '<strong>SEGUNDOS PROCESADOS:</strong> '.diffSegundos($start).'<br>';
        $msn .= '<strong>N° LEIDOS:</strong> '.$i.'<br>';
        $msn .= '<strong>FALTAN:</strong> '.$porLeer.'<br>';
        $msn .= '<strong>N° EDITADOS:</strong> '.$countEditado.'<br>';
        $msn .= '<strong>Nº NO EXISTENTES:</strong> '.$countNoExistente.'<br>';
        
        $data['error'] = $error;
        $data['fin']   = $action;
        $data['time']  = fechaNow();
        $data['msn']   = $msn;

        echo json_encode($data);

    }

	public function searchTexto()
	{
		$data           = array();
        $data['ok']     = false;
        $data['existe'] = false;
		$request        = json_decode(file_get_contents('php://input')); 
		$texto          = $request->texto;
		$radio          = $request->radio;

		$data['correos']    = $this->mailing_model->getCorreoSearchTxt($texto,$radio);
        $data['existe']     = true;
        
        $data['ok'] = true;
        echo json_encode($data);
	}

	public function editEmail()
	{
		$data           = array();
        $data['ok']     = false;
		$request        = json_decode(file_get_contents('php://input')); 
		$email          = $request->email;

        $data['ok'] = $this->mailing_model->updateCorreoCampo($email->MAILING_ID,'MAILING_TXT',$email->MAILING_TXT);
        
        echo json_encode($data);
	}

	public function deleteEmail()
	{
		$data           = array();
        $data['ok']     = false;
		$request        = json_decode(file_get_contents('php://input')); 
		$email          = $request->email;

        $data['ok'] = $this->mailing_model->deleteCorreo($email->MAILING_ID);

        echo json_encode($data);
	}
	
}
