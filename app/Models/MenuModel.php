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

    $builder = $this->db->table('grupo');
    $builder->select('*');
    $builder->where($where);
    $builder->orderBy('GRUPO_ORDEN', 'DESC');
    $query = $builder->get();

    return $query;
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
    $builder = $this->db->table('grupo');
    $builder->set($campo, $valor);
    $builder->where('GRUPO_ID', $idGrupo);
    $builder->update();
  }

  public function getCountProductos($idEmpresa)
  {
    $where = array(
                    "EMPRESA_ID" => $idEmpresa,
                    "GRUPO_FLAG" => true
                  );

    $builder = $this->db->table('grupo');
    $builder->select('*');
    $builder->where($where);
    $query = $builder->countAllResults();

    return $query;
  }

	/*=============================================
	PRODUCTO
	=============================================*/  

  public function insertProducto($data)
  {
    $this->db
         ->table('producto')
         ->insert($data);
    return $this->db->insertID();
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

    $builder = $this->db->table('producto');
    $builder->select('*');
    $builder->where($where);
    $builder->orderBy('PRODUCTO_ORDEN', 'DESC');
    $query = $builder->get();

    return $query;  
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
    $builder = $this->db->table('producto');
    $builder->set($campo, $valor);
    $builder->where('PRODUCTO_ID', $idProducto);
    $builder->update();
  }

	/*=============================================
	VARIACION DE PRECIO
	=============================================*/

  public function insertVariacionProducto($data)
  {
    $this->db
         ->table('producto_variacion')
         ->insert($data);
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

    $builder = $this->db->table('producto_variacion');
    $builder->select('*');
    $builder->where($where);
    $builder->orderBy('PROVAR_ID', 'ASC');
    $query = $builder->get();

    return $query; 
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
    $builder = $this->db->table('producto_variacion');
    $builder->where('PRODUCTO_ID', $idProducto);
    $builder->delete(); 
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

    $builder = $this->db->table('producto_imagen');
    $builder->select('*');
    $builder->where($where);
    $builder->orderBy('PROIMG_ID', 'ASC');
    $query = $builder->get();

    return $query;
  }

  public function updateImagenCampo($idImg, $campo, $valor)
  {
    $builder = $this->db->table('producto_imagen');
    $builder->set($campo, $valor);
    $builder->where('PROIMG_ID', $idImg);
    $builder->update();
  }

} 