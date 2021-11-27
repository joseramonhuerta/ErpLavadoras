<?php 
require_once('db_connect.php');

$json=array();
$msg="";
$sucess=false;
	if(isset($_GET)){
				
		$id_usuario=$_GET['id_usuario'];
		$origen=$_GET['origen'];
		$destino=$_GET['destino'];
		$comentarios=$_GET['comentarios'];
		$origenlat=$_GET['origenlat'];
		$origenlng=$_GET['origenlng'];
		$destinolat=$_GET['destinolat'];
		$destinolng=$_GET['destinolng'];
		$distancia=$_GET['distancia'];
		
		$sql="SELECT IFNULL(tarifa,0) AS tarifa
				FROM cat_tarifas WHERE {$distancia} BETWEEN inicial AND final";
			$resultado=mysqli_query($conexion,$sql);				
				
			$reg=mysqli_fetch_array($resultado);
			$importe_minimo=$reg['tarifa'];
					
			
			
			if($importe_minimo <= 0 ){
				throw new Exception('No se encontro una tarifa válida.');				
			}
		
		
		
		//origenlat=23.2314249&origenlng=-106.4073817&destinolat=23.2051184&destinolng=-106.4199755
		
		
		try{
			
			$sql="INSERT INTO pedidos(id_usuario, fecha, origen, destino, descripcion_origen, status, importe, origen_latitud, origen_longitud, destino_latitud, destino_longitud, distancia) values({$id_usuario},now(),'{$origen}','{$destino}','{$comentarios}',0,{$importe_minimo},{$origenlat},{$origenlng},{$destinolat},{$destinolng},{$distancia})";
			//throw new Exception($sql);			
			$resultado=mysqli_query($conexion,$sql);	
			
			$msg = "Solicitud registrada";			
			$sucess=true;
			$results["sucess"]=$sucess;
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
		}catch(Exception $e){
			$msg = $e->getMessage();
			$sucess=false;
			$results["sucess"]=$sucess;			
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
		}		
		
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
		
		
	}
	else{
			mysqli_close($conexion);
			
			$msg="No se recibieron parámetros";
			$sucess=false;
			$results["sucess"]=$sucess;
			$results["msg"]=$msg;
			$json['datos'][]=$results;
			
			echo json_encode($json);
						
	}



 ?>