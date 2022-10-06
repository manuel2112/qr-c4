<?php

namespace App\Models;
use CodeIgniter\Model;
	
class ParametroModel extends Model
{
    protected $table = 'parametros';
    public $builder;

    function __construct()
    {
      $db      = \Config\Database::connect();
      $this->builder = $db->table($this->table);
    }
    
    public function getParametro($id)
    {
      $query = $this->builder->getWhere(['PARAMETRO_ID' => $id]);
      return $query;      
    }

    public function updateParametro($iva, $zona, $transbank)
    {
      // $array = array(
      //                 'PARAMETRO_IVA'           => $iva,
      //                 'PARAMETRO_ZONA_HORARIA'  => $zona,
      //                 'PARAMETRO_TRANSBANK'     => $transbank
      //               );
      // $this->db->where('PARAMETRO_ID', 1);
      // $this->db->update('parametros', $array);
    }
	
} 