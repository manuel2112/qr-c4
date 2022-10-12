<?php

namespace App\Models;
use CodeIgniter\Model;
	
class MailingModel extends Model
{
    public $db;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function getCorreos(){
    
        $builder = $this->db->table('mailing');
        $builder->select('*');
        $query = $builder->countAllResults();
    
        return $query;       
    }
    
    public function getCorreoSearch($email){  
        
        $where = array(
                        "MAILING_TXT" => $email
                      );
    
        $builder = $this->db->table('mailing');
        $builder->select('*');
        $builder->where($where);
        $query = $builder->countAllResults();
    
        return $query;      
    }

    public function getCorreoCountCampo($campo,$value){  

        $where = array(
                        $campo => $value
                      );
    
        $builder = $this->db->table('mailing');
        $builder->select('*');
        $builder->where($where);
        $query = $builder->countAllResults();
    
        return $query;    
    }
    
    public function getCorreoSearchRow($email){
        $where = array(
                        "MAILING_TXT" => $email
                      );
    
        $builder = $this->db->table('mailing');
        $builder->select('*');
        $builder->join('mailing_estado', 'mailing_estado.MAILING_ESTADO_ID = mailing.MAILING_ESTADO_ID', 'left');
        $builder->where($where);
        $query = $builder->get();
    
        return $query;     
    }
    
    public function getCorreoLastID(){
        $query = $this->db
                        ->select(" MAX(MAILING_ID) AS MAX ")
                        ->from("mailing")
                        ->get();
        return $query->row();      
    }
    
    public function getCorreoLast($idEmail){
        $where = array(
                        "MAILING_ID" => $idEmail
                      );
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->where($where)
                        ->get();
        return $query->row();      
    }

    public function insertEmail($data){
        $this->db
             ->table('mailing')
             ->insert($data);
    }  

    public function insertEmailStatus($email,$bool,$status){
        $data = array(
                        "MAILING_TXT"           => $email,
                        'MAILING_MICROSOFT'     => $bool,
                        'MAILING_ESTADO_ID'     => $status
                    );
        $this->db->insert('mailing', $data);
    }  

    public function getCorreoGrupo($paquete,$grupo){
        $where = array(
                        "MAILING_MAILRELAY_STATUS" => FALSE
                      );
    
        $builder = $this->db->table('mailing');
        $builder->select('*');
        $builder->where($where);
        $builder->orderBy('MAILING_ID', 'ASC');
        $builder->limit($paquete, $grupo);
        $query = $builder->get();
    
        return $query;
    }

    public function getCorreoStatus($idEstado){
        $where = array(
                        "MAILING_ESTADO_ID" => $idEstado
                      );
    
        $builder = $this->db->table('mailing');
        $builder->select('*');
        $builder->where($where);
        $builder->orderBy('MAILING_TXT', 'ASC');
        $query = $builder->get();
    
        return $query;     
    }

    public function getCorreoSearchTxt($txt,$radio){
        switch ($radio) {
            case '1':
                $wh = array( "mailing.MAILING_TXT !="  => '' );
                break;
            case '2':
                $wh = array( "mailing.MAILING_MAILRELAY_STATUS"  => TRUE );
                break;
            case '3':
                $wh = array( "mailing.MAILING_MAILRELAY_STATUS"  => FALSE );
                break;
        }
        $where = $wh;
    
        $builder = $this->db->table('mailing');
        $builder->select('*');
        $builder->join('mailing_estado', 'mailing_estado.MAILING_ESTADO_ID = mailing.MAILING_ESTADO_ID ', 'left');
        $builder->where($where);
        $builder->like('mailing.MAILING_TXT', $txt);
        $builder->orderBy('mailing.MAILING_TXT', 'ASC');
        $query = $builder->get();
    
        return $query;     
    }
	
	public function updateCorreoState($idEmail,$state){

        $array = array(
                        'MAILING_ESTADO_ID'         => $state,
                        'MAILING_MAILRELAY_STATUS'  => TRUE
                        );

        $builder = $this->db->table('mailing');
        $builder->set($array);
        $builder->where('MAILING_ID', $idEmail);
        $builder->update();
    }
	
	public function updateCorreoCampo($idEmail,$campo,$value){
        $builder = $this->db->table('mailing');
        $builder->set($campo, $value);
        $builder->where('MAILING_ID', $idEmail);
        $builder->update();
        return true;
    }

    public function deleteCorreo($idEmail)
    {
        $builder = $this->db->table('mailing');
        $builder->where('MAILING_ID', $idEmail);
        $builder->delete();
        return true; 
    }
	
	/**************************/
	/*********ESTADO***********/
	/**************************/
    
    public function getStatusRow($idEstado){
        $where = array(
                        "MAILING_ESTADO_ID" => $idEstado
                      );
    
        $builder = $this->db->table('mailing_estado');
        $builder->select('*');
        $builder->where($where);
        $query = $builder->get();
    
        return $query;       
    }

    public function getStatus(){
    
        $builder = $this->db->table('mailing_estado');
        $builder->select('*');
        $builder->orderBy('MAILING_ESTADO_ID', 'ASC');
        $query = $builder->get();
    
        return $query;   
    }
	
} 