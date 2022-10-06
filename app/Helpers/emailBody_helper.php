<?php

if(!function_exists('email_header'))
{
	function email_header($buyOrder)
	{
		
		$block = '<table style="transform-origin: left top 0px;" width="100%" cellspacing="0" border="0">
		<tbody><tr>
		<td bgcolor="#ffffff" align="center">
		<table style="max-width:500px" width="100%" cellspacing="0" border="0">
		<tbody><tr>
		<td style="padding:15px 0" valign="top" align="center">
		<a href="'.urlSite().'" target="_blank">
		<img src="'.imgLogo().'" alt="'.nmbEmpresa().'" style="max-width:470px; display:block; font-family:Helvetica,Arial,sans-serif; color:#ffffff; font-size:16px" width="250px" border="0"> 
		</a>
		</td></tr></tbody></table></td></tr><tr>
		<td style="padding:15px" bgcolor="#ffffff" align="center">
		<table style="max-width:500px" width="100%" cellspacing="0" border="0">
		<tbody><tr><td>
		<table width="100%" cellspacing="0" border="0">
		<tbody><tr>
		<td style="font-size:32px; font-family:Helvetica,Arial,sans-serif; color:#333333; padding-top:30px" align="center">Comprobante de pedido
		</td></tr><tr>
		<td style="padding:20px 0 0 0; font-size:16px; line-height:25px; font-family:Helvetica,Arial,sans-serif; color:#666666" align="left">El pago por el pedido 
		<b>#'.$buyOrder.'</b> en 
		<b><a href="'.urlSite().'" target="_blank">'.nmbEmpresa().'</a></b>
		<a href="'.urlSite().'" target="_blank"></a>ha sido procesado de manera correcta. <br>
		Se adjuntan los datos de la transacción : 
		</td></tr></tbody></table></td></tr></tbody></table></td></tr><tr>
        <td style="padding:15px" bgcolor="#ffffff" align="center">
        <table style="max-width:500px" width="100%" cellpadding="0" border="0">
		<tbody><tr>';
                    
		return $block;
	}
}

if(!function_exists('email_data'))
{
	function email_data($campo,$valor)
	{
		$block = '<td style="padding:10px 0 0 0; border-top:1px dashed #aaaaaa">
		<table width="100%" cellspacing="0" border="0">
		<tbody><tr><td valign="top">
		<table style="width:47%" cellpadding="0" border="0" align="left">
		<tbody><tr>
		<td style="padding:0 0 10px 0">
		<table width="100%" cellpadding="0" border="0">
		<tbody><tr>
		<td style="font-family:Arial,sans-serif; color:#333333; font-size:16px" align="left">'.$campo.'
		</td></tr></tbody></table></td></tr></tbody></table>
		<table style="width:47%" cellpadding="0" border="0" align="right">
		<tbody><tr>
		<td style="padding:0 0 10px 0">
		<table width="100%" cellpadding="0" border="0">
		<tbody><tr>
		<td style="font-family:Arial,sans-serif; color:#333333; font-size:16px" align="right">'.$valor.'
		</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr>';
                    
		return $block;
	}
}

if(!function_exists('email_monto'))
{
	function email_monto($campo,$valor)
	{
		$block = '<td style="padding:10px 0 0 0; border-top:1px solid #eaeaea">
		<table width="100%" cellspacing="0" border="0">
		<tbody><tr><td valign="top">
		<table style="width:47%" cellpadding="0" border="0" align="left">
		<tbody><tr>
		<td style="padding:0 0 10px 0">
		<table width="100%" cellpadding="0" border="0">
		<tbody><tr>
		<td style="font-family:Arial,sans-serif; color:#333333; font-size:16px" align="left">'.$campo.'
		</td></tr></tbody></table></td></tr></tbody></table>
		<table style="width:47%" cellpadding="0" border="0" align="right">
		<tbody><tr>
		<td style="padding:0 0 10px 0">
		<table width="100%" cellpadding="0" border="0">
		<tbody><tr>
		<td style="font-family:Arial,sans-serif; color:#7ca230; font-size:16px; font-weight:bold" align="right">'.$valor.'
		</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr>';
                    
		return $block;
	}
}

