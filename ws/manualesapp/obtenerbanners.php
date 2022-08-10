<?php

require_once('db_connect.php');

$json = array();

$consulta = "SELECT imagen_banner FROM banner WHERE status = 'A' ORDER BY id_banner";

$resultado = mysqli_query($conexion, $consulta);
	
if($consulta){
	while($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
		$json[] = $row;
	}
	mysqli_close($conexion);
	header('Content-Type: Application/json; charset=utf8');
	echo json_encode($json);
}else{
	$results['id_categoria'] = '';
	$results['nombre_categoria'] = '';
	$json[] = $results;
	mysqli_close($conexion);
	echo json_encode($json);
}

?>