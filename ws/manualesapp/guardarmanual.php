<?php 
require_once('db_connect.php');
$json=array();
$msg="";
if(isset($_POST)){
	$id_manual = intval($_POST['id_manual']);
	$id_usuario = intval($_POST['id_usuario']);
	$nombre_manual = $_POST['nombre_manual'];
	$descripcion_manual = $_POST['descripcion_manual'];
	$tipo = intval($_POST['tipo']);
	$paginas = $_POST['paginas'];
	$precio = $_POST['precio'];
	$id_categoria = intval($_POST['id_categoria']);
	$portada = $_POST['portada'];
	$imagen_detalle = $_POST['imagen_detalle'];
	$esgratuito = intval($_POST['esgratuito']);
	$estatus_manual = intval($_POST['status_manual']);
	
	if($tipo == 1){
		$encoded_manual = $_POST['encoded_manual'];
		$nombre_pdf = $_POST['nombre_pdf'];
	}
	if($tipo == 2){
		$url = $_POST['url'];
	}
	
	$name_portada = "portada_".rand().".jpg";		
	$name_detalle = "detalle_".rand().".jpg";
	
	try{		
		if($id_manual > 0){
			$query="UPDATE cat_manuales SET ";
			$query.="id_usuario_modif=$id_usuario";    //LOG
            $query.=",fecha_modif=now()";			
            $where=" WHERE id_manual = ".$id_manual;
        }else{  //INSERT
            $query="INSERT INTO cat_manuales SET ";
			$query.="id_usuario_creador=$id_usuario";    //LOG
            $query.=",fecha_creador=now()";          
            $registroNuevo=true;
			$where='';
        }		
		
		$query.=",nombre_manual='".$nombre_manual."'";
		$query.=",descripcion_manual='".$descripcion_manual."'";
		$query.=",paginas='".$paginas."'";
		
		if($estatus_manual == 1)
			$query.=",status='A'";
		else
			$query.=",status='I'";
		
		$query.=",url_portada='".$name_portada."'";
		$query.=",url_detalle='".$name_detalle."'";
		
		if (is_numeric($id_categoria)){	
			$query.=",id_categoria=".$id_categoria;
		}
		
		if (is_numeric($esgratuito) && $esgratuito == 1){
			$query.=",esgratuito=1";			
			$query.=",precio='0.00'";
		}else{
			$query.=",esgratuito=0";	
			$query.=",precio='".$precio."'";
		}
		
		if (is_numeric($tipo)){	
			$query.=",tipo=".$tipo;
		}
		
		if($tipo == 1){
			$query.=",nombrepdf='".$nombre_pdf."'";			
		}
		if($tipo == 2){
			$query.=",url='".$url."'";	
		}
		if($tipo == 3){
			$query.=",id_usuario_tecnico=".$id_usuario;	
		}

        $consulta=$query.$where;	

		//Eliminamos las fotos anteriores para guardar las nuevas
		
	
		
		
		if($registroNuevo){
			$resultado = mysqli_query($conexion,$consulta);	
			$id = mysqli_insert_id($conexion);			
			$dirname = "manuales/".$id;
			mkdir($dirname, 0777);
			
			$files = glob($dirname."/*.jpg"); //obtenemos todos los nombres de los ficheros
			foreach($files as $file){
				if(is_file($file))
				unlink($file); //elimino el fichero
			}
			
			$file_portada = $dirname."/".$name_portada;		
			file_put_contents($file_portada, base64_decode($portada));

			$file_detalle = $dirname."/".$name_detalle;		
			file_put_contents($file_detalle, base64_decode($imagen_detalle));			
			
			
			if($tipo == 1){
				//throw new Exception($consulta);
				$pdf = $_POST['encoded_manual'];						
				$dir_pdf = $dirname."/".$nombre_pdf;		
				file_put_contents($dir_pdf, base64_decode($pdf));
			}			
		}else{			
			$resultado = mysqli_query($conexion,$consulta);	
			$id = $id_manual;
			$dirname = "manuales/".$id;
			
			$files = glob($dirname."/*.jpg"); //obtenemos todos los nombres de los ficheros
			foreach($files as $file){
				if(is_file($file))
				unlink($file); //elimino el fichero
			}
			
			if(isset($_POST['portada'])){
				$file_portada = $dirname."/".$name_portada;		
				file_put_contents($file_portada, base64_decode($portada));
			}
			
			if(isset($_POST['imagen_detalle'])){
				$file_detalle = $dirname."/".$name_detalle;		
				file_put_contents($file_detalle, base64_decode($imagen_detalle));
			}
			
			if($tipo == 1){							
				$pdf = $_POST['encoded_manual'];						
				$dir_pdf = $dirname."/".$nombre_pdf;				
				if (!file_exists($dir_pdf)){							
					file_put_contents($dir_pdf, base64_decode($pdf));
				}			
			}	
		}

		//agregar las imagenes en la base de datos
		/*
		$consulta = "DELETE FROM cat_manuales_imagenes WHERE id_manual = {$id}";
		$resultado=mysqli_query($conexion,$consulta);	
		
		//Agregar foto miniatura
		if(isset($_POST['portada'])){
			$query="INSERT INTO cat_manuales_imagenes SET ";
			$query.="id_manual={$id}";
			$query.=",imagen='{$portada}'";
			$query.=",tipo=1";
			$resultado=mysqli_query($conexion,$query); 			
		}

		//Agregar foto Detalle	
		if(isset($_POST['imagen_detalle'])){
			$query="INSERT INTO cat_manuales_imagenes SET ";
			$query.="id_manual={$id}";
			$query.=",imagen='{$imagen_detalle}'";
			$query.=",tipo=2";
			$resultado=mysqli_query($conexion,$query); 	
		}			
		*/		
		
		$consulta="SELECT id_manual, nombre_manual, url_portada, url_detalle FROM cat_manuales WHERE id_manual = {$id}";
			
		$resultado=mysqli_query($conexion,$consulta);	

		if($consulta){				
			if($reg=mysqli_fetch_array($resultado)){
				$msg = 'Guardada correctamente.';
				$json['success'] = true;
				$json['msg'] = $msg;
				$json['datos'][]=$reg;
			}			
		}else{
			$msg = 'Error al guardar el manual.';
			$json['success'] = false;
			$json['msg'] = $msg;
			$json['datos'][]=[];			
		}			
		
		mysqli_close($conexion);
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($json);		
	}catch(Exception $e){
		mysqli_close($conexion);
		$msg = $e->getMessage();

		$json['success'] = false;
		$json['msg'] = $msg;				
		
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