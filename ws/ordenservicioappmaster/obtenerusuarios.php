<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();
$basedatos=$_GET['basedatos'];
$conexion->setDataBase($basedatos);
$conexion->conectar();
$json=array();
		
	
				//1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super

		$consulta="SELECT id_usuario, nombre_usuario, usuario, rol, CASE rol WHEN 1 THEN 'Administrador' WHEN 2 THEN 'Supervisor' 
		WHEN 3 THEN 'Vendedor' WHEN 4 THEN 'Tecnico' END AS rol_descripcion
			FROM cat_usuarios WHERE rol != 5";
		$resultado=mysqli_query($conexion->getConexion(),$consulta);

		if($consulta){			
			while ($row = mysqli_fetch_array($resultado)) {
                $json[] = $row;
            }
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_usuario"]='';
			$results["nombre_usuario"]='';
			$results["usuario"]='';
			$results["rol"]='';
			$json[]=$results;
			$conexion->closeConexion();
			echo json_encode($json);
		}


 ?>