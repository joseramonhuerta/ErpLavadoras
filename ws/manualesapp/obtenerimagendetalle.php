<?php 
require_once('db_connect.php');

$json=array();
	
		$id_manual=$_POST['id_manual'];
				
		$consulta="SELECT mid.imagen AS imagen_detalle
					FROM cat_manuales m					
					INNER JOIN cat_manuales_imagenes mid ON mid.id_manual = m.id_manual AND mid.tipo = 2	
					WHERE m.id_manual = {$id_manual}";
					

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
			$results["imagen_detalle"]='';			
			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	



 ?>