if(!function_exists('email_aviso'))
{
	function email_aviso()
	{
		$block = '<td style="padding:0 0 0 0; font-size:14px; line-height:18px; font-family:Helvetica,Arial,sans-serif; color:#aaaaaa; font-style:italic" align="left">
		</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr>';
                    
		return $block;
	}
}

if(!function_exists('email_footer'))
{    
	function email_footer()
	{
		$block = '<tr><td style="padding:15px" bgcolor="#ffffff" align="center">
		<table width="500" cellpadding="0" border="0">
		<tbody><tr><td></td></tr></tbody></table></td></tr><tr>
		<td style="padding:20px 0px" bgcolor="#ffffff" align="center">
		<table style="max-width:500px" width="100%" cellpadding="0" border="0" align="center">
		<tbody><tr>
		<td style="font-size:12px; line-height:18px; font-family:Helvetica,Arial,sans-serif; color:#666666" align="center">
		<a href="'.urlSite().'" target="_blank" style="color:#666666; text-decoration:none">Procesado por '.nmbEmpresa().'.
		</a> 
		<br></td></tr></tbody></table></td></tr></tbody></table>';
                    
		return $block;
	}
}

if(!function_exists('email_recuperar_pass'))
{    
	function email_recuperar_pass($nombre,$urlRec)
	{
		
		$block = '<table cellpadding="0" cellspacing="0" border="0" id="x_backgroundTable" style="height:auto!important; margin:0; padding:0; width:100%!important; background-color:#f0f0f0; color:#444444">
		<tbody>
		<tr>
		<td>
		<table id="x_contenttable" align="center" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto; border:none; width:100%!important; max-width:600px!important; text-align:left; padding:0 8px">
		<tbody>
		<tr>
		<td width="100%">
		<table bgcolor="#f0f0f0" border="0" cellspacing="0" cellpadding="0" style="width:100%">
		<tbody>
		<tr>
		<td height="15">
		</td>
		</tr>
		<tr>
		<td width="100%" height="60" bgcolor="#f0f0f0" class="x_header">
		<img data-imagetype="External" src="'.imgLogo().'" alt="'.nmbEmpresa().' logo" width="124" border="0" style="display:inline-block; height:auto!important">
		</td>
		</tr>
		<tr>
		<td height="5">
		</td>
		</tr>
		</tbody>
		</table>
		<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="30" style="width:100%">
		<tbody>
		<tr>
		<td width="100%" bgcolor="#ffffff" style="text-align:left">
		<p style="color:#444; font-family:"Helvetica Neue",Arial,Helvetica,sans-serif; font-size:24px; line-height:29px; margin-top:0; margin-bottom:20px; padding:0; font-weight:300">¿Has olvidado tu contraseña?
		</p>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:20px; padding:0; font-weight:normal">'.$nombre.',
		</p>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:20px; padding:0; font-weight:normal">Alguien hizo una solicitud para resetear tu contraseña de '.nmbEmpresa().'.
		</p>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:20px; padding:0; font-weight:normal">Si fuiste tu, puedes elegir una nueva contraseña aquí:
		</p>
		<div style="text-align:center; margin:30px 0; border:0 none">
		<a href="'.$urlRec.'" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="display:inline-block; padding:0; border:12px solid #007bff; border-color:#007bff; margin-bottom:12px; font-size:16px; text-decoration:none; min-width:80px; background-color:#007bff; color:#fff; text-align:center; border-radius:2px" data-linkindex="1">Resetear Contraseña 
		</a>
		</div>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:20px; padding:0; font-weight:normal">Si no fuiste tú quién solicitó una nueva contraseña, no tomes en cuenta este correo.
		</p>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:0; padding:0; font-weight:normal">¡Gracias!
		<br aria-hidden="true">Soporte '.nmbEmpresa().'
		</p>
		</td>
		</tr>
		</tbody>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
		<tbody>
		<tr>
		<td>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:0; padding:10px; font-weight:normal; text-align:center"><a href="'.urlSite().'" target="_blnk">'.nmbEmpresa().'</a></p>
		</td>
		</tr>
		</tbody>
		</table>';
                    
		return $block;
	}
}

