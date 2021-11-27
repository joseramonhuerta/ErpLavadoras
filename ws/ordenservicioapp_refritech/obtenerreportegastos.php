<?php 
require_once('db_connect.php');

$json=array();
	
		$filtro=$_GET['filtro'];
		//$filtro_tecnico=(empty($_GET['filtro_tecnico'])) ? 0 : $_GET['filtro_tecnico'];
		$filtroString="";	
		//$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];
		
		
		$fechainicio = $_GET['fechainicio'];	
		$datetime="$fechainicio";
		$fechainicio=date('Y-m-d',strtotime($datetime));
		
		$fechafin = $_GET['fechafin'];	
		$datetime="$fechafin";
		$fechafin=date('Y-m-d',strtotime($datetime));

		if($filtro > 0){
			$filtroString=" WHERE tipo={$filtro} AND (DATE(fecha) BETWEEN '{$fechainicio}' AND '{$fechafin}') ";
			
		}else{
			$filtroString .= " WHERE DATE(fecha) BETWEEN '{$fechainicio}' AND '{$fechafin}'";
			
		}	

		
			
		
		$consulta="SELECT CASE tipo WHEN 1 THEN 'INGRESOS' WHEN 2 THEN 'EGRESOS' END AS tipo,SUM(importe) AS total FROM gastos 
			$filtroString GROUP BY tipo";
			
			//Throw new Exception($consulta);
		
		
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
			$results["id_gasto"]='';
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	


 ?>