<?php

/**
 * @brief      Ecommerce Plugin for chilean Webpay
 * @category   Plugins/SDK
 * @author     Allware Ltda. (http://www.allware.cl)
 * @copyright  2015 Transbank S.A. (http://www.tranbank.cl)
 * @date       Jan 2015
 * @license    GNU LGPL
 * @version    2.0.2
 * @link       http://transbankdevelopers.cl/
 *
 * This software was created for easy integration of ecommerce
 * portals with Transbank Webpay solution.
 *
 * Required:
 *  - PHP v5.6
 *  - PHP SOAP library
 *  - Ecommerce vX.X
 *
 * See documentation and how to install at link site
 *
 */

class transactionMallNormalResultOutput{

    var $accountingDate; //string
    var $buyOrder; //string
    var $cardDetail; //cardDetail
    var $detailOutput; //wsTransactionMallDetailOutput
    var $sessionId; //string
    var $transactionDate; //dateTime
    var $urlRedirection; //string
    var $VCI; //string
}

class cardDetailMallNormal{
    
    var $cardNumber;//string
    var $cardExpirationDate;//string
}

class wsTransactionMallDetailOutput{
    
    var $authorizationCode; //string
    var $paymentTypeCode; //string
    var $responseCode; //int
}

class wsTransactionMallDetail{
    
    var $sharesAmount;//decimal
    var $sharesNumber;//int
    var $amount;//decimal
    var $commerceCode;//string
    var $buyOrder;//string
}
class acknowledgeTransactionMallNormal{
    
    var $tokenInput;//string
}

class acknowledgeMallTransactionResponse{
}

class initTransactionMall{
    var $wsInitTransactionInput;//wsInitTransactionInput
}

class wsInitTransactionMallInput{
    
    var $wSTransactionType;//wsTransactionType
    var $commerceId;//string
    var $buyOrder;//string
    var $sessionId;//string
    var $returnURL;//anyURI
    var $finalURL;//anyURI
    var $transactionDetails;//wsTransactionMallDetail
    var $wPMDetail;//wpmDetailMallInput
}

class wpmDetailMallInput{
    
    var $serviceId;//string
    var $cardHolderId;//string
    var $cardHolderName;//string
    var $cardHolderLastName1;//string
    var $cardHolderLastName2;//string
    var $cardHolderMail;//string
    var $cellPhoneNumber;//string
    var $expirationDate;//dateTime
    var $commerceMail;//string
    var $ufFlag;//boolean
}

class initTransactionMallResponse{
    
    var $return;//wsInitTransactionOutput
}

class wsInitTransactionMallOutput{
    
    var $token;//string
    var $url;//string
}

/**
 * TRANSACCI??N DE AUTORIZACI??N MALL NORMAL:
 * Una  transacci??n  Mall  Normal  corresponde  a  una  solicitud  de  autorizaci??n  financiera  de  un 
 * conjunto de  pagos  con tarjetas de cr??dito o d??bito, en donde qui??n  realiza el  pago  ingresa al sitio 
 * del comercio, selecciona productos o servicios, y el  ingreso asociado a los datos de la tarjeta de 
 * cr??dito o d??bito lo realiza  una ??nica vez  en forma segura en Webpay  para el conjunto de pagos. 
 * Cada pago tendr?? su propio resultado, autorizado o rechazado.
 * 
 *  Respuestas WebPay: 
 * 
 *  TSY: Autenticaci??n exitosa
 *  TSN: autenticaci??n fallida.
 *  TO: Tiempo m??ximo excedido para autenticaci??n.
 *  ABO: Autenticaci??n abortada por tarjetahabiente.
 *  U3: Error interno en la autenticaci??n.
 *  Puede ser vac??o si la transacci??n no se autentico.
 *
 *  Codigos Resultado
 * 
 *  0 Transacci??n aprobada.
 *  -1 Rechazo de transacci??n.
 *  -2 Transacci??n debe reintentarse.
 *  -3 Error en transacci??n.
 *  -4 Rechazo de transacci??n.
 *  -5 Rechazo por error de tasa.
 *  -6 Excede cupo m??ximo mensual.
 *  -7 Excede l??mite diario por transacci??n.
 * -8 Rubro no autorizado.
 */