if(!function_exists('email_body_registro'))
{
	function email_body_registro($nombre,$urlCodReg)
	{
		
		$block = '<table cellpadding="0" cellspacing="0" border="0" id="x_backgroundTable" style="height:auto!important; margin:0; padding:0; width:100%!important; background-color:#f0f0f0; color:#444444">
		<tbody>
		<tr>
		<td>
		<table id="x_contenttable" align="center" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto; border:none; width:100%!important; max-width:600px!important; text-align:left; padding:0 8px">
		<tbody>
		<tr>
		<td width="100%">
		<table bgcolor="#f0f0f0" border="0" cellspacing="0" cellpadding="0" style="width:100%">
		<tbody>
		<tr>
		<td height="15">
		</td>
		</tr>
		<tr>
		<td width="100%" height="60" bgcolor="#f0f0f0" class="x_header">
		<img data-imagetype="External" src="'.imgLogo().'" alt="'.nmbEmpresa().' logo" width="124" border="0" style="display:inline-block; height:auto!important">
		</td>
		</tr>
		<tr>
		<td height="5">
		</td>
		</tr>
		</tbody>
		</table>
		<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="30" style="width:100%">
		<tbody>
		<tr>
		<td width="100%" bgcolor="#ffffff" style="text-align:left">
		<p style="color:#444; font-family:"Helvetica Neue",Arial,Helvetica,sans-serif; font-size:24px; line-height:29px; margin-top:0; margin-bottom:20px; padding:0; font-weight:300">Valida tu registro
		</p>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:20px; padding:0; font-weight:normal">'.$nombre.',
		</p>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:20px; padding:0; font-weight:normal">Realiza click en el siguiente botón, para validar tu registro:
		</p>
		<div style="text-align:center; margin:30px 0; border:0 none">
		<a href="'.$urlCodReg.'" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="display:inline-block; padding:0; border:12px solid #007bff; border-color:#007bff; margin-bottom:12px; font-size:16px; text-decoration:none; min-width:80px; background-color:#007bff; color:#fff; text-align:center; border-radius:2px" data-linkindex="1">Validar registro 
		</a>
		</div>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:0; padding:0; font-weight:normal">¡Gracias por registrarte!
		<br aria-hidden="true">Soporte '.nmbEmpresa().'
		</p>
		</td>
		</tr>
		</tbody>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
		<tbody>
		<tr>
		<td>
		<p style="color:#666666; font-family:Arial,sans-serif; font-size:15px; line-height:20px; margin-top:0; margin-bottom:0; padding:10px; font-weight:normal; text-align:center"><a href="'.urlSite().'" target="_blnk">'.nmbEmpresa().'</a></p>
		</td>
		</tr>
		</tbody>
		</table>';
                    
		return $block;
	}
}

