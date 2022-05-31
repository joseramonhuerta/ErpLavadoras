<?php
require_once('db_connect.php');
require_once '/home/servfix/public_html/erp/vendor/autoload.php';
use Openpay\Data\Openpay as Openpay;
Openpay::setProductionMode(false);
$logFile = fopen("log.txt", 'a') or die("Error creando archivo");

fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - Inicio peticion ") or die("Error escribiendo en el archivo");
$json = array();

if(isset($_GET)){
	
	$id_usuario = $_GET['id_usuario'];
	$importe = $_GET['importe'];
	try{
		
		$consulta = "SELECT id_usuario,email_usuario, nombre_usuario, paterno_usuario, materno_usuario, celular FROM cat_usuarios WHERE id_usuario = {$id_usuario}";
		$res = mysqli_query($conexion, $consulta);
		$reg = mysqli_fetch_array($res);
		
		$id_user=$reg['id_usuario'];
							
		if($id_user > 0){
			$email = $reg['email_usuario'];
			$nombres = $reg['nombre_usuario'];
			$apellidos = $reg['paterno_usuario'].' '.$reg['materno_usuario'];
			$celular = $reg['celular'];	
			
		}else{
			Throw new Exception("El usuario no existe.");						
		}	
		$openpay = Openpay::getInstance('meousvsdgiet2ka7px79','sk_a6cf930308bf4a07b199777e9cbc4744', 'MX');
		$customer = array(
			'name' => $nombres,
			'last_name' => $apellidos,
			'phone_number' => $celular,
			'email' => $email
		);   
		$chargeData = array(
			/*'order_id' => 'oida-0005151115',*/
			/*'source_id' => 'kqgykn96i7bcs1wwhvgw',*/
			'method' => 'store',
			'amount' => $importe,
			/*'device_session_id' => 'kR1MiQhz2otdIuUlQkbEyitIqVMiI16f',*/
			'description' => 'Cargo a tienda',
			'customer' => $customer 
			);
		
		
		try {
			fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - se genera la peticion ") or die("Error escribiendo en el archivo");
			$charge = $openpay->charges->create($chargeData);
			

		} catch (OpenpayApiTransactionError $e) {
			Throw new Exception($e->getMessage());
			fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - error: ".$e->getMessage()) or die("Error escribiendo en el archivo");		

		} catch (OpenpayApiRequestError $e) {
			Throw new Exception($e->getMessage());
			fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - error: ".$e->getMessage()) or die("Error escribiendo en el archivo");	

		} catch (OpenpayApiConnectionError $e) {
			Throw new Exception($e->getMessage());
			fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - error: ".$e->getMessage()) or die("Error escribiendo en el archivo");	

		} catch (OpenpayApiAuthError $e) {
			Throw new Exception($e->getMessage());
			fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - error: ".$e->getMessage()) or die("Error escribiendo en el archivo");	
			
		} catch (OpenpayApiError $e) {
			Throw new Exception($e->getMessage());
			fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - error: ".$e->getMessage()) or die("Error escribiendo en el archivo");	
			
		} catch (Exception $e) {
			Throw new Exception($e->getMessage());
			fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - error: ".$e->getMessage()) or die("Error escribiendo en el archivo");	
		}
				
		$response = array();
		$response['id'] = $charge->id;
		$response['creation_date'] = $charge->creation_date;
		$response['operation_date'] = $charge->operation_date;
		$response['transaction_type'] = $charge->transaction_type;
		$response['status'] = $charge->status;
		$response['amount'] = $charge->amount;
		$response['currency'] = $charge->currency;
		$response['reference'] = $charge->payment_method->reference; 
		$response['barcode_url'] = $charge->payment_method->barcode_url;
		
		fwrite($logFile, "\n".date("d/m/Y H:i:s")." generarpagoopenpay - Cargo creado ") or die("Error escribiendo en el archivo");
		
		$msg = 'Se genero correctamente.';
		$json['success'] = true;
		$json['msg'] = $msg;
		$json['datos'][]= $response;
		
		header('Content-Type: application/json; charset=utf8');
		mysqli_close($conexion);				
		echo json_encode($json);
	
	}catch(Exception $e){			
		$msg = $e->getMessage();
		//$results["id_pago"]="0";
		$json['success'] = false;
		$json['msg'] = $msg;
		$json['datos'][]=[];
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);	
	}
}else{
	mysqli_close($conexion);
	$msg = 'No se recibieron todos los parametros';
	//$results["id_pago"]="0";
	$json['success'] = false;
	$json['msg'] = $msg;
	$json['datos'][]=[];
	header('Content-Type: application/json; charset=utf8');
	echo json_encode($json);
}

?>