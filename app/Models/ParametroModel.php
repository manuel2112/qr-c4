<?php

namespace App\Models;
use CodeIgniter\Model;
	
class ParametroModel extends Model
{
    protected $table = 'parametros';
    public $db;

    function __construct()
    {
      $this->db = \Config\Database::connect();
    }
    
    public function getParametro($id)
    {
      $where = array(
                      'PARAMETRO_ID' => $id
                    );
  
      $builder = $this->db->table('parametros');
      $builder->select('*');
      $builder->where($where);
      $query = $builder->get();
  
      return $query;    
    }

    public function updateParametro($iva, $zona, $transbank)
    {
      $array = array(
        'PARAMETRO_IVA'           => $iva,
        'PARAMETRO_ZONA_HORARIA'  => $zona,
        'PARAMETRO_TRANSBANK'     => $transbank
      );

      $builder = $this->db->table('parametros');
      $builder->set($array);
      $builder->where('PARAMETRO_ID', 1);
      $builder->update();
    }
	
} 