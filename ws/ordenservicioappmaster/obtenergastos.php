<?php 
require_once('db_connect_class.php');
$conexion = new Conexion();

$basedatos=$_GET['basedatos'];
$conexion->setDataBase($basedatos);
$conexion->conectar();


$json=array();
	
$filtro=$_GET['filtro'];
//$filtro_tecnico=(empty($_GET['filtro_tecnico'])) ? 0 : $_GET['filtro_tecnico'];
$filtroString="";	
$id_usuario=(empty($_GET['id_usuario'])) ? 0 : $_GET['id_usuario'];
$filtro=$_GET['filtro'];

$fechainicio = $_GET['fechainicio'];	
$datetime="$fechainicio";
$fechainicio=date('Y-m-d',strtotime($datetime));

$fechafin = $_GET['fechafin'];	
$datetime="$fechafin";
$fechafin=date('Y-m-d',strtotime($datetime));

if($filtro > 0){
	$filtroString=" WHERE tipo={$filtro} AND (DATE(g.fecha) BETWEEN '{$fechainicio}' AND '{$fechafin}') ";
	
}else{
	$filtroString .= " WHERE DATE(g.fecha) BETWEEN '{$fechainicio}' AND '{$fechafin}'";
	
}	


	

$consulta="SELECT g.id_gasto, CAST(DATE_FORMAT(g.fecha,'%d/%m/%Y') as CHAR) as fecha,g.concepto,
	g.importe,g.tipo,CASE g.tipo WHEN 1 THEN 'INGRESO' WHEN 2 THEN 'EGRESO' END AS tipo_descripcion,
	IFNULL(o.id_orden_servicio,0) AS id_orden_servicio,IFNULL(c.nombre_cliente,'') AS orden_servicio_descripcion  	
	FROM gastos g
	LEFT JOIN ordenes_servicio o ON o.id_orden_servicio = g.id_orden_servicio
	LEFT JOIN cat_clientes c ON c.id_cliente = o.id_cliente
	$filtroString ORDER BY g.fecha DESC";
	
	//Throw new Exception($consulta);


$resultado=mysqli_query($conexion->getConexion(),$consulta);

if($consulta){			
	while ($row = mysqli_fetch_array($resultado)) {
		$json[] = $row;
	}
	$conexion->closeConexion();
	header('Content-Type: application/json; charset=utf8');
	echo json_encode($json);
}

else{
	$results["id_gasto"]='';
	$json[]=$results;
	$conexion->closeConexion();
	echo json_encode($json);
}
	
	


 ?>