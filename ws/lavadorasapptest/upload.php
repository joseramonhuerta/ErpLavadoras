<?php 
require_once('db_connect.php');

$json=array();
$msg="";
	if(isset($_GET["id_cliente"])){
		$id_cliente=$_GET['id_cliente'];
		$nombre=$_GET['nombre'];
		$foto=$_GET['foto'];		
		
		
		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{
			
						
				$path = "uploads/$id_cliente.jpg";

				$url = "https://sistema.lavadorasleon.com/$path";
					
				$consulta="UPDATE cat_clientes SET con_ine = 1,nombre_ine='{$nombre}', url_ine='{$url}' WHERE id_cliente={$id_cliente}";
				
				if(mysqli_query($conexion,$consulta)){
					file_put_contents($path,base64_decode($foto));
					echo "subio imagen";	
				}
				
				mysqli_close($conexion);
			
					
		}catch(Exception $e){
			mysqli_close($conexion);
			$msg = $e;
			
		
		
		}		
	}
	else{
			$msg = 'No se recibieron todos los parametros';
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			echo json_encode($json);
	}



 ?>