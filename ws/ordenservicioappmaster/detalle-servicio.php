<?php
require_once('common.php');

if(!isset($_POST)) {
  echo "No.";
  exit;
}
$servicio = $_POST["servicio"];
$basedatos = $_POST['basedatos'];

$json=array();
if ($servicio && $basedatos) {
  $conexion->setDataBase($basedatos);
  $conexion->conectar();
  $con = $conexion->getConexion();

  $detalles_args = array("id" => $servicio);
  $template_query_detalles = file_get_contents($ROOT.'/queries/ordenes/detalle.sql');
  $query = $mustache->render($template_query_detalles, $detalles_args);
  $data = mysqli_query($con,$query);
  $row = $data->fetch_assoc();

  if ($data) {
    $json['success'] = true;
    $json['datos'] = $row;
  } else {
    $json['success'] = false;
    $json['msg'] = 'No se encontraron.';
  }
  $json['query'] = $query;
} else {
  $json['success'] = false;
  $json['msg'] = 'Algunos parametros no fueron proporcionados.';
}

header('Content-Type: application/json; charset=utf8');
echo json_encode($json);
