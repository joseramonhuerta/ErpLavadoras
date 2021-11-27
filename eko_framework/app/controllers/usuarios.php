<?php
require ('eko_framework/app/models/usuario.php');       //MODELO

class Usuarios extends ApplicationController {
    function getModelObject(){
    	if (empty($this->model)) {
    		$this->model=new Model();
    	}
    	return $this->model;
    } 
    function obtenerusuarios(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $filtro = (empty($_POST['filtro'])) ?  '': $_POST['filtro']; 
			$filtroStatus = (empty($_POST['filtroStatus'])) ?  'A': $_POST['filtroStatus'];			
		      
            $usuarioModel=new UsuarioModel();
			
            $response = $usuarioModel->readAll($start,$limit,$filtro,$filtroStatus);
		//var_dump($response);
        return $response; //RETURN PARA COMPRIMIR LA RESPUESTA CON GZIP
    }
	
	function guardar(){
		$params = $_POST;
		
		 $usuarioModel=new UsuarioModel();
		
		$resp = $usuarioModel->guardar($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Usuarios','mensaje'=> 'La información del Usuario ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}

	function eliminar(){
		$usuarioModel=new usuarioModel();
		$titulo=$usuarioModel->name;
		
		if ( empty($_POST['id_usuario']) ){
			return array(
				'success'=>false,
				'msg'=>array('titulo'=>"Error en la solicitud de borrado",'mensaje'=>"Debe proporcionar la referencia al Usuario que desea eliminar"),
				'data'=>$data
			);	
		}
		
		$id=$_POST['id_usuario'];	
	
		$affected = $usuarioModel->delete($id);
		
		if (empty($affected)){
			$success=false;
			$mensaje="El Usuario no fue eliminado";
		}else{
			$success=true;
			$mensaje="Usuario eliminado de la base de datos";
		}	
		$data=array('id_usuario'=>$id);
		
		return array(
			'success'=>$success,
			'msg'=>array(
					'titulo'=>'Usuarios',
					'mensaje'=>$mensaje
				),
			'data'=>$data
		);
		
	}
	
	public function cambiarstatus(){
       
	   $idValue=$_POST['id_usuario'];
   
		
		$statusOld=$_POST['status'];			
		if ($statusOld=='A'){
			$nuevoStatus="I";
		}else if ($statusOld=='I'){
			$nuevoStatus="A";
		}else{
			return array(
				'success'=>false,
				'msg'=>array(
					'titulo'=>'Error en la peticion de cambio de status',
					'mensaje'=>"El estado (<span style='font-weight:bold;'>$statusOld</span>) es desconocido por el sistema."
				)				
			);
		}
		
		
        $query="UPDATE cat_usuarios SET status='$nuevoStatus' WHERE id_usuario=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_usuario'=>$id,
			'status'=>$nuevoStatus
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Usuarios',
					'mensaje'=>"Error al actualizar el estado del Usuario:".mysql_error()
				);
        }else{
            $response['success'] = true;
            $estado='';
            if ($nuevoStatus=="I"){
                $estado="Desactivado";
            }else{
                $estado="Activado";
            }
            $response['msg'] = array(
					'titulo'=>'Usuarios',
					'mensaje'=>"El Usuario ha sido $estado"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
	}

	function obtenertrabajadores(){
		try {
			$filtro_query= ( empty($_POST['query']) )? '' : $_POST['query']; 
			$filtro="";
			$filtro=$this->filtroToSQL($filtro_query,array('nombre'));
			$filtro.= ($filtro) ? " AND t.status = 'A'" : " WHERE t.status = 'A'";
			
			$query = "SELECT COUNT(t.id_trabajador) AS totalrows FROM cat_trabajadores t $filtro ";
			$res = mysqlQuery($query);
			if (!$res)
			throw new Exception(mysqli_error()." ".$query);
				
			$resultado  = mysqli_fetch_array($res, MYSQL_ASSOC);
			$total_rows = $resultado['totalrows'];
				
			$limit = (empty($_POST['limit'])) ? 50 : $_POST['limit'];
			$start = (empty($_POST['start'])) ?  0 : $_POST['start'];
				
			$query = " SELECT t.id_trabajador,t.nombre as nombre_trabajador,t.id_ruta,r.descripcion as ruta FROM cat_trabajadores t";
			$query.= " LEFT JOIN cat_rutas r on t.id_ruta = r.id_ruta ";
			$query.= " $filtro ORDER BY t.id_trabajador LIMIT $start, $limit ";
			$res = mysqlQuery($query);
			if (!$res)  throw new Exception(mysqli_error()." ".$query);
				
			$response = ResulsetToExt::resToArray($res);
			$response['totalRows'] = $total_rows;
		} catch (Exception $e) {
			$response['totalRows'] = $total_rows;
			$response['success']    = false;
			$response['msg']       = $e->getMessage();
		}
		echo json_encode($response);
		
	}

	function filtroToSQL($filtro,$camposAfiltrar=array()) {
     	 $where = '';
     	 
        if (!empty($filtro)) {
			$filtroArray = explode(" ", $filtro);
	        $condiciones = "";
	        $condicion = "";

	        foreach ($camposAfiltrar as $campo) {
	
	            foreach ($filtroArray as $text) {
	                if (strlen($text) > 0){
						$condicion.="$campo LIKE '%$text%' AND ";	 									
					}
	            }
	
	            if (strlen($condicion) > 0) {
	                $condicion = substr($condicion, 0, strlen($condicion) - 4); //<----LE BORRO LA ULTIMA PARTE "AND ";
	                $condicion = "(" . $condicion . ") OR ";
	                $condiciones.=$condicion;
	                $condicion = "";
	            }
	        }
	       
	        if (strlen($condiciones) > 0) {
	            $condiciones = substr($condiciones, 0, strlen($condiciones) - 3); //<----LE BORRO LA ULTIMA PARTE "or ";
	            $where = "WHERE ($condiciones)";
	        }
        }
        return $where;
    }	
}
?>
