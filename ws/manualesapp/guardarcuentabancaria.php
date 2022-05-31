<?php 
require_once('db_connect.php');
$json=array();
$msg="";
if(isset($_POST)){
	$id_usuario = $_POST['id_usuario'];
	$beneficiario = $_POST['beneficiario'];
	$cuenta_bancaria = $_POST['cuenta_bancaria'];
	
	
	try{		
				
		
		$consulta="UPDATE cat_usuarios SET 
		beneficiario = '{$beneficiario}',
		cuenta_bancaria = '{$cuenta_bancaria}'		
		WHERE id_usuario={$id_usuario}";
		$resultado=mysqli_query($conexion,$consulta);
		
		$msg = 'Cuenta bancaria actualizada';
		
		$json['success'] = true;
		$json['msg'] = $msg;		
		
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
		
	}catch(Exception $e){
		mysqli_close($conexion);
		$msg = $e->getMessage;

		$json['success'] = false;
		$json['msg'] = $msg;		
		
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);	
	}		
}else{
		$msg = 'No se recibieron todos los parametros';
		$json['success'] = false;
		$json['msg'] = $msg;		
		echo json_encode($json);
}

?>