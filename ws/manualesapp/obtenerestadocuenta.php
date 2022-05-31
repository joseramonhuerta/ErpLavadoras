<?php 
require_once('db_connect.php');

$json=array();
		$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];				
		
		$consulta="SELECT CAST(DATE_FORMAT(uec.fecha,'%d/%m/%Y') as CHAR) AS fecha,uec.concepto,uec.cargo,uec.abono,uec.saldo FROM cat_usuarios_estadocuenta uec
					INNER JOIN cat_usuarios u ON u.id_usuario = uec.id_usuario
					WHERE uec.id_usuario = {$id_usuario} ORDER BY uec.fecha ASC";					

		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){			
			while ($row = mysqli_fetch_array($resultado)) {
                $json[] = $row;
            }
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["fecha"]='';
			$results["concepto"]='';
			$results["cargo"]='';
			$results["abono"]='';
			$results["saldo"]='';
			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	



 ?>