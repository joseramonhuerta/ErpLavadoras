<?php 
require_once('db_connect.php');

$json=array();
$msg="";

	
if(isset($_POST)){
	$id_manual = $_POST['id_manual'];
	$id_usuario = $_POST['id_usuario'];
	
	try{
		//Consultar si existe algun registro de carrito con estatus pendiente, ahi se agregaran los nuevos productos agregados, si no, se debe crear un registro en carrito_comprar para referenciar todos los detalles a ese id.
		$id_carrito_compras = 0;
		$consulta = "SELECT IFNULL(id_carrito_compras,0) AS id_carrito_compras FROM carrito_compras WHERE id_usuario = {$id_usuario} AND estatus_carrito = 1 LIMIT 1";
		$resultado = mysqli_query($conexion,$consulta);
		$registro = mysqli_fetch_array($resultado);
		$id_carrito_compras = $registro['id_carrito_compras'];
		
		if($id_carrito_compras > 0){
			$id = $id_carrito_compras;
		}else{
			$consulta="INSERT INTO carrito_compras(id_usuario,fecha_carrito) 
			values({$id_usuario}, now())";
			$resultado=mysqli_query($conexion,$consulta);
			$id = mysqli_insert_id($conexion);	
		}		
			
		$consulta="INSERT INTO carrito_compras_detalles(id_carrito_compras,id_manual) 
		values({$id},  {$id_manual})";
		//if($debug == 1)
			//Throw new Exception($consulta);
		$resultado=mysqli_query($conexion,$consulta);
			
		
		$consulta="SELECT id_carrito_compras
		FROM carrito_compras
		WHERE id_carrito_compras = {$id}";
		$resultado=mysqli_query($conexion,$consulta);
		
		if($consulta){			
			if($reg=mysqli_fetch_array($resultado)){
				$msg = 'Se agrego a carrito';
				$json['success'] = true;
				$json['msg'] = $msg;
				$json['datos'][]=$reg;
			}
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}else{
			$msg = 'Error al agregar al carrito.';
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}		
	}catch(Exception $e){			
		$msg = $e->getMessage();
		//$results["id_pago"]="0";
		$json['success'] = false;
		$json['msg'] = $msg;
		$json['datos'][]=[];
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
		
	
	
	}		

}
else{
		$msg = 'No se recibieron todos los parametros';
		//$results["id_pago"]="0";
		$json['success'] = false;
		$json['msg'] = $msg;
		$json['datos'][]=[];
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
}


 ?>