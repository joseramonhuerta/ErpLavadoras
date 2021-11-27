<?php
require ('eko_framework/app/models/trabajador.php');       //MODELO

class Trabajadores extends ApplicationController {
    function getModelObject(){
    	if (empty($this->model)) {
    		$this->model=new Model();
    	}
    	return $this->model;
    } 
    function obtenertrabajadores(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $filtro = (empty($_POST['filtro'])) ?  '': $_POST['filtro']; 
			$filtroStatus = (empty($_POST['filtroStatus'])) ?  'A': $_POST['filtroStatus'];			
		      
            $trabajadorModel=new TrabajadorModel();
			
            $response = $trabajadorModel->readAll($start,$limit,$filtro,$filtroStatus);
		//var_dump($response);
        return $response; //RETURN PARA COMPRIMIR LA RESPUESTA CON GZIP
    }
	
	function obtenerrutas(){
		try {
			$filtro_query= ( empty($_POST['query']) )? '' : $_POST['query']; 
			$filtro=$this->filtroToSQL($filtro_query,array('descripcion'));
					
			$filtro.= ($filtro) ? " AND status = 'A'" : " WHERE status = 'A' ";
			
			$filtro.= ($filtro) ? " AND status = 'A'" : " WHERE status = 'A' ";
			
			$query = "SELECT COUNT(id_ruta) AS totalrows FROM cat_rutas $filtro ";
			$res = mysqlQuery($query);
			if (!$res)
			throw new Exception(mysqli_error()." ".$query);
				
			$resultado  = mysqli_fetch_array($res, MYSQL_ASSOC);
			$total_rows = $resultado['totalrows'];
				
			$limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
			$start = (empty($_POST['start'])) ?  0 : $_POST['start'];
				
			$query = " SELECT id_ruta,descripcion, status FROM cat_rutas $filtro ";
			$query.= " ORDER BY id_ruta LIMIT $start, $limit ";
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
	
	function guardar(){
		$params = $_POST;
		
		 $trabajadorModel=new TrabajadorModel();
		
		$resp = $trabajadorModel->guardar($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Trabajadores','mensaje'=> 'La información del Trabajador ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}

	function eliminar(){
		$trabajadorModel=new TrabajadorModel();
		$titulo=$trabajadorModel->name;
		
		if ( empty($_POST['id_trabajador']) ){
			return array(
				'success'=>false,
				'msg'=>array('titulo'=>"Error en la solicitud de borrado",'mensaje'=>"Debe proporcionar la referencia al Trabajador que desea eliminar"),
				'data'=>$data
			);	
		}
		
		$id=$_POST['id_trabajador'];	
	
		$affected = $trabajadorModel->delete($id);
		
		if (empty($affected)){
			$success=false;
			$mensaje="El Trabajador no fue eliminado";
		}else{
			$success=true;
			$mensaje="Trabajador eliminado de la base de datos";
		}	
		$data=array('id_trabajador'=>$id);
		
		return array(
			'success'=>$success,
			'msg'=>array(
					'titulo'=>'Trabajadores',
					'mensaje'=>$mensaje
				),
			'data'=>$data
		);
		
	}
	
	public function cambiarstatus(){
       
	   $idValue=$_POST['id_trabajador'];
   
		
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
		
		
        $query="UPDATE cat_trabajadores SET status='$nuevoStatus' WHERE id_trabajador=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_trabajador'=>$id,
			'status'=>$nuevoStatus
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Trabajadores',
					'mensaje'=>"Error al actualizar el estado del Trabajador:".mysql_error()
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
					'titulo'=>'Trabajadores',
					'mensaje'=>"El Trabajador ha sido $estado"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
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
