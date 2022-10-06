<?php
	
class mailing_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function getCorreos(){
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->get();
        return $query->num_rows();       
    }
    
    public function getCorreoSearch($email){
        $where = array(
                        "MAILING_TXT" => $email
                      );
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->where($where)
                        ->get();
        return $query->num_rows();      
    }

    public function getCorreoCountCampo($campo,$value){
        $where = array(
                        $campo => $value
                      );
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->where($where)
                        ->get();
        return $query->num_rows();      
    }
    
    public function getCorreoSearchRow($email){
        $where = array(
                        "MAILING_TXT" => $email
                      );
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->join('mailing_estado', 'mailing_estado.MAILING_ESTADO_ID = mailing.MAILING_ESTADO_ID ', 'left')
                        ->where($where)
                        ->get();
        return $query->row();      
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

    public function insertEmail($email,$bool){
        $data = array(
                        "MAILING_TXT"           => $email,
                        'MAILING_MICROSOFT'     => $bool
                    );
        $this->db->insert('mailing', $data);
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
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->where($where)
                        ->order_by("MAILING_ID ASC")
                        ->limit($paquete, $grupo)
                        ->get();
        return $query->result();      
    }

    public function getCorreoStatus($idEstado){
        $where = array(
                        "MAILING_ESTADO_ID" => $idEstado
                      );
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->where($where)
                        ->order_by("MAILING_TXT ASC")
                        ->get();
        return $query->result();      
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
        $query = $this->db
                        ->select("*")
                        ->from("mailing")
                        ->join('mailing_estado', 'mailing_estado.MAILING_ESTADO_ID = mailing.MAILING_ESTADO_ID ', 'left')
                        ->like('mailing.MAILING_TXT', $txt)
                        ->where($where)
                        ->order_by("mailing.MAILING_TXT ASC")
                        ->get();
        return $query->result();      
    }
	
	public function updateCorreoState($idEmail,$state){

        $array = array(
                        'MAILING_ESTADO_ID'         => $state,
                        'MAILING_MAILRELAY_STATUS'  => TRUE
                        );
        $this->db->where('MAILING_ID', $idEmail);
        $this->db->update('mailing', $array);
    }
	
	public function updateCorreoCampo($idEmail,$campo,$value){

        $array = array(
                            $campo => $value
                        );
        $this->db->where('MAILING_ID', $idEmail);
        $this->db->update('mailing', $array);
        return true;
    }

    public function deleteCorreo($idEmail)
    {
          $this->db->where('MAILING_ID', $idEmail);
          $this->db->delete('mailing');
          return true; 
    }
	
	/**************************/
	/*********ESTADO***********/
	/**************************/
    
    public function getStatusRow($idEstado){
        $where = array(
                        "MAILING_ESTADO_ID" => $idEstado
                      );
        $query = $this->db
                        ->select("*")
                        ->from("mailing_estado")
                        ->where($where)
                        ->get();
        return $query->row();       
    }

    public function getStatus(){
        $query = $this->db
                        ->select("*")
                        ->from("mailing_estado")
                        ->order_by("MAILING_ESTADO_ID ASC")
                        ->get();
        return $query->result();       
    }
	
} 