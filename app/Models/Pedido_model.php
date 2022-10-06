<?php
	
class pedido_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function insertPedido($idEmpresa, $idCliente, $tipoEntrega, $tipoPago, $total, $date, $creado, $actualizado)
    {
        $data = array(
                        "EMPRESA_ID"        => $idEmpresa,
                        "CLIENTE_ID"        => $idCliente,
                        "TIPO_ENTREGA_ID"   => $tipoEntrega,
                        "TIPO_PAGO_ID"      => $tipoPago,
                        "PEDIDO_TOTAL"      => $total,
                        "PEDIDO_DATE"       => $date,
                        "created_at"        => $creado,
                        "updated_at"        => $actualizado
                    );
        $this->db->insert('pedido', $data);
        return $this->db->insert_id();
    }

	/*=============================================
	DETALLE
	=============================================*/

    public function insertPedidoDetalle($idPedido, $idProvar, $producto, $provar, $valor, $cantidad, $total, $comentario, $creado, $actualizado)
    {
        $data = array(
                        "PEDIDO_ID"                 => $idPedido,
                        "PROVAR_ID"                 => $idProvar,
                        "PEDIDO_DETALLE_PRODUCTO"   => $producto,
                        "PEDIDO_DETALLE_PROVAR"     => $provar,
                        "PEDIDO_DETALLE_VALOR"      => $valor,
                        "PEDIDO_DETALLE_CANTIDAD"   => $cantidad,
                        "PEDIDO_DETALLE_TOTAL"      => $total,
                        "PEDIDO_DETALLE_COMENTARIO" => $comentario,
                        "created_at"                => $creado,
                        "updated_at"                => $actualizado
                    );
        $this->db->insert('pedido_detalle', $data);
    }
	
} 