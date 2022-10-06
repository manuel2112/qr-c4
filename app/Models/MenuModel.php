<?php

namespace App\Models;
use CodeIgniter\Model;
	
class MenuModel extends Model
{
  public $db;

  function __construct()
  {
    $this->db = \Config\Database::connect();
  }

	/*=============================================
	GRUPO
	=============================================*/  

  public function insertGrupo($data)
  {
    $this->db
         ->table('grupo')
         ->insert($data);
    return $this->db->insertID();
  }

  public function getGrupoPorEmpresa($idEmpresa)
  {
        $where = array(
                        "EMPRESA_ID" => $idEmpresa,
                        "GRUPO_FLAG" => true
                      );
        $query = $this->db
                        ->select("*")
                        ->from("grupo")
                        ->where($where)
                      	->order_by('GRUPO_ORDEN DESC') 
                        ->get();
        return $query->result();  
  }

  public function getGrupoPorEmpresaShow($idEmpresa)
  {
        $where = array(
                        "EMPRESA_ID" => $idEmpresa,
                        "GRUPO_SHOW" => true,
                        "GRUPO_FLAG" => true
                      );
        $query = $this->db
                        ->select("*")
                        ->from("grupo")
                        ->where($where)
                      	->order_by('GRUPO_ORDEN DESC') 
                        ->get();
        return $query->result();  
  }

  public function updateGrupoCampo($idGrupo, $campo, $valor)
  {
    $array = array(
                    $campo => $valor
                  );
    $this->db->where('GRUPO_ID', $idGrupo);
    $this->db->update('grupo', $array);
  }

  public function getCountProductos($idEmpresa)
  {
        $where = array(
                        "EMPRESA_ID" => $idEmpresa,
                        "GRUPO_FLAG" => true
					            );
        $query = $this->db
                        ->select("*")
                        ->from("grupo")
                        ->where($where)
                        ->get();
        return $query->num_rows();
  }

	/*=============================================
	PRODUCTO
	=============================================*/  

  public function insertProducto($idGrupo,$nombre,$detalle,$descripcion,$linked,$show)
  {
		$data = array(
                    'GRUPO_ID'        => $idGrupo,
                    'PRODUCTO_NOMBRE' => $nombre,
                    'PRODUCTO_DET'    => $detalle,
                    'PRODUCTO_DESC'   => $descripcion,
                    'PRODUCTO_LINKED' => $linked,
                    'PRODUCTO_SHOW'   => $show
                  );
		$this->db->insert('producto', $data);
    return $this->db->insert_id();
  }

  public function insertProductoInt($data)
  {
    $this->db
         ->table('producto')
         ->insert($data);
    return $this->db->insertID();
  }

  public function getProductoPorGrupo($idGrupo)
  {
        $where = array(
                        "GRUPO_ID"      => $idGrupo,
                        "PRODUCTO_FLAG" => true
                      );
        $query = $this->db
                        ->select("*")
                        ->from("producto")
                        ->where($where)
                      	->order_by('PRODUCTO_ORDEN DESC') 
                        ->get();
        return $query->result();  
  }

  public function getProductoPorGrupoShow($idGrupo)
  {
        $where = array(
                        "GRUPO_ID"      => $idGrupo,
                        "PRODUCTO_SHOW" => TRUE,
                        "PRODUCTO_FLAG" => TRUE
                      );
        $query = $this->db
                        ->select("*")
                        ->from("producto")
                        ->where($where)
                      	->order_by('PRODUCTO_ORDEN DESC') 
                        ->get();
        return $query->result();  
  }

  public function updateProductoCampo($idProducto, $campo, $valor)
  {
    $array = array(
                    $campo => $valor
                  );
    $this->db->where('PRODUCTO_ID', $idProducto);
    $this->db->update('producto', $array);
  }

	/*=============================================
	VARIACION DE PRECIO
	=============================================*/

  public function insertVariacionProducto($idProducto,$nombre,$valor,$base)
  {
		$data = array(
                    'PROVAR_NOMBRE' => $nombre,
                    'PROVAR_VALOR'  => $valor,
                    'PROVAR_BASE'   => $base,
                    'PRODUCTO_ID'   => $idProducto
                  );
		$this->db->insert('producto_variacion', $data);
  }

  public function insertVariacionProductoIns($data)
  {
    $this->db
         ->table('producto_variacion')
         ->insert($data);
  }

  public function getVariacionPorProducto($idProducto)
  {
        $where = array(
                        "PRODUCTO_ID" => $idProducto,
                        "PROVAR_FLAG" => true
                      );
        $query = $this->db
                        ->select("*")
                        ->from("producto_variacion")
                        ->where($where)
                      	->order_by('PROVAR_ID ASC') 
                        ->get();
        return $query->result();  
  }

  public function getValorBaseProducto($idProducto)
  {
        $where = array(
                        "PRODUCTO_ID" => $idProducto,
                        "PROVAR_BASE" => true,
                        "PROVAR_FLAG" => true
                      );
        $query = $this->db
                        ->select("*")
                        ->from("producto_variacion")
                        ->where($where)
                        ->get();
        return $query->row();  
  }

  public function deleteVariacionPorProducto($idProducto)
  {
    	$this->db->where('PRODUCTO_ID', $idProducto);
    	$this->db->delete('producto_variacion');  
  }

	/*=============================================
	PRODUCTO IMAGEN
	=============================================*/

  public function insertProductoImg($data)
  {
    $this->db
         ->table('producto_imagen')
         ->insert($data);
  }

  public function getImgPorProducto($idProducto,$limit)
  {
        $where = array(
                        "PRODUCTO_ID" => $idProducto,
                        "PROIMG_FLAG" => true
                      );
        $query = $this->db
                        ->select("*")
                        ->from("producto_imagen")
                        ->where($where)
                      	->order_by('PROIMG_ID ASC') 
                      	->limit($limit) 
                        ->get();
        return $query->result();  
  }

  public function updateImagenCampo($idImg, $campo, $valor)
  {
    $array = array(
                    $campo => $valor
                  );
    $this->db->where('PROIMG_ID', $idImg);
    $this->db->update('producto_imagen', $array);
  }

} 