<?php
	
class cliente_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }  

    public function insertCliente($nombre, $email, $fono, $direccion, $comentario, $creado, $actualizado)
    {
        $data = array(
                        "CLIENTE_NMB"        => $nombre,
                        "CLIENTE_EMAIL"      => $email,
                        "CLIENTE_FONO"       => $fono,
                        "CLIENTE_DIRECCION"  => $direccion,
                        "CLIENTE_COMENTARIO" => $comentario,
                        "created_at"         => $creado,
                        "updated_at"         => $actualizado
                    );
        $this->db->insert('cliente', $data);
        return $this->db->insert_id();
    }
	
} 