/**************************************
 				USUARIO
***************************************/
if(!function_exists('email_usuario_header'))
{    
	function email_usuario_header($nmbEmpresa,$imgEmpresa,$nmbCliente,$tipoNegocio,$direccionEmpresa)
	{
		switch ($tipoNegocio) {
			case 1:
				$txtPedido00 = 'Pedido confirmado';
				$txtPedido01 = 'Te avisaremos mediante notificación a tu celular cuando tu pedido esté listo, gracias por tu compra';
				$txtPedido02 = 'Tu pedido de '.$nmbEmpresa.' ya se está preparando';
				$txtPedido03 = '¡Gracias por tu pedido!<br>Tenemos el agrado de confirmar tu pago de forma exitosa';
				break;
			case 2:
				$txtPedido00 = 'Pago confirmado';
				$txtPedido01 = 'Gracias por tu compra';
				$txtPedido02 = '<br>Gracias por comprar en '.$nmbEmpresa.' ';
				$txtPedido03 = '¡Gracias por tu visita!<br>Tenemos el agrado de confirmar tu pago de forma exitosa';
				break;
			case 3:
				$txtPedido00 = 'Pedido confirmado';
				$txtPedido01 = 'Te avisaremos mediante notificación a tu celular cuando tu pedido esté listo, gracias por tu compra';
				$txtPedido02 = 'Tu pedido de '.$nmbEmpresa.' ya se está preparando';
				$txtPedido03 = '¡Gracias por tu pedido!<br>Tenemos el agrado de confirmar tu pago de forma exitosa';
				break;
		}
		
		//NADA
		$block = '<table><tbody><tr><td style="background-color:#ffffff; padding-bottom:9px; border-top:0; border-bottom:0; padding-top:9px;" valign="top"> <table style="border-collapse:collapse; min-width:100%" width="100%" cellspacing="0" > <tbody> <tr> <td style="padding-top:9px" valign="top"> <table style="border-collapse:collapse; max-width:100%; min-width:100%" width="100%" cellspacing="0" cellpadding="0"> <tbody> <tr> <td style="word-break:normal; color:#656565; line-height:150%; font-size:12px; font-family:Helvetica; padding-right:18px; text-align:center; padding-left:18px; padding-bottom:0px; padding-top:0" valign="top">';
		
		$block .= '<img src="'.$imgEmpresa.'" width="150" />';
		
		//NADA
		$block .= '</td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr><tr> <td style="background-color:#262a34; padding-bottom:0; border-top:0; border-bottom:0; padding-top:9px;" valign="top"> <table style="border-collapse:collapse; table-layout:fixed; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td style="min-width:100%; padding:8px 18px"> <table style="border-collapse:collapse; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td> <span></span> </td></tr></tbody> </table> </td></tr></tbody> </table> <table style="border-collapse:collapse; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td style="padding-top:0px" valign="top"> <table style="border-collapse:collapse; max-width:100%; min-width:100%" width="100%" cellspacing="0"> <tbody>';		
		
		$block .= '<tr> <td style="word-break:normal; font-family:Helvetica,Arial,Verdana,sans-serif; font-size:16px; line-height:150%; padding:0px 18px 0px; color:#FFFFFF; text-align:center"> '.$txtPedido00.' <h1 style="font-size:26px; display:block; padding:0; color:#f8f8f8; font-family:Helvetica,Arial,Verdana,sans-serif; margin:0; font-style:normal; font-weight:normal; line-height:125%; letter-spacing:normal; text-align:center"> '.$txtPedido01.' </h1> </td></tr></tbody> </table>';
		
		//NADA
		$block .= '</td></tr></tbody> </table> <table style="border-collapse:collapse; table-layout:fixed; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td style="min-width:100%; padding:15px 18px"> <table style="border-collapse:collapse; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td> <span></span> </td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr><tr> <td style="background-color:#ffffff; padding-bottom:9px; border-top:0; border-bottom:2px solid #EAEAEA; padding-top:0;" valign="top"> <table style="border-collapse:collapse; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td style="padding-top:9px" valign="top"> <table style="border-collapse:collapse; max-width:100%; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td style="word-break:normal; text-align:left; line-height:150%; font-family:Arial; font-size:14px; color:#606060; padding-right:18px; padding-left:18px; padding-bottom:0px; padding-top:0" valign="top">';

		$block .= '<p style="margin:10px 0; padding:0; color:#606060; font-family:Arial; font-size:14px; line-height:150%; text-align:left"> ¡Hola '.$nmbCliente.'! '.$txtPedido02.' </p><p style="margin:10px 0; padding:0; color:#606060; font-family:Arial; font-size:14px; line-height:150%; text-align:left"> '.$txtPedido03.' </p>';
		
		//NADA
		$block .= '<table style="border-collapse:collapse; margin-top:0; margin-right:0; width:100%; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; margin-bottom:16px" width="100%" cellspacing="0"> <tbody> <tr> ';
		
		if( $tipoNegocio == 3 ){
			$block .= '<td style="border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; list-style-type:none; background:#ebe8e4"> <span style="display:block; margin-left:20px; margin-right:20px"><p style="padding:0; margin:10px 0; margin-bottom:0; padding-left:0; padding-bottom:0; padding-right:0; margin-top:0; margin-right:0; padding-top:0; margin-left:0; font-weight:normal; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> <strong>Dirección para retirar el pedido:</strong> </p><p style="padding:0; margin:10px 0; margin-bottom:0; padding-left:0; padding-bottom:0; padding-right:0; margin-top:0; margin-right:0; padding-top:0; margin-left:0; font-weight:normal; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> '.$direccionEmpresa.' </p></span> </td>';
		}
		
		//NADA
		$block .= '</tr></tbody> </table>';
                    
		return $block;
	}
}

