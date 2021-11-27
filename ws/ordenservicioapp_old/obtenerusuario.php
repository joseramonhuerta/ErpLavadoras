<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_usuario"])){
		$id_usuario=$_GET['id_usuario'];
		
		
		$consulta="SELECT id_usuario, nombre_usuario, usuario, from_base64(pass) AS pass, rol		
			FROM cat_usuarios WHERE id_usuario = {$id_usuario}";
		
		
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
			$results["id_usuario"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	}else{
			$results["id_usuario"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	


 ?>