<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_cliente"])){
		$id_cliente=$_GET['id_cliente'];
		
		
		$consulta="SELECT id_cliente, nombre_cliente, celular, direccion		
			FROM cat_clientes WHERE id_cliente = {$id_cliente}";
		
		
		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$json[]=$reg;
			}
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_cliente"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	}else{
			$results["id_cliente"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	


 ?>