if(!function_exists('email_usuario_detalle'))
{    
	function email_usuario_detalle($shop,$detalle,$cliente)
	{
		
		$block = '<table style="border-collapse:collapse; margin-top:0; margin-right:0; width:100%; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; margin-bottom:16px" width="100%" cellspacing="0"> <tbody> <tr> <td colspan="2" style="border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; list-style-type:none; background:#ebe8e4"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-bottom:0; font-weight:bold; padding-left:0; padding-bottom:0; padding-right:0; margin-top:0; margin-right:0; padding-top:0; margin-left:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> Detalles del pedido: </p></span> </td></tr>';
		
		foreach( $shop as $item ){
			
			$block .= '<tr> <td style="border-bottom:2px solid #ffffff; background:#f5f3f0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; list-style-type:none"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:0; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> <b>'.$item->CANTIDAD.' x '.$item->PRODUCTO_NOMBRE.'</b> <br> <b>'.$item->PROVAR_NOMBRE.'</b>';
			
			$obsVar = $item->COMENTARIO;
			$observacion = $obsVar ? '<br>Obs.: '.$obsVar : '';
			$block .= $observacion;
			
			$total = $item->PROVAR_VALOR * $item->CANTIDAD;
			$block .= '</p></span> </td><td style="background:#f5f3f0; font-size:14px; border-bottom:2px solid #ffffff; padding-left:0; list-style-type:none; padding-top:14px; padding-right:0; padding-bottom:14px; vertical-align:top; text-align:right" valign="top"> <span style="display:block; margin-left:20px; margin-right:20px"> <b>'.formatoDinero($total).'</b> </span> </td></tr>';
		}
		
		$block .= '<tr> <td style="border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; list-style-type:none; background:#ebe8e4"> <span style="display:block; margin-left:20px; margin-right:20px"><h4 style="display:block; text-align:left; padding:0; letter-spacing:normal; font-family:Arial; margin:0; font-style:normal; line-height:200%; font-weight:bold; color:#4c4c4c; font-size:16px"> Total: </h4> </span> </td><td style="list-style-type:none; border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; background:#ebe8e4; text-align:right"> <span style="display:block; margin-left:20px; margin-right:20px"><h4 style="margin:0; padding:0; font-family:Arial; display:block; font-style:normal; line-height:200%; letter-spacing:normal; font-size:16px; color:#4c4c4c; font-weight:bold; white-space:nowrap; text-align:right"> '.formatoDinero($detalle->total).' </h4> </span> </td></tr>';

		$block .= '<tr> <td style="border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; list-style-type:none; background:#ebe8e4"> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:20px; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> <b>Entrega</b> </p> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:20px; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> <b>Pago</b> </p> </td><td style="list-style-type:none; border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; background:#ebe8e4; text-align:right"> <span style="display:block; margin-left:20px; margin-right:20px"><p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:20px; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:right; font-size:14px"> '.$detalle->entrega->TIPO_ENTREGA_NMB.' </p> </span> <span style="display:block; margin-left:20px; margin-right:20px"><p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:20px; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:right; font-size:14px"> '.$detalle->pago->TIPO_PAGO_NMB.' </p> </span> </td></tr>';

		$datos = $cliente->nombre ? $cliente->nombre.'<br>' : '' ;
		$datos .= $cliente->email ? $cliente->email.'<br>' : '' ;
		$datos .= $cliente->celular ? $cliente->celular.'<br>' : '' ;
		$datos .= $detalle->entrega->TIPO_ENTREGA_ID == 1 ? $cliente->direccion.'<br>' : '' ;
		$datos .= $cliente->comentario ? $cliente->comentario.'<br>' : '' ;
		
		$block .= '<tr> <td style="list-style-type:none; background:#f5f3f0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; border-bottom:0px"> <span style="display:block; margin-left:20px; margin-right:20px"> <b>Cliente:</b> </span> </td><td style="list-style-type:none; font-size:14px; background:#f5f3f0; padding-left:0; padding-top:14px; padding-right:0; padding-bottom:14px; border-bottom:0px; text-align:right"> <span style="display:block; margin-left:20px; margin-right:20px"> '.$datos.'<br> </span> </td></tr></tbody> </table>';
                    
		return $block;
	}
}

