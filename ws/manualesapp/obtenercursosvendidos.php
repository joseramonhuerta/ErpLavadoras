<?php 
require_once('db_connect.php');

$json=array();
		$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];	
				
		
		$consulta="SELECT m.id_manual, m.nombre_manual,um.comision,c.nombre_categoria, um.comision AS precio, m.url_portada
					FROM cat_usuarios_manuales um
					LEFT JOIN cat_manuales m ON um.id_manual = m.id_manual
					LEFT JOIN cat_categorias c ON c.id_categoria = m.id_categoria  
					WHERE m.id_usuario_creador = {$id_usuario} AND um.autorizado = 1
					ORDER BY m.id_manual ASC";
					

		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){			
			while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                $json[] = $row;
            }
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_manual"]='';
			$results["nombre_manual"]='';
			$results["descripcion_manual"]='';
			$results["paginas"]='';
			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	



 ?>