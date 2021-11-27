<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["usuario"]) && isset($_GET["clave"])){
		$usuario=$_GET['usuario'];
		$clave=$_GET['clave'];
		

		
		$consulta="SELECT id_usuario, nombre_usuario, usuario, pass, rol, CASE rol WHEN 1 THEN 'Usuario' WHEN 2 THEN 'Cliente' WHEN 3 THEN 'Administrador' END AS descripcion_rol, foto FROM cat_usuarios WHERE usuario = '{$usuario}' AND pass = to_base64('{$clave}') AND status = 'A'";
		$resultado=mysqli_query($conexion,$consulta);
//AND aes_decrypt(pass, 'asdf') =
		if($consulta){

			if($reg=mysqli_fetch_array($resultado)){
				$json['datos'][]=$reg;
			}
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_usuario"]=0;
			$results["usuario"]='';
			$results["clave"]='';
			$results["nombre"]='';			
			$json['datos'][]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	}
	else{
			$results["id_usuario"]=0;
			$results["usuario"]='';
			$results["clave"]='';
			$results["nombre"]='';			
			$json['datos'][]=$results;
			echo json_encode($json);
	}



 ?>