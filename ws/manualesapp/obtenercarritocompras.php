<?php 
require_once('db_connect.php');

$json=array();

if(isset($_POST)){
	
	$id_usuario=$_GET['id_usuario'];
	
	$consulta = "SELECT IFNULL(id_carrito_compras,0) AS id_carrito_compras FROM carrito_compras WHERE id_usuario = {$id_usuario} AND estatus_carrito = 1 LIMIT 1";
	$resultado = mysqli_query($conexion,$consulta);
	$registro = mysqli_fetch_array($resultado);
	$id_carrito_compras = $registro['id_carrito_compras'];
	
	$array_carrito = array();
	$array_detalles = array();
	
	if($id_carrito_compras > 0){
		$consulta="SELECT c.id_carrito_compras_detalle,c.id_carrito_compras, m.id_manual, m.nombre_manual, m.precio,
				m.url_portada
				FROM carrito_compras_detalles c
				INNER JOIN carrito_compras c2 ON c2.id_carrito_compras = c.id_carrito_compras
				INNER JOIN cat_manuales m ON m.id_manual = c.id_manual
				WHERE c.id_carrito_compras = {$id_carrito_compras}";				

		$resultado=mysqli_query($conexion,$consulta);
		
		if($consulta){
			while($row = mysqli_fetch_array($resultado)){
				$array_detalles[] = $row;
			}

			$array_carrito['id_carrito_compras']= $id_carrito_compras;
			$array_carrito['detalles']= $array_detalles;
			
		}else{
			$array_carrito['id_carrito_compras']= 0;
			$array_carrito['detalles'][]=[];			
		}
		
		$msg = 'Se obtuvo el carrito';
		$json['success'] = true;
		$json['msg'] = $msg;
		$json['datos'][]= $array_carrito;
		
		
	}else{
		$msg = 'El carrito esta vacio';
		$json['success'] = false;
		$json['msg'] = $msg;
		$json['datos'][]=[];
		
	}
	
	mysqli_close($conexion);
	header('Content-Type: application/json; charset=utf8');
	echo json_encode($json);	
			
}else{
	$msg = 'No se recibieron todos los parametros';
	//$results["id_pago"]="0";
	$json['success'] = false;
	$json['msg'] = $msg;
	$json['datos'][]=[];
	header('Content-Type: application/json; charset=utf8');
	echo json_encode($json);
}	
	



 ?>