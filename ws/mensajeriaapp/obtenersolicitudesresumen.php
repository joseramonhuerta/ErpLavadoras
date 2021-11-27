<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET)){
					
		$id_usuario = $_GET['id_usuario'];
		$limite = $_GET['limite'];
		
		$consulta="CALL obtenersolicitudesresumen({$id_usuario},{$limite})";		
		
		
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