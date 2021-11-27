<?php 
require_once ('db_connect.php');

$json=array();

    $busqueda=$_GET['busqueda'];
    $like = "";
		if(strlen($busqueda) > 0){
            $like = "(nombre_usuario LIKE '%{$busqueda}%' 
            OR celular LIKE '%{$busqueda}%' 
            OR usuario LIKE '%{$busqueda}%') AND";
		}
		
		$where = "WHERE $like rol = 1";

			

		$consulta="SELECT id_usuario, nombre_usuario, usuario, status,celular,
        CASE status 
        WHEN 'A' THEN 'Activo' 
        WHEN 'I' THEN 'Inactivo'
        END AS status_descripcion
		FROM cat_usuarios $where ORDER BY nombre_usuario";
		//throw new Exception($consulta);
		
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
			$results["id_usuario"]='';
			$results["nombre_usuario"]='';
			$results["status"]='';
            $results["usuario"]='';
            $results["status_descripcion"]='';
			$results["rol"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}


 ?>