class WebPayMallNormal {
 
    var $soapClient;
    var $config;
    
    /** Configuraci??n de URL seg??n Ambiente */
    private static $WSDL_URL_NORMAL = array(
        "INTEGRACION" => "https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl",
        "CERTIFICACION" => "https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl",
        "PRODUCCION" => "https://webpay3g.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl",
    );
    
    /** Descripci??n de codigos de resultado */
    private static $RESULT_CODES = array(
        "0"  => "Transacci??n aprobada",
        "-1" => "Rechazo de transacci??n",
        "-2" => "Transacci??n debe reintentarse",
        "-3" => "Error en transacci??n",
        "-4" => "Rechazo de transacci??n",
        "-5" => "Rechazo por error de tasa",
        "-6" => "Excede cupo m??ximo mensual",
        "-7" => "Excede l??mite diario por transacci??n",
        "-8" => "Rubro no autorizado",
    );
    
    private static $classmap = array('getTransactionResult' => 'getTransactionResult', 'getTransactionResultResponse' => 'getTransactionResultResponse', 'transactionResultOutput' => 'transactionResultOutput', 'cardDetail' => 'cardDetail', 'wsTransactionMallDetailOutput' => 'wsTransactionMallDetailOutput', 'wsTransactionMallDetail' => 'wsTransactionMallDetail', 'acknowledgeTransaction' => 'acknowledgeTransaction', 'acknowledgeMallTransactionResponse' => 'acknowledgeMallTransactionResponse', 'initTransactionMall' => 'initTransactionMall', 'wsInitTransactionMallInput' => 'wsInitTransactionMallInput', 'wpmDetailMallInput' => 'wpmDetailMallInput', 'initTransactionMallResponse' => 'initTransactionMallResponse', 'wsInitTransactionMallOutput' => 'wsInitTransactionMallOutput');

    function __construct($config) {

        $this->config = $config;
        $privateKey = $this->config->getPrivateKey();
        $publicCert = $this->config->getPublicCert();

        $modo = $this->config->getEnvironmentDefault();
        $url = WebPayMallNormal::$WSDL_URL_NORMAL[$modo];
        
        $this->soapClient = new WSSecuritySoapClient($url, $privateKey, $publicCert, array(
            "classmap" => self::$classmap,
            "trace" => true,
            "exceptions" => true
        ));
    }

    /** Obtiene resultado desde Webpay */
    function _getTransactionResult($getTransactionResult) {

        $getTransactionResultResponse = $this->soapClient->getTransactionResult($getTransactionResult);
        return $getTransactionResultResponse;
    }

    /** Notifica a Webpay Transacci??n OK */
    function _acknowledgeTransaction($acknowledgeTransaction) {

        $acknowledgeTransactionResponse = $this->soapClient->acknowledgeTransaction($acknowledgeTransaction);
        return $acknowledgeTransactionResponse;
    }

    /** Inicia transacci??n con Webpay */
    function _initTransaction($initTransaction) {
        
        $initTransactionResponse = $this->soapClient->initTransaction($initTransaction);
        return $initTransactionResponse;
    }

    /** Descripci??n seg??n codigo de resultado Webpay (Ver Codigo Resultados) */
    function _getReason($code) {
        return WebPayMallNormal::$RESULT_CODES[$code];
    }
    
    /**
     * Permite inicializar una transacci??n en Webpay. Como respuesta a la invocaci??n
     * se genera un token que representa en forma ??nica una transacci??n
     * */
    function initTransaction($buyOrder, $sessionId, $urlReturn, $urlFinal, $stores) {

        try {
            
            error_reporting(0);
            $error = array();

            $wsInitTransactionInput = new wsInitTransactionInput();

            $detailArray = array();

            $wsInitTransactionInput->wSTransactionType = "TR_MALL_WS";
            $wsInitTransactionInput->commerceId = $this->config->getCommerceCode();
            $wsInitTransactionInput->sessionId = $sessionId;
            $wsInitTransactionInput->buyOrder = $buyOrder;

            $wsInitTransactionInput->returnURL = $urlReturn;
            $wsInitTransactionInput->finalURL = $urlFinal;
           
            $cont = 0;
            foreach ($stores as $value) {

                $wsTransactionDetail = new wsTransactionDetail();
                $wsTransactionDetail->commerceCode = $value["storeCode"];
                $wsTransactionDetail->buyOrder = floatval($value["amount"]);
                $wsTransactionDetail->amount = $value["buyOrder"];
                
                $detailArray[$cont] = $wsTransactionDetail;
                $cont++;

            }

            $wsInitTransactionInput->transactionDetails = $detailArray;

            
            $initTransactionResponse = $this->_initTransaction(
                    array("wsInitTransactionInput" => $wsInitTransactionInput)
            );

            /** Validaci??n de firma del requerimiento de respuesta enviado por Webpay */
            $xmlResponse = $this->soapClient->__getLastResponse();
            $soapValidation = new SoapValidation($xmlResponse, $this->config->getWebpayCert());
            $validationResult = $soapValidation->getValidationResult();

            /** Valida conexion a Webpay. Caso correcto retorna URL y Token */
            if ($validationResult === TRUE) {

                $wsInitTransactionOutput = $initTransactionResponse->return;
                return $wsInitTransactionOutput;
                
            } else {

                $error["error"] = "Error validando conexi&oacute;n a Webpay (Verificar que la informaci&oacute;n del certificado sea correcta)";
                $error["detail"] = "No se pudo completar la conexi&oacute;n con Webpay";
            }
        } catch (Exception $e) {

            $error["error"] = "Error conectando a Webpay (Verificar que la informaci&oacute;n del certificado sea correcta)";

            $replaceArray = array('<!--' => '', '-->' => '');
            $error["detail"] = str_replace(array_keys($replaceArray), array_values($replaceArray), $e->getMessage());
        }

        return $error;
    }

    /**
     * Permite obtener el resultado de la transacci??n una vez que 
     * Webpay ha resuelto su autorizaci??n financiera.
     * 
     * Respuesta VCI:
     * 
     * TSY: Autenticaci??n exitosa
     * TSN: autenticaci??n fallida.
     * TO : Tiempo m??ximo excedido para autenticaci??n
     * ABO: Autenticaci??n abortada por tarjetahabiente
     * U3 : Error interno en la autenticaci??n
     * Puede ser vac??o si la transacci??n no se autentico
     * 
     * */
    function getTransactionResult($token) {

        try {

            $getTransactionResult = new getTransactionResult();
            $getTransactionResult->tokenInput = $token;
            $getTransactionResultResponse = $this->_getTransactionResult($getTransactionResult);

            /** Validaci??n de firma del requerimiento de respuesta enviado por Webpay */
            $xmlResponse = $this->soapClient->__getLastResponse();
            $soapValidation = new SoapValidation($xmlResponse, $this->config->getWebpayCert());
            $validationResult = $soapValidation->getValidationResult();

            if ($validationResult === TRUE) {
                
                $transactionResultOutput = $getTransactionResultResponse->return;
                
                /** Indica a Webpay que se ha recibido conforme el resultado de la transacci??n */
                if ($this->acknowledgeTransaction($token)) {

                    return $transactionResultOutput;
                    
                } else {

                    $error["error"] = "Error validando conexi&oacute;n a Webpay (Verificar que la informaci&oacute;n del certificado sea correcta)";
                    $error["detail"] = "No se pudo completar la conexi&oacute;n con Webpay";
                }
            }
        } catch (Exception $e) {

            $error["error"] = "Error conectando a Webpay (Verificar que la informaci&oacute;n del certificado sea correcta)";

            $replaceArray = array('<!--' => '', '-->' => '');
            $error["detail"] = str_replace(array_keys($replaceArray), array_values($replaceArray), $e->getMessage());
        }
    }

    /** Indica  a Webpay que se ha recibido conforme el resultado de la transacci??n */
    function acknowledgeTransaction($token) {

        $acknowledgeTransaction = new acknowledgeTransaction();
        $acknowledgeTransaction->tokenInput = $token;
        $acknowledgeTransactionResponse = $this->_acknowledgeTransaction($acknowledgeTransaction);

        $xmlResponse = $this->soapClient->__getLastResponse();
        $soapValidation = new SoapValidation($xmlResponse, $this->config->getWebpayCert());
        $validationResult = $soapValidation->getValidationResult();
        return $validationResult === TRUE;
    }

}

?>