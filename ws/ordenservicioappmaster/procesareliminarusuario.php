<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();


$json=array();
$msg="";

	if(isset($_GET)){
		$id_usuario=$_GET['id_usuario'];		
		$id_empresa=$_GET['id_empresa'];
		$basedatos=$_GET['basedatos'];
		$conexion->setDataBase($basedatos);
		
		
		
		//Cambiar el estatus del pedido a recogido
		//Cambiar el estatus de la asignacion de la lavadora a 1=Asignada al trabajador porque la recogio del cliente		
		
		try{

			
			$conexion->conectarMaster();
			
			$consulta="SELECT ue.id_usuario_empresa,ue.id_usuario_master  
				FROM cat_usuarios_empresas ue 
				INNER JOIN cat_usuarios u on u.id_usuario_master = ue.id_usuario_master
				INNER JOIN cat_empresas e on e.id_empresa = ue.id_empresa 	
				WHERE ue.id_usuario = {$id_usuario} AND ue.id_empresa = {$id_empresa}";				
			
			$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);	
			$reg=mysqli_fetch_array($resultado);
			$id_usuario_empresa=$reg['id_usuario_empresa'];
			$id_usuario_master=$reg['id_usuario_master'];
			
			$consulta="DELETE FROM cat_usuarios_empresas WHERE id_usuario_empresa={$id_usuario_empresa}";
			$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);

			$consulta="DELETE FROM cat_usuarios WHERE id_usuario_master={$id_usuario_master}";
			$resultado=mysqli_query($conexion->getConexionMaster(),$consulta);				
			
			$conexion->closeConexionMaster();
			
			
			$conexion->conectar();
			
			$consulta="DELETE FROM cat_usuarios WHERE id_usuario={$id_usuario}";
			$resultado=mysqli_query($conexion->getConexion(),$consulta);	
			
			$msg = 'Se elimino el usuario';
			$json['success'] = true;
			$json['msg'] = $msg;
			$json['datos'][]=[];	
			
			$conexion->closeConexion();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
		}catch(Exception $e){
			
			$msg = $e;
			
		
		
		}		
	}else{
			$msg = 'No se recibieron todos los parametros';
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];
			echo json_encode($json);
	}



 ?>