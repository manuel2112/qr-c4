<?php

namespace App\Models;
use CodeIgniter\Model;
	
class CiudadModel extends Model
{
  public $db;

  function __construct()
  {
    $this->db = \Config\Database::connect();
  }
  
  public function getRegiones()
  {
    $builder = $this->db->table('geo_regiones');
    $builder->select('*');
    $builder->orderBy('id', 'ASC');
    $query = $builder->get();
    
    return $query;       
  }
	
    // public function getCiudad()
    // {
    //     $query = $this->db
    //                     ->select("*")
    //                     ->from("geo_comunas")
    //                   	->order_by("comuna ASC")
    //                     ->get();
    //     return $query->result();       
    // }
    
    public function getCiudadPorRegion($idRegion)
    {
      $where = array(
              "geo_regiones.id" => $idRegion
            );

      $builder = $this->db->table('geo_regiones');
      $builder->select('*');
      $builder->join('geo_provincias', 'geo_provincias.region_id = geo_regiones.id');
      $builder->join('geo_comunas', 'geo_comunas.provincia_id = geo_provincias.id');
      $builder->where($where);
      $builder->orderBy('geo_comunas.comuna', 'ASC');
      $query = $builder->get();

      return $query;       
    }
	
} 