<?php

use App\Models\PagoModel;
use App\Models\EmpresaModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if(!function_exists('email_registro'))
{
	function email_registro($nombre,$email,$urlCodReg)
	{
		$asunto = 'REGISTRO FACILBAK QR';
		$info = email_body_registro($nombre,$urlCodReg);
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('email_pago'))
{
	function email_pago($buyOrder)
	{
		$pago_model   	= new PagoModel();
		$empresa_model	= new EmpresaModel();
		
		$mdlPago 		= $pago_model->getPagoRow( 'PAGO_ID', $buyOrder )->getRow();
		$mdlRequest 	= $pago_model->getPagoRequestRow( 'PAGO_ID', $buyOrder )->getRow();
		$mdlEmpresa 	= $empresa_model->getEmpresaTblRow($mdlPago->EMPRESA_ID)->getRow();
		$emailDestino 	= $mdlEmpresa->EMPRESA_EMAIL;

		$asunto = 'COMPROBANTE DE PAGO #'.$buyOrder;

		$mensaje  = email_header($buyOrder);
		$mensaje .= email_data('Orden en Compra', $buyOrder);
		$mensaje .= email_data('Plan',$mdlPago->MEMBRESIA_NOMBRE);
		$mensaje .= email_data('Meses',$mdlPago->PAGO_CANTIDAD);
		$mensaje .= email_data('Fecha',$mdlPago->PAGO_FECHA);
		$mensaje .= email_data('Método de pago','Webpay plus');
		$mensaje .= email_data('Tipo de Pago',tipoPago($mdlRequest->PAGO_REQ_PAY_TYPE_CODE));
		$mensaje .= email_data('Tarjeta N°','**** **** **** '.$mdlRequest->PAGO_REQ_CARD_NUMBER);
		$mensaje .= email_monto('Monto Neto',formatoDinero($mdlPago->PAGO_NETO));
		$mensaje .= email_monto('IVA',formatoDinero($mdlPago->PAGO_IVA));
		$mensaje .= email_monto('Monto Total',formatoDinero($mdlPago->PAGO_TOTAL));
		$mensaje .= email_aviso();
		$mensaje .= email_footer();
				
		return email_atributos($emailDestino,'',$asunto,$mensaje);
	}
}

if(!function_exists('email_formulario'))
{
	function email_formulario($nombre,$email,$plan,$mensaje,$asunto)
	{		
		$info = "<table border='1'>
					<tr><td>Empresa</td><td>".$nombre."</td></tr>
					<tr><td>Plan</td><td>".$plan."</td></tr>
					<tr><td>Email</td><td>".$email."</td></tr>
					<tr><td>Asunto</td><td>".$asunto."</td></tr>
					<tr><td>Mensaje</td><td>".$mensaje."</td></tr>
				</table>";				
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('formulario_contacto'))
{
	function formulario_contacto($nombre,$email,$mensaje)
	{
		$asunto = 'FORMULARIO DE CONTACTO';
		$info 	= "<table border='1'>
					<tr><td>Nombre</td><td>".$nombre."</td></tr>
					<tr><td>Email</td><td>".$email."</td></tr>
					<tr><td>Mensaje</td><td>".$mensaje."</td></tr>
					</table>";				
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('email_recuperaracion'))
{
	function email_recuperaracion($email,$nombre,$urlRec)
	{
		$asunto = 'RECUPERAR CONTRASEÑA';
		$info = email_recuperar_pass($nombre,$urlRec);
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('email_pedido'))
{
	function email_pedido($data)
	{
		$ci = &get_instance();
		$ci->load->model('empresa_model');
		$detalle 	= $data->detalle;
		$cliente 	= $data->persona;
		$shop 		= $data->shop;
		$mensaje	= '';

		$mdlEmpresa   	= $ci->empresa_model->getEmpresaTblRow($detalle->idEmpresa);
		$nmbEmpresa 	= $mdlEmpresa->EMPRESA_NOMBRE;
		$emailEmpresa 	= $mdlEmpresa->EMPRESA_EMAIL;

		$asunto = 'PEDIDO REALIZADO';
		
		$mensaje .= email_usuario_detalle($shop,$detalle,$cliente);
		$mensaje .= email_aviso();
		$mensaje .= email_footer();
				
		return email_atributos($emailEmpresa,$nmbEmpresa,$asunto,$mensaje);
	}
}

if(!function_exists('email_atributos'))
{
	function email_atributos($email,$nombre,$asunto,$mensaje)
	{
		$attr = attEmail();
		$mail = new PHPMailer(true);		

		try {
			$mail->CharSet  = "UTF-8";
			$mail->Encoding = 'base64';
			$mail->Host		= $attr->host;
			$mail->SMTPAuth = true;
			$mail->Username = $attr->username;
			$mail->Password = $attr->password;
			$mail->From		= $attr->from;
			$mail->FromName	= $attr->from;
			$mail->WordWrap = 50;
			$mail->IsHTML(true);
			$mail->AddAddress($email, $nombre);
			$mail->AddBCC($attr->from);
			$mail->AddBCC('manuel2112@hotmail.com');
			$mail->Subject	= $asunto;
			$mail->Body    	= $mensaje;
			$mail->AltBody 	= "Favor configurar su correo para leer HTML.";     
			
			if(!$mail->send()) {
			    $send = FALSE;
			}
		    else {
			    $send = TRUE;
		    }
		    
		} catch (Exception $e) {
			$send = 'No ingresa al TRY';
		}

		return $send;
	}
}