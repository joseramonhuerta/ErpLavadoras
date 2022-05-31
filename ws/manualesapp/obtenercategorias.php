<?php

require_once('db_connect.php');

$json = array();

$consulta = "SELECT id_categoria, nombre_categoria, icono, imagen_categoria FROM cat_categorias WHERE status = 'A' ORDER BY id_categoria";

$resultado = mysqli_query($conexion, $consulta);
	
if($consulta){
	while($row = mysqli_fetch_array($resultado)){
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