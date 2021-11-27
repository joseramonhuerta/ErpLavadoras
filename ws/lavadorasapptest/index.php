<?php 
    session_start();
  
include "conexion.php";
  if(!empty($_POST)){

  	$alert='';
  	if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['calle']) || empty($_POST['cp']))
  	{
  		$alert='<p class="msg_error">Todos los campos menos correo son obigatorios.</p>';
  	}else{

  		include "conexion.php";

  		$nombre = $_POST['nombre'];
      $calle  = $_POST['calle'];
      $cp  = $_POST['cp'];
  		$email  = $_POST['correo'];
  		$telefono  = $_POST['telefono'];
  		$user   = $_POST['usuario'];
  		$clave  = $_POST['clave'];

  		$foto = $_FILES['foto'];
  		$nombre_foto = $foto['name'];
  		$type        = $foto['type'];
  		$url_temp 	 = $foto['tmp_name'];

  		$imgproducto = 'img_producto.png';

  		if($nombre_foto != '')
  		{
  			$destino = 'img/uploads/';
  			$img_nombre ='img_'.md5(date('d-m-Y H:m:s'));
  			$imgproducto = $img_nombre.'.jpg';
  			$src         = $destino.$imgproducto;
  		}	


         
  		$query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$user' OR telefono = '$telefono' ");
  		$result = mysqli_fetch_array($query);

  		if($result > 0){
  			$alert='<p class="msg_error">El usuario o el telefono ya existe.</p>';
  		}else{

  			$query_insert = mysqli_query($conection, "INSERT INTO usuario(imagen,nombre,calle,cp,correo,telefono,usuario,clave,rol,status)
  		    VALUES('$imgproducto','$nombre','$calle','$cp','$email','$telefono','$user','$clave','4','1')");

  			if($query_insert){
  				if($nombre_foto != ''){
  					move_uploaded_file($url_temp,$src);
  				}

  				$alert='<p class="msg_save">Usuario creado correctamente.</p>';
  				$destino="kunashi@lavadorasleon.com";
  				$contenido = "nombre: " . $nombre ."\ncalle: " . $calle ."\ncodigo postal: " . $cp ."\ncorreo: " . $email ."\ntelefono: " . $telefono ."\nuser: " . $user;
  				mail($destino,"nuevo usuario",$contenido);
  			}else{
  				$alert='<p class="msg_error">Error al crear el usuario.</p>';
  			}
  		}
  	}
  }



 ?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registrese</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		

		<div class="form_register">
			
			   <h1>Registrese</h1>
			   <hr>
			   <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			   <form action="" method="post" enctype="multipart/form-data">
			   	   <div class="photo">
				    <label for="foto">Foto de la credencial</label>
        		    <div class="prevPhoto">
        		    <span class="delPhoto notBlock">X</span>
        		    <label for="foto"></label>
        		    </div>
        		    <div class="upimg">
        		    <input type="file" name="foto" id="foto">
        		    </div>
        		    <div id="form_alert"></div>
		           </div>
			   	   <label for="nombre">Nombre</label>
			   	   <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
             <label for="calle">Calle</label>
             <input type="text" name="calle" id="calle" placeholder="Calle, numero y colonia">
             <label for="cp">cp</label>
             <input type="number" maxlength="5" class="filterNumeric" name="cp" id="cp" placeholder="codigo postal">
             <label for="credencial">Credencial</label>
             <input type="number" name="credencial" id="credencial" placeholder="numero de credencial">
			   	   <label for="correo">Correo electronico</label>
			   	   <input type="email" name="correo" id="correo" placeholder="Correo electronico">
			   	   <label for="telefono">Telefono</label>
			   	   <input type="number" name="telefono" id="telefono" placeholder="numero de telefono">
			   	   <label for="Usuario">Usuario</label>
			   	   <input type="text" name="usuario" id="usuario" placeholder="Usuario">
			   	   <label for="clave">Clave</label>
			   	   <input type="password" name="clave" id="clave" placeholder="Clave de acceso">
			   	   
			   	   
			   	   	    
			   	   	    
			   	   </select>
			   	   <input type="submit" value="registrarse" class="btn_save">


			   </form>


		</div>



	</section>



	<?php include "includes/footer.php"; ?>
</body>
</html>