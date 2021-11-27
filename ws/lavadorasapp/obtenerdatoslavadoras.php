<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_trabajador"])){
		$id_trabajador=$_GET['id_trabajador'];
				

		$consulta="SELECT a.id_asignacion,a.id_producto,p.descripcion,p.codigo_barra AS codigo
			FROM asignadas a 
			INNER JOIN cat_productos p ON p.id_producto = a.id_producto
			WHERE status_asignacion = 1 AND id_trabajador = {$id_trabajador}";
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
			$results["id_asignacion"]='';
			$results["id_producto"]='';
			$results["descripcion"]='';
			$results["codigo"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	}else{
			$results["id_asignacion"]='';
			$results["id_producto"]='';
			$results["descripcion"]='';
			$results["codigo"]='';
			$json[]=$results;
			echo json_encode($json);
	}


 ?>