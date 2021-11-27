<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_gasto"])){
		$id_gasto=$_GET['id_gasto'];
		
		
		$consulta="SELECT id_gasto, CAST(DATE_FORMAT(fecha,'%d/%m/%Y') as CHAR) as fecha,
			concepto, tipo,CASE tipo WHEN 1 THEN 'INGRESO' WHEN 2 THEN 'EGRESO' END AS tipo_descripcion,
			importe 
			FROM gastos
			WHERE id_gasto = {$id_gasto}";
		
		
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
			$results["id_gasto"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	}else{
			$results["id_gasto"]='';			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	


 ?>