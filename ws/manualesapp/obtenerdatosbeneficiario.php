<?php 
require_once('db_connect.php');

$json=array();	
try{
	//consultar si ya existe un usuario con el mismo correo y la misma contraseña
	$consulta="SELECT IFNULL(id_configuracion,0) as id_configuracion, beneficiario, numero_cuenta, leyenda_pago_oxxo
			FROM cat_configuraciones_app";				
		
	$resultado=mysqli_query($conexion,$consulta);

	if($consulta){			
		if($reg=mysqli_fetch_array($resultado)){		
			$msg = 'Se guardo el usuario correctamente.';
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=$reg;
		}else{
			Throw new Exception("No existe configuracion.");	
		}
		header('Content-Type: application/json; charset=utf8');
		mysqli_close($conexion);				
		echo json_encode($json);
	}else{
		$msg = 'Error en la consulta';
		$json['success'] = false;
		$json['msg'] = $msg;
		$json['datos'][]=[];
		mysqli_close($conexion);
		echo json_encode($json);
	}		
}catch(Exception $e){
	$msg = $e->getMessage();
	$json['success'] = false;
	$json['msg'] = $msg;
	$json['datos'][]= [];
	mysqli_close($conexion);
	echo json_encode($json);
}
