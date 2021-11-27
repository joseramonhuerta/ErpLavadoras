<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET) && isset($_GET["id_cliente"])){
		$id_cliente=$_GET['id_cliente'];
			
		$consulta="SELECT id_cliente, nombre, calle, colonia, cp, curp, num_credencial, correo, telefono1, telefono2, celular, usuario, from_base64(pass) AS pass FROM cat_clientes WHERE id_cliente = {$id_cliente}";
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
			$results["id_cliente"]=0;
			$results["nombre"]='';
			$results["calle"]='';
			$results["colonia"]='';
			$results["cp"]='';
			$results["curp"]='';
			$results["num_credencial"]='';
			$results["correo"]='';
			$results["telefono1"]='';
			$results["telefono2"]='';
			$results["celular"]='';
			$results["pass"]='';
			$json['datos'][]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	}
	else{
			$results["id_cliente"]=0;
			$results["nombre"]='';
			$results["calle"]='';
			$results["colonia"]='';
			$results["cp"]='';
			$results["curp"]='';
			$results["num_credencial"]='';
			$results["correo"]='';
			$results["telefono1"]='';
			$results["telefono2"]='';
			$results["celular"]='';
			$results["pass"]='';		
			$json['datos'][]=$results;
			echo json_encode($json);
	}



 ?>