if(!function_exists('email_usuario_footer'))
{    
	function email_usuario_footer($nmbCliente,$nmbEmpresa,$fonoEmpresa,$emailEmpresa,$urlEmpresa)
	{
		
		$block = '<p style="margin:10px 0; padding:0; color:#606060; font-family:Arial; font-size:14px; line-height:150%; text-align:left"> Que disfrutes tu pedido '.$nmbCliente.'! </p><p style="margin:10px 0; padding:0; color:#606060; font-family:Arial; font-size:14px; line-height:150%; text-align:left"> Gracias, <br>'.$nmbEmpresa.' <br><span>'.$urlEmpresa.' <br> '.$fonoEmpresa.'<br>'.$emailEmpresa.'</span> </p><hr style="margin-top:18px; margin-bottom:18px; height:3px; border:0; border-bottom:1px solid #ddd"> </td></tr></tbody> </table> </td></tr></tbody> </table> </tbody></table>';
                    
		return $block;
	}
}

if(!function_exists('email_pedido_aviso'))
{    
	function email_pedido_aviso()
	{
		
		$block = '<table><tbody><tr><td style="padding:0 0 0 0; font-size:14px; line-height:18px; font-family:Helvetica,Arial,sans-serif; color:#aaaaaa; font-style:italic" align="left">
		'.nmbEmpresa().' es solo el facilitador del proceso de pago y no se hace responsable sobre la entrega de productos y servicios. Cualquier duda o consulta por favor contacta al comercio. 
		</td></tr></tbody></table>';
                    
		return $block;
	}
}

