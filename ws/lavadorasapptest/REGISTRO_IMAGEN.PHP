<?php 

$hostname="localhost";
$database="user_lavadoras_leon";
$username="user_cristian";
$password="kunashi1400";

$conexion=mysqli_connect($hostname,$username,$password,$database);

			$nombre=$_POST['nombre'];
			$correo=$_POST['correo'];
			$telefono=$_POST['telefono'];
			$usuario=$_POST['usuario'];
			$clave=$_POST['clave'];

			$foto = $_POST['foto'];
  				
  				$path = "img/uploads/$nombre.jpg";

  				$url = "https://lavadorasleon.com/$parh";

  				file_put_contents($path,base64_decode($imagen));
  				$bytesArchivo=file_get_contents($path);
  		//$sql="INSERT INTO usuario VALUES (?,?,?,?,?,?)";
  		//$stm=$conexion->prepare($sql);
  		//$stm->bind_param('isss',$nombre,$correo,$telefono,$usuario,$clave,$imgProducto):

  		//if($stm->execute()){
  			echo "registra";
  		/*}else{
  			echo "noregistra";
  		}*/






 ?>