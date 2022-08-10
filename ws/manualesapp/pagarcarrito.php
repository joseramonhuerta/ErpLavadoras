<?php 
require_once('db_connect.php');

//https://erp.servfix.com.mx/ws/manualesapp/pagarcarrito.php?id_carrito_compras=0&id_openpay=tru6xxfvre32mmj5cnx5&referencia_openpay=1010104008012930&formapago=3
$json=array();
$datos = array();
$msg="";
	if(isset($_GET)){
		$id_carrito_compras=$_GET['id_carrito_compras'];
		$id_openpay=$_GET['id_openpay'];		
		$referencia_openpay=$_GET['referencia_openpay'];
		$formapago=$_GET['formapago'];
		$id_manual=intVal($_GET['id_manual']);
		$id_usuario=intVal($_GET['id_usuario']);
		
		
		try{
			//seleccionar la configuracion de la aplicacion para obtener la comision por cada curso
			$consulta_config = "SELECT IFNULL(comision,0) AS comision FROM cat_configuraciones_app LIMIT 1";
			$resultado_config = mysqli_query($conexion,$consulta_config);
			$registro_config = mysqli_fetch_array($resultado_config, MYSQLI_ASSOC);
			$comision = $registro_config['comision'];
			
			
			if($formapago == 3)
				$autorizado = 0;
			else
				$autorizado = 1;
			
			
			if($formapago == 99){
				$consulta="INSERT INTO cat_usuarios_manuales(id_manual, id_usuario, id_carrito_compras, autorizado, fecha) 
					VALUES({$id_manual}, {$id_usuario}, NULL, {$autorizado}, NOW())";
					
				$resultado=mysqli_query($conexion,$consulta);				
				$id_usuario_manual = mysqli_insert_id($conexion);
				
				$msg = 'Manual agregado';
				
				//Devolver respuesta del curso vendido para notificar al usuario que vendio un curso
				
				$sql_edocta="SELECT um.id_manual,m.id_usuario_creador, um.comision,m.nombre_manual,m.url_portada,u.token 
							FROM cat_usuarios_manuales um
							INNER JOIN cat_manuales m ON m.id_manual = um.id_manual
							INNER JOIN cat_usuarios u ON m.id_usuario_creador = u.id_usuario
							WHERE um.id_usuario_manual = {$id_usuario_manual}";
				
				$res_edocta=mysqli_query($conexion,$sql_edocta);
				$datos = array();
				if($res_edocta){										
					while ($row = mysqli_fetch_array($res_edocta, MYSQLI_ASSOC)) {
						$datos[] = $row;							
					}				
				}				
			}else{			
				$consulta="INSERT INTO cat_usuarios_manuales(id_manual, id_usuario, id_carrito_compras, autorizado, fecha, importe, comision) 
					SELECT ccd.id_manual, cc.id_usuario, ccd.id_carrito_compras,{$autorizado},NOW(),ccd.importe, ccd.importe * ({$comision}/100)  FROM carrito_compras_detalles ccd
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
				
				
				//insertar registro en la tabla de estado de cuenta, cuando se paga el carrito se genera un ingreso y sele suma el saldo anterior
				//Devolver respuesta del curso vendido para notificar a los usuarios que se vendio un curso
				$sql_edocta="SELECT um.id_manual,m.id_usuario_creador, um.comision,m.nombre_manual,m.url_portada,u.token 
							FROM cat_usuarios_manuales um
							INNER JOIN cat_manuales m ON m.id_manual = um.id_manual
							INNER JOIN cat_usuarios u ON m.id_usuario_creador = u.id_usuario
							WHERE um.id_carrito_compras = {$id_carrito_compras}";
				
				$res_edocta=mysqli_query($conexion,$sql_edocta);
				
				if($res_edocta){
										
					while ($row = mysqli_fetch_array($res_edocta, MYSQLI_ASSOC)) {
						$id_usuario_edocta = 0;
						$id_manual = 0;
						$comision = 0;
						$saldo = 0;
						$nuevo_saldo = 0;
						$concepto = 'Venta - ';						
						
						$id_usuario_edocta = $row['id_usuario_creador'];
						$id_manual = $row['id_manual'];
						$comision = $row['comision'];
						$concepto = $concepto.$row['nombre_manual'];
						
						
						
						//Consultar el ultimo saldo del usuario
						$sql_saldo_edocta = "SELECT IFNULL(saldo,0) AS saldo FROM cat_usuarios_estadocuenta WHERE id_usuario = {$id_usuario_edocta} ORDER BY fecha DESC, id_usuario_estadocuenta DESC LIMIT 1";
						$res_saldo_edocta=mysqli_query($conexion,$sql_saldo_edocta);
						$reg_saldo_edocta = mysqli_fetch_array($res_saldo_edocta, MYSQLI_ASSOC);
						$saldo = $reg_saldo_edocta['saldo'];
						
						$nuevo_saldo = $saldo + $comision;
						
						//insertar el nuevo estado de cuenta
						$sql_insert_edocta = "INSERT INTO cat_usuarios_estadocuenta(id_usuario, fecha, concepto, tipo,cargo, abono,saldo)
												VALUES({$id_usuario_edocta}, NOW(), '{$concepto}', 1, {$comision}, 0, {$nuevo_saldo})";

						$resultado=mysqli_query($conexion,$sql_insert_edocta);

						$datos[] = $row;						
						
					}				
				}				
			}		
			
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'] = $datos;	
			
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