/**************************************
 				CLIENTE
***************************************/
if(!function_exists('email_cliente_header'))
{    
	function email_cliente_header($tipoNegocio,$imgEmpresa)
	{
		$txtPedido00 = 'Pedido confirmado';
		
		switch ($tipoNegocio) {
			case 1:
				$txtPedido = $txtPedido00 . ': DELIVERY';
				break;
			case 2:
				$txtPedido = $txtPedido00 . ': PAGO EN LOCAL';
				break;
			case 3:
				$txtPedido = $txtPedido00 . ': RETIRO EN LOCAL';
				break;
		}
		
		//NADA
		$block = '<table><tbody><tr><td style="background-color:#ffffff; padding-bottom:9px; border-top:0; border-bottom:0; padding-top:9px;" valign="top"> <table style="border-collapse:collapse; min-width:100%" width="100%" cellspacing="0" > <tbody> <tr> <td style="padding-top:9px" valign="top"> <table style="border-collapse:collapse; max-width:100%; min-width:100%" width="100%" cellspacing="0" cellpadding="0"> <tbody> <tr> <td style="word-break:normal; color:#656565; line-height:150%; font-size:12px; font-family:Helvetica; padding-right:18px; text-align:center; padding-left:18px; padding-bottom:0px; padding-top:0" valign="top">';
		
		$block .= '<img src="'.$imgEmpresa.'" width="150" />';
		
		//NADA
		$block .= '</td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr><tr> <td style="background-color:#262a34; padding-bottom:0; border-top:0; border-bottom:0; padding-top:9px;" valign="top"> <table style="border-collapse:collapse; table-layout:fixed; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td style="min-width:100%; padding:8px 18px 0"><table style="border-collapse:collapse; min-width:100%" width="100%" cellspacing="0"> <tbody> <tr> <td style="padding-top:0px" valign="top">';		
		
		$block .= '<table style="border-collapse:collapse; max-width:100%; min-width:100%" width="100%" cellspacing="0"> <tbody><tr> <td><h1 style="font-size:26px; display:block; padding:0 0 20px; color:#f8f8f8; font-family:Helvetica,Arial,Verdana,sans-serif; margin:0; font-style:normal; font-weight:normal; line-height:125%; letter-spacing:normal; text-align:center"> '.$txtPedido.' </h1> </td></tr></tbody></table>';
                    
		return $block;
	}
}

if(!function_exists('email_cliente_detalle'))
{    
	function email_cliente_detalle($mdlDetalles,$mdlPedido,$mdlUsuario)
	{
		
		$block = '<table style="border-collapse:collapse; margin-top:0; margin-right:0; width:100%; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; margin-bottom:16px" width="100%" cellspacing="0"> <tbody> <tr> <td colspan="2" style="border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; list-style-type:none; background:#ebe8e4"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-bottom:0; font-weight:bold; padding-left:0; padding-bottom:0; padding-right:0; margin-top:0; margin-right:0; padding-top:0; margin-left:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> Detalles de tu pedido: </p></span> </td></tr>';
		
		foreach( $mdlDetalles as $detalle ){
			$block .= '<tr> <td style="border-bottom:2px solid #ffffff; background:#f5f3f0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; list-style-type:none"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:0; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> <b>'.$detalle->PEDIDO_DETALLE_CANT.' x '.$detalle->PRODUCTO_NOMBRE.'</b> <br> <b>'.$detalle->PROVAR_DESC.'</b> <br>'.$detalle->PEDIDO_DETALLE_OBS.'</p></span> </td><td style="background:#f5f3f0; font-size:14px; border-bottom:2px solid #ffffff; padding-left:0; list-style-type:none; padding-top:14px; padding-right:0; padding-bottom:14px; vertical-align:top; text-align:right" valign="top"> <span style="display:block; margin-left:20px; margin-right:20px"> <b>'.formatoDinero($detalle->PEDIDO_DETALLE_TOTAL).'</b> </span> </td></tr>';
		}
		
		if( $mdlPedido->PEDIDO_PROPINA ){
			$block .= '<tr> <td style="border-bottom:2px solid #ffffff; background:#f5f3f0; list-style-type:none; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; font-size:14px; background-color:#eef9ef"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:0; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> <b>Propina</b> </p></span> </td><td style="background:#f5f3f0; border-bottom:2px solid #ffffff; list-style-type:none; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; background-color:#eef9ef; vertical-align:top; text-align:right" valign="top"> <span style="display:block; margin-left:20px; margin-right:20px"> <b>'.formatoDinero($mdlPedido->PEDIDO_PROPINA).'</b> </span> </td></tr>';
		}
		if( $mdlPedido->PEDIDO_DELIVERY ){
			$block .= '<tr> <td style="border-bottom:2px solid #ffffff; background:#f5f3f0; list-style-type:none; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; font-size:14px; background-color:#eef9ef"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:0; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> <b>Delivery</b> </p></span> </td><td style="background:#f5f3f0; border-bottom:2px solid #ffffff; list-style-type:none; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; background-color:#eef9ef; vertical-align:top; text-align:right" valign="top"> <span style="display:block; margin-left:20px; margin-right:20px"> <b>'.formatoDinero($mdlPedido->PEDIDO_DELIVERY).'</b> </span> </td></tr>';
		}
		
		$block .= '<tr> <td style="border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; list-style-type:none; background:#ebe8e4"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:0; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; text-align:left; font-size:14px"> Sub-Total: </p><h4 style="display:block; text-align:left; padding:0; letter-spacing:normal; font-family:Arial; margin:0; font-style:normal; line-height:200%; font-weight:bold; color:#4c4c4c; font-size:16px"> Total: </h4> </span> </td><td style="list-style-type:none; border-bottom:2px solid #ffffff; padding-left:0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; background:#ebe8e4; text-align:right"> <span style="display:block; margin-left:20px; margin-right:20px"> <p style="padding:0; margin:10px 0; margin-right:0; padding-left:0; padding-bottom:0; padding-right:0; padding-top:0; margin-top:0; margin-left:0; margin-bottom:0; line-height:150%; color:#606060; font-family:Arial; font-size:14px; text-align:right"> '.formatoDinero($mdlPedido->PEDIDO_SUBTOTAL).' </p><h4 style="margin:0; padding:0; font-family:Arial; display:block; font-style:normal; line-height:200%; letter-spacing:normal; font-size:16px; color:#4c4c4c; font-weight:bold; white-space:nowrap; text-align:right"> '.formatoDinero($mdlPedido->PEDIDO_TOTAL).' </h4> </span> </td></tr>';

		$datos = $mdlUsuario->USUARIO_INFO_NOMBRE ? $mdlUsuario->USUARIO_INFO_NOMBRE.'<br>' : '' ;
		$datos .= $mdlUsuario->USUARIO_INFO_EMAIL ? $mdlUsuario->USUARIO_INFO_EMAIL.'<br>' : '' ;
		$datos .= $mdlUsuario->USUARIO_INFO_FONO ? $mdlUsuario->USUARIO_INFO_FONO.'<br>' : '' ;
		if( $mdlPedido->TIPO_NEGOCIO_ID == 1 ){
			$datos .= $mdlUsuario->USUARIO_INFO_DIRECCION ? $mdlUsuario->USUARIO_INFO_DIRECCION.'<br>' : '' ;
			$datos .= $mdlUsuario->USUARIO_INFO_CIUDAD ? $mdlUsuario->USUARIO_INFO_CIUDAD.'<br>' : '' ;
		}
		
		$block .= '<tr> <td style="list-style-type:none; background:#f5f3f0; font-size:14px; padding-top:14px; padding-right:0; padding-bottom:14px; padding-left:0; border-bottom:0px"> <span style="display:block; margin-left:20px; margin-right:20px"> <b>Datos cliente:</b> </span> </td><td style="list-style-type:none; font-size:14px; background:#f5f3f0; padding-left:0; padding-top:14px; padding-right:0; padding-bottom:14px; border-bottom:0px; text-align:right"> <span style="display:block; margin-left:20px; margin-right:20px"> '.$datos.'<br> </span> </td></tr></tbody> </table>';
                    
		return $block;
	}
}

if(!function_exists('email_cliente_footer'))
{    
	function email_cliente_footer()
	{
		
		$block = '<hr style="margin-top:18px; margin-bottom:18px; height:3px; border:0; border-bottom:1px solid #ddd"> </td></tr></tbody> </table> </td></tr></tbody> </table> </tbody></table>';
                    
		return $block;
	}
}