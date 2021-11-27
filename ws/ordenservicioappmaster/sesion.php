<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();
$conexion->conectarMaster();
$conexionMaster = $conexion->getConexionMaster();
$json=array();
if(isset($_GET["usuario"]) && isset($_GET["clave"])){
	$usuario=$_GET['usuario'];
	$clave=$_GET['clave'];
	


	$consulta="SELECT ue.id_usuario, u.nombre_usuario as nombre, u.usuario, u.rol,e.id_empresa, e.basedatos, e.nombre_empresa  
				FROM cat_usuarios_empresas ue 
				INNER JOIN cat_usuarios u on u.id_usuario_master = ue.id_usuario_master
				INNER JOIN cat_empresas e on e.id_empresa = ue.id_empresa 	
				WHERE ue.usuario = '{$usuario}' AND ue.pass = to_base64('{$clave}') AND u.estatus = 'A' AND e.estatus = 'A'";
	//throw new Exception($consulta);
	$resultado=mysqli_query($conexionMaster,$consulta);

	if($consulta){

		if($reg=mysqli_fetch_array($resultado)){
			$json['datos'][]=$reg;
		}
		$conexion->closeConexionMaster();
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);
	}

	else{
		$results["id_usuario"]=0;
		$results["usuario"]='';
		$results["clave"]='';
		$results["nombre"]='';
		$results["rol"]=0;
		$json['datos'][]=$results;
		$conexion->closeConexionMaster();
		echo json_encode($json);
	}
}else{
		$results["id_usuario"]=0;
		$results["usuario"]='';
		$results["clave"]='';
		$results["nombre"]='';
		$results["rol"]=0;
		$json['datos'][]=$results;
		$conexion->closeConexionMaster();
		echo json_encode($json);
}



 ?>