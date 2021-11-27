<?php 

require_once('db_connect.php');
$json=array();
	

	
	$consulta="SELECT c.id_cliente,
	c.nombre as nombre_cliente,c.calle as direccion,c.colonia, CONCAT(IFNULL(c.telefono1,''),', ',IFNULL(c.telefono2,'')) AS telefonos,IFNULL(c.celular,'') as celular
	FROM cat_clientes c";
	$resultado=mysqli_query($conexion,$consulta);
	
	try{
		if($consulta){			
			while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
				$json[] = $row;
			}
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["id_cliente"]='';			
			$results["nombre_cliente"]='';
			$results["direccion"]='';
			$results["colonia"]='';
			$results["telefonos"]='';
			$results["celular"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}	
	}catch(Excepcion $e){
		mysqli_close($conexion);	
		 echo 'Caught exception: ',  $e->getMessage(), "\n";
		
	}


 ?>