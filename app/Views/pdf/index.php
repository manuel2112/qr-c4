<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Comprobante de pago <?php echo $compra->PAGO_ORDEN ?></title>
        <style>
        h1{
            font-size: 25px;
            text-align: center;
            text-transform: uppercase;
        }
        h2{
            font-size: 20px;
            text-align: center;
            text-transform: uppercase;
        }
        img{
            width: 15%;
            float: left;
            margin-top: -20px;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        tr:nth-child(even){
            background-color: #f2f2f2;
        }
        td{
            text-align: right;
            text-transform: uppercase;
            width: 50%;
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
    </head>
    <body>

        <img src="<?php echo base_url('/public/images/logo.png')?>" alt="FacilbakQR" />

        <h1>COMPROBANTE DE PAGO</h1>
        <hr>
        <h2>DETALLE</h2>

        <table>
            <tr>
                <td>ORDEN DE COMPRA</td>
                <td><?php echo $compra->PAGO_ORDEN ?></td>
            </tr>
            <tr>
                <td>PLAN</td>
                <td><?php echo $compra->MEMBRESIA_NOMBRE ?></td>
            </tr>
            <tr>
                <td>CANTIDAD</td>
                <td><?php echo $compra->PAGO_CANTIDAD ?></td>
            </tr>
            <tr>
                <td>NETO</td>
                <td><?php echo formatoDinero($compra->PAGO_NETO) ?></td>
            </tr>
            <tr>
                <td>IVA</td>
                <td><?php echo formatoDinero($compra->PAGO_IVA) ?></td>
            </tr>
            <tr>
                <td>TOTAL</td>
                <td><?php echo formatoDinero($compra->PAGO_TOTAL) ?></td>
            </tr>
            <tr>
                <td>FECHA</td>
                <td><?php echo fechaLatinaConHora($compra->PAGO_FECHA) ?></td>
            </tr>
            <tr>
                <td>PAGO CON</td>
                <td>WEBPAY</td>
            </tr>
            <tr>
                <td>TARJETA N°</td>
                <td>**** **** **** <?php echo $compra->PAGO_REQ_CARD_NUMBER ?></td>
            </tr>
            <tr>
                <td>TIPO DE PAGO</td>
                <td><?php echo tipoPago($compra->PAGO_REQ_PAY_TYPE_CODE) ?></td>
            </tr>
            <?php if( ( $compra->PAGO_REQ_INSTALLMENTS_NUMBER ) ){ ?> 
                <tr>
                    <td>N° DE CUOTAS</td>
                    <td><?php echo $compra->PAGO_REQ_INSTALLMENTS_NUMBER ?></td>
                </tr>                
            <?php } ?>
        </table>
        
    </body>
</html>