<?php 
require_once('db_connect.php');
//https://erp.servfix.com.mx/ws/manualesapp/pagarcarrito.php?id_carrito_compras=0&id_openpay=tru6xxfvre32mmj5cnx5&referencia_openpay=1010104008012930&formapago=3
$json=array();
$msg="";
	if(isset($_GET)){
		$id_carrito_compras=$_GET['id_carrito_compras'];
		$id_openpay=$_GET['id_openpay'];		
		$referencia_openpay=$_GET['referencia_openpay'];
		$formapago=$_GET['formapago'];
		$id_manual=intVal($_GET['id_manual']);
		$id_usuario=intVal($_GET['id_usuario']);
		
		
		try{
			if($formapago == 3)
				$autorizado = 0;
			else
				$autorizado = 1;
			
			
			if($formapago == 99){
				$consulta="INSERT INTO cat_usuarios_manuales(id_manual, id_usuario,id_carrito_compras,autorizado) 
					VALUES({$id_manual}, {$id_usuario}, NULL, {$autorizado})";
					
				$resultado=mysqli_query($conexion,$consulta);
				
				$msg = 'Manual agregado';
				
			}else{			
				$consulta="INSERT INTO cat_usuarios_manuales(id_manual, id_usuario,id_carrito_compras,autorizado) 
					SELECT ccd.id_manual, cc.id_usuario, ccd.id_carrito_compras,{$autorizado} FROM carrito_compras_detalles ccd
					INNER JOIN carrito_compras cc ON cc.id_carrito_compras = ccd.id_carrito_compras
					WHERE ccd.id_carrito_compras = {$id_carrito_compras}";
					
				$resultado=mysqli_query($conexion,$consulta);
				//1=Pendiente,2=Espera de Pago,3=Pagado,4=Cancelado
				if($formapago == 3){
					$consulta="UPDATE carrito_compras SET estatus_carrito = 2,referencia='{$referencia_openpay}', id_openpay='{$id_openpay}',formapago = {$formapago} WHERE id_carrito_compras={$id_carrito_compras}";
					$msg = 'En espera de confirmacion del pago';
				}else{
					$consulta="UPDATE carrito_compras SET estatus_carrito = 3,formapago = {$formapago} WHERE id_carrito_compras={$id_carrito_compras}";
					$msg = 'Se pago el carrito correctamente';
				}
				
				$resultado=mysqli_query($conexion,$consulta);
			}
			
			
			
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=[];	
			
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
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