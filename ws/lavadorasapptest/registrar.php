<?php 
$hostname="localhost";
$database="user_lavadoras_leon";
$username="user_cristian";
$password="kunashi1400";
$json=array();
	if(isset($_GET["nombre"])&&($_GET["correo"])&&($_GET["telefono"])&&($_GET["usuario"]) && isset($_GET["clave"])){
		$nombre=$_GET['nombre'];
		$correo=$_GET['correo'];
		$telefono=$_GET['telefono'];
		$usuario=$_GET['usuario'];
		$clave=$_GET['clave'];
		

		$conexion=mysqli_connect($hostname,$username,$password,$database);

		$consulta="INSERT INTO usuario(nombre,correo,telefono,usuario,clave,rol,status)
  VALUES('{$nombre}','{$correo}','{$telefono}','{$usuario}','{$clave}','4','1')";
  		if($consulta){
  			$destino="kunashi@lavadorasleon.com";
  				$contenido = "nombre: " . $nombre ."\ncorreo: " . $correo ."\ntelefono: " . $telefono ."\nuser: " . $usuario;
  				mail($destino,"nuevo usuario",$contenido);
  			}
  			

		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){

			if($reg=mysqli_fetch_array($resultado)){
				$json['datos'][]=$reg;
			}
			mysqli_close($conexion);
			echo json_encode($json);
		}else{
			$results["nombre"]='';
			$results["correo"]='';
			$results["telefono"]='';
			$results["usuario"]='';
			$results["clave"]='';
			$json['datos'][]=$results;
			echo json_encode($json);
		}
	}else{   
			$results["nombre"]='';
			$results["correo"]='';
			$results["telefono"]='';
			$results["usuario"]='';
			$results["clave"]='';
			$json['datos'][]=$results;
			echo json_encode($json);
	}



 ?>  

 