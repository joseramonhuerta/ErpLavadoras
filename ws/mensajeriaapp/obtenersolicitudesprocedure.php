<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET)){
					
		//$ids = $_GET['ids_solicitudes'];
		
		//$ids = array("1", "2", "3", "4");
		$ids = "1,2,3,4,5";
		$consulta="CALL obtenersolicitudes('{$ids}')";		
		
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
			$results["id_pedido"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	}else{
			$results["id_pedido"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
	}


 ?>