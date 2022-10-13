<?php

namespace App\Models;
use CodeIgniter\Model;
	
class EmpresaModel extends Model
{
  public $db;

  function __construct()
  {
    $this->db = \Config\Database::connect();
  }

	public function insertEmpresa($data)
  {
    $this->db
         ->table('empresa')
         ->insert($data);
    return $this->db->insertID();
  }

	public function getEmpresaExisteCampo($campo,$valor)
  {
    $where = array(
                    $campo => $valor
                  );

    $builder = $this->db->table('empresa');
    $builder->select('*');
    $builder->where($where);
    $query = $builder->get();

    return $query;
	}

	public function getEmpresaExisteCampoRow($campo,$valor)
  {
    $where = array(
                    $campo => $valor
                  );

    $builder = $this->db->table('empresa');
    $builder->select('*');
    $builder->where($where);
    $query = $builder->get();

    return $query;
	}

  public function updateEmpresaExisteCampo($idEmpresa,$campo,$valor)
  {
    $where = array(
                    'EMPRESA_ID !=' => $idEmpresa,
                    $campo => $valor
                  );

    $builder = $this->db->table('empresa');
    $builder->select('*');
    $builder->where($where);
    $query = $builder->countAllResults();

    return $query;
	}

	public function updateEmpresaPermiso($codigo)
  {
    $array = array(
            'EMPRESA_STATUS' => true
              );
    $this->db->where('EMPRESA_COD_REG', $codigo);
    $this->db->update('empresa', $array);
  }

  public function getEmpresaRow($idEmpresa)
  {
    $where = array(
                    "EMPRESA_ID" => $idEmpresa
                  );

    $builder = $this->db->table('empresa');
    $builder->select('*');
    $builder->join('geo_comunas', 'geo_comunas.id = empresa.CIUDAD_ID');
    $builder->where($where);
    $query = $builder->get();

    return $query;
	}

  public function getEmpresas()
  {
    $where = array(
                    "EMPRESA_STATUS" => TRUE
                  );

    $builder = $this->db->table('empresa');
    $builder->select('*');
    $builder->where($where);
    $builder->orderBy('EMPRESA_NOMBRE', 'ASC');
    $query = $builder->get();

    return $query;
	}

  public function getEmpresaSlugRow($slug)
  {
      $where = array(
          "EMPRESA_SLUG" => $slug
          );
      $query = $this->db
                    ->select("*")
                    ->from("empresa")
					->join('geo_comunas', 'geo_comunas.id = empresa.CIUDAD_ID')
                    ->where($where)
                    ->get();
      return $query->row();
	}

  public function getEmpresaTblRow($idEmpresa)
  {
    $where = array(
                    "EMPRESA_ID" => $idEmpresa
                  );

    $builder = $this->db->table('empresa');
    $builder->select('*');
    $builder->where($where);
    $query = $builder->get();

    return $query;
  }

	public function updateDatosEmpresa($idEmpresa,$nombre,$fono,$direccion,$descripcion,$comuna,$slug)
  {
    $array = array(
                    'EMPRESA_NOMBRE'		  => $nombre,
                    'EMPRESA_DIRECCION'		=> $direccion,
                    'EMPRESA_FONO'		    => $fono,
                    'EMPRESA_DESCRIPCION' => $descripcion,
                    'CIUDAD_ID'		        => $comuna,
                    'EMPRESA_SLUG'	      => $slug
                  );

    $builder = $this->db->table('empresa');
    $builder->set($array);
    $builder->where('EMPRESA_ID', $idEmpresa);
    $builder->update();
  }

  public function updateRedesEmpresa($idEmpresa,$whatsapp,$web,$facebook,$instagram)
  {
    $array = array(
                    'EMPRESA_WHATSAPP'  => $whatsapp,
                    'EMPRESA_WEB'       => $web,
                    'EMPRESA_FACEBOOK'  => $facebook,
                    'EMPRESA_INSTAGRAM' => $instagram,
                  );

    $builder = $this->db->table('empresa');
    $builder->set($array);
    $builder->where('EMPRESA_ID', $idEmpresa);
    $builder->update();
  }

  public function updateEmpresaCampo($idEmpresa, $campo, $valor)
  {
    $builder = $this->db->table('empresa');
    $builder->set($campo, $valor);
    $builder->where('EMPRESA_ID', $idEmpresa);
    $builder->update();
  }  

  public function getEmpresaNewPass($email,$hash)
  {
      $where = array(
                      "EMPRESA_EMAIL"     => $email,
                      "EMPRESA_REC_PASS"  => $hash
                    );
      $query = $this->db
                      ->select("*")
                      ->from("empresa")
                      ->where($where)
                      ->get();
      return $query->row();
  }

	/*=============================================
	QR
	=============================================*/ 
    
  public function getEmpresaQRRow($idEmpresa)
  {
    $where = array(
                    "EMPRESA_ID" 	=> $idEmpresa,
                    "EMP_QR_FLAG"	=> TRUE
                  );

    $builder = $this->db->table('empresa_qr');
    $builder->select('*');
    $builder->where($where);
    $query = $builder->get();

    return $query;
	}

	public function insertEmpresaQR($data)
  {
    $this->db
         ->table('empresa_qr')
         ->insert($data);
    }

    public function updateEmpresaQRCampo($idEmpresa, $campo, $valor)
    {
      $builder = $this->db->table('empresa_qr');
      $builder->set($campo, $valor);
      $builder->where('EMPRESA_ID', $idEmpresa);
      $builder->update();
  }

} 