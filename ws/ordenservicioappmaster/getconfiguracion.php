<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();
$json=array();
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		$conexion->conectar();
		
		
	$consulta="SELECT IFNULL(id_configuracion,0) as id_configuracion  
					FROM cat_configuracion 
					WHERE status = 'A' LIMIT 1";				
				
	$resultado=mysqli_query($conexion->getConexion(),$consulta);				
		
	$reg=mysqli_fetch_array($resultado);
	$id_configuracion=$reg['id_configuracion'];
				
	if($id_configuracion > 0){
		$consulta="SELECT id_configuracion, nombre_empresa, direccion, telefono, leyenda1, leyenda2, imprimeticket, enviamensaje  
				FROM cat_configuracion
				WHERE status = 'A' LIMIT 1";					
	}else{
		$consulta="SELECT 0 AS id_configuracion, '' AS nombre_empresa, '' AS direccion, '' AS telefono, '' AS leyenda1, '' AS leyenda2, 0 AS imprimeticket, 0 AS enviamensaje";
		
	}	
	
	//throw new Exception($consulta);
	$resultado=mysqli_query($conexion->getConexion(),$consulta);

	if($consulta){

		if($reg=mysqli_fetch_array($resultado)){
			$json['datos'][]=$reg;
		}
		$conexion->closeConexion();
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
	}

	else{
		$results["nombre_empresa"]='';
		$results["direccion"]='';
		$results["telefono"]='';
		$results["leyenda1"]='';
		$results["leyenda2"]='';
		$results["imprimeticket"]=0;
		$results["enviamensaje"]=0;
		$json['datos'][]=$results;
		$conexion->closeConexion();
		echo json_encode($json);
	}




 ?>