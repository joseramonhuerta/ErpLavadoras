<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["usuario"]) && isset($_GET["clave"])){
		$usuario=$_GET['usuario'];
		$clave=$_GET['clave'];
		

		
		$consulta="SELECT id_usuario, nombre_usuario, email_usuario,paterno_usuario, materno_usuario, celular,tipo_usuario, id_usuario_firebase, imagen, conocimientos_tecnicos, from_base64(pass) AS password, beneficiario, cuenta_bancaria 
		FROM cat_usuarios WHERE email_usuario = '{$usuario}' AND pass = to_base64('{$clave}') AND status = 'A'";
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
			$results["email_usuario"]='';
			$results["nombre_usuario"]='';
			$results["paterno_usuario"]='';
			$results["materno_usuario"]='';
			$results["celular"]='';
			$results["tipo_usuario"]=0;
			$results["id_usuario_firebase"]=0;			
			$json['datos'][]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	}
	else{
			$results["id_usuario"]=0;
			$results["email_usuario"]='';
			$results["nombre_usuario"]='';
			$results["paterno_usuario"]='';
			$results["materno_usuario"]='';
			$results["celular"]='';	
			$results["tipo_usuario"]=0;		
			$results["id_usuario_firebase"]=0;
			$json['datos'][]=$results;
			echo json_encode($json);
	}



 ?>