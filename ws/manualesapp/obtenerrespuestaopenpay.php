<?php 
require_once('db_connect.php');
$logFile = fopen("log.txt", 'a') or die("Error creando archivo");



$json=array();
$msg="";
fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - Inicio webhook") or die("Error escribiendo en el archivo");
$objeto = file_get_contents('php://input');
$json = json_decode($objeto);
fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - Se recibio el Objeto JSON") or die("Error escribiendo en el archivo");
/*pruebas*/
/*
$json = new stdClass();
$objTrans2 = new stdClass();
$json->type = "charge.succeeded";
$json->event_date = "18/02/2022";

$objTrans2->id = "trgussxay18y6uegq1bx";
$objTrans2->amount = "10.00";
$objTrans2->authorization="prueba";

$json->transaction = $objTrans2;
*/

/*fin prueba*/



$type = $json->type;

fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - Tipo de operacion: ".$type) or die("Error escribiendo en el archivo");

if($type == "charge.succeeded"){
	$event_date = $json->event_date;
	$objTrans = $json->transaction;
	$id_trans = $objTrans->id;
	$amount = $objTrans->amount;
	$authorization = $objTrans->authorization;

	fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - Tipo de operacion: ".$type.", event_date: ".$event_date.", id_trans: ".$id_trans.", amount: ".$amount.", authorization: ".$authorization) or die("Error escribiendo en el archivo");

	$id_carrito_compras = 0;
	
	$consulta = "SELECT IFNULL(id_carrito_compras,0) AS id_carrito_compras FROM carrito_compras WHERE id_openpay = '{$id_trans}' AND estatus_carrito = 2 AND formapago = 3 LIMIT 1";
	
	$resultado = mysqli_query($conexion, $consulta);
	$res = mysqli_fetch_array($resultado);
	$id_carrito_compras = $res['id_carrito_compras'];
	
	if($id_carrito_compras > 0){
		fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - response { id_carrito_compras: ".$id_carrito_compras."}") or die("Error escribiendo en el archivo");
		$consulta="INSERT INTO pagos(fecha_pago, id_carrito_compras, importe, autorizacion, fecha_registro, id_openpay) 
		VALUES('{$event_date}',{$id_carrito_compras},'{$amount}','{$authorization}', now(), '{$id_trans}')";
	
		$resultado=mysqli_query($conexion,$consulta);
		fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - se inserto el pago ") or die("Error escribiendo en el archivo");
		$consulta="UPDATE carrito_compras SET estatus_carrito = 3 WHERE id_carrito_compras = {$id_carrito_compras}";
	
		$resultado=mysqli_query($conexion,$consulta);
		fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - se actualizo el estatus del carrito ") or die("Error escribiendo en el archivo");
		$consulta="UPDATE cat_usuarios_manuales SET autorizado = 1 WHERE id_carrito_compras={$id_carrito_compras}";
			
		$resultado=mysqli_query($conexion,$consulta);
		
		fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - Se autorizaron los manuales al usuario ") or die("Error escribiendo en el archivo");
		
	}else{
		fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - No se encontro un carrito pendinte de pago") or die("Error escribiendo en el archivo");
	}
	
	
	
	
}else{
	fwrite($logFile, "\n".date("d/m/Y H:i:s")." obtenerrespuestaopenpay - La operacion no fue exitosa ") or die("Error escribiendo en el archivo");
}
	
fclose($logFile);

echo '200';
	


?>