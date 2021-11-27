<?php
require ('eko_framework/app/models/pedido.php');       //MODELO
require_once "eko_framework/app/models/reporte_pedido_ticket.php";
require_once "eko_framework/app/models/reporte_rentas.php";
//require_once "eko_framework/app/models/reporte_rentas_excel.php";
class Pedidos extends ApplicationController {
    function getModelObject(){
    	if (empty($this->model)) {
    		$this->model=new Model();
    	}
    	return $this->model;
    }

	function obtenerpedidos(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $filtro = (empty($_POST['filtro'])) ?  '': $_POST['filtro']; 
			$filtroStatus = (empty($_POST['filtroStatus'])) ?  'A': $_POST['filtroStatus'];			
		      
            $pedidoModel=new PedidoModel();
			
            $response = $pedidoModel->readAllPedidos($start,$limit,$filtro,$filtroStatus);
		//var_dump($response);
        return $response; //RETURN PARA COMPRIMIR LA RESPUESTA CON GZIP
    }
	
	function obtenerrentas(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $fechainicio = (empty($_POST['fechainicio'])) ?  '': $_POST['fechainicio'];
			$fechafin = (empty($_POST['fechafin'])) ?  '': $_POST['fechafin']; 
			$id_cliente = (empty($_POST['id_cliente'])) ?  '0': $_POST['id_cliente'];
			$id_trabajador = (empty($_POST['id_trabajador'])) ?  '0': $_POST['id_trabajador'];	
			$filtroStatus = (empty($_POST['filtroStatus'])) ?  '0': $_POST['filtroStatus'];			
			$filtroFechas = (empty($_POST['filtroFechas'])) ?  0 : $_POST['filtroFechas'];
			$filtroCobradas = (empty($_POST['filtroCobradas'])) ?  0 : $_POST['filtroCobradas'];
			$filtroRecogidas = (empty($_POST['filtroRecogidas'])) ?  0 : $_POST['filtroRecogidas'];	
			$filtro = (empty($_POST['filtro'])) ?  '': $_POST['filtro']; 
            
			$pedidoModel=new PedidoModel();
			
            $response = $pedidoModel->readAllRentas($start,$limit,$fechainicio,$fechafin,$id_cliente,$id_trabajador,$filtroStatus,$filtroFechas,$filtroCobradas, $filtroRecogidas,$filtro);
		//var_dump($response);
        return $response; //RETURN PARA COMPRIMIR LA RESPUESTA CON GZIP
    }

	function obtenerasignadas(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $filtro = (empty($_POST['filtro'])) ?  '': $_POST['filtro']; 
						
		      
            $pedidoModel=new PedidoModel();
			
            $response = $pedidoModel->readAsignadas($start,$limit,$filtro);
		//var_dump($response);
        return $response; //RETURN PARA COMPRIMIR LA RESPUESTA CON GZIP
    }		
 
	function obtenerclientes(){
		try {
			$filtro_query= ( empty($_POST['query']) )? '' : $_POST['query']; 
			$filtro="";
			$filtro=$this->filtroToSQL($filtro_query,array('c.nombre','c.calle','c.celular'));
			$filtro.= ($filtro) ? " AND c.status = 'A'" : " WHERE c.status = 'A'";
			
			$query = "SELECT COUNT(c.id_cliente) AS totalrows FROM cat_clientes c $filtro ";
			$res = mysqlQuery($query);
			if (!$res)
			throw new Exception(mysqli_error()." ".$query);
				
			$resultado  = mysqli_fetch_array($res, MYSQL_ASSOC);
			$total_rows = $resultado['totalrows'];
				
			$limit = (empty($_POST['limit'])) ? 50 : $_POST['limit'];
			$start = (empty($_POST['start'])) ?  0 : $_POST['start'];
				
			$query = " SELECT c.id_cliente,c.nombre,c.calle,c.colonia,c.celular,c.id_ruta, t.nombre AS chofer,t.id_trabajador FROM cat_clientes c ";
			$query.= " LEFT JOIN cat_trabajadores t on t.id_ruta = c.id_ruta ";
			$query.= " $filtro ORDER BY c.id_cliente LIMIT $start, $limit ";
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
	
	function obtenerrutas(){
		try {
			$filtro_query= ( empty($_POST['query']) )? '' : $_POST['query']; 
			$filtro=$this->filtroToSQL($filtro_query,array('r.descripcion'));
					
			$filtro.= ($filtro) ? " AND r.status = 'A'" : " WHERE r.status = 'A' ";
			
			$filtro.= ($filtro) ? " AND r.status = 'A'" : " WHERE r.status = 'A' ";
			
			$query = "SELECT COUNT(r.id_ruta) AS totalrows FROM cat_rutas r $filtro ";
			$res = mysqlQuery($query);
			if (!$res)
			throw new Exception(mysqli_error()." ".$query);
				
			$resultado  = mysqli_fetch_array($res, MYSQL_ASSOC);
			$total_rows = $resultado['totalrows'];
				
			$limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
			$start = (empty($_POST['start'])) ?  0 : $_POST['start'];
				
			$query = " SELECT r.id_ruta,r.descripcion, r.status, t.nombre AS chofer,t.id_trabajador FROM cat_rutas r";
			$query.= " LEFT JOIN cat_trabajadores t on t.id_ruta = r.id_ruta ";
			$query.= " $filtro ORDER BY r.id_ruta LIMIT $start, $limit ";
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
	
	function obtenertrabajadoresporruta(){
		try {
			$filtro_query= ( empty($_POST['query']) )? '' : $_POST['query']; 
			$id_ruta = (empty($_POST['id_ruta'])) ? 0 : $_POST['id_ruta'];
			$filtro="";
			$filtro=$this->filtroToSQL($filtro_query,array('nombre'));
			$filtro.= ($filtro) ? " AND t.status = 'A' AND t.id_ruta = $id_ruta" : " WHERE t.status = 'A' AND t.id_ruta = $id_ruta";
			
			$query = "SELECT COUNT(t.id_trabajador) AS totalrows FROM cat_trabajadores t $filtro ";
			$res = mysqlQuery($query);
			if (!$res)
			throw new Exception(mysqli_error()." ".$query);
				
			$resultado  = mysqli_fetch_array($res, MYSQL_ASSOC);
			$total_rows = $resultado['totalrows'];
				
			$limit = (empty($_POST['limit'])) ? 50 : $_POST['limit'];
			$start = (empty($_POST['start'])) ?  0 : $_POST['start'];
				
			$query = " SELECT t.id_trabajador,t.nombre as nombre_trabajador,t.id_ruta,r.descripcion as ruta FROM cat_trabajadores t";
			$query.= " INNER JOIN cat_rutas r on t.id_ruta = r.id_ruta ";
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
	
	function obtenerproductos(){
		try {
			$filtro_query= ( empty($_POST['query']) )? '' : $_POST['query']; 
			$filtro="";
			$filtro=$this->filtroToSQL($filtro_query,array('descripcion','codigo_barra'));
			$filtro.= ($filtro) ? " AND status = 'A'" : " WHERE status = 'A'";
			
			$query = "SELECT COUNT(id_producto) AS totalrows FROM cat_productos $filtro ";
			$res = mysqlQuery($query);
			if (!$res)
			throw new Exception(mysqli_error()." ".$query);
				
			$resultado  = mysqli_fetch_array($res, MYSQL_ASSOC);
			$total_rows = $resultado['totalrows'];
				
			$limit = (empty($_POST['limit'])) ? 50 : $_POST['limit'];
			$start = (empty($_POST['start'])) ?  0 : $_POST['start'];
				
			$query = " SELECT id_producto, descripcion, codigo_barra FROM cat_productos";
			$query.= " $filtro ORDER BY id_producto LIMIT $start, $limit ";
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
	
	function obtenerproductosasignados(){
		try {
			$filtro_query= ( empty($_POST['query']) )? '' : $_POST['query']; 
			$id_trabajador = (empty($_POST['id_trabajador'])) ? 0 : $_POST['id_trabajador'];
			$id_asignacion = (empty($_POST['id_asignacion'])) ? 0 : $_POST['id_asignacion'];			
			$filtro="";
			$filtro=$this->filtroToSQL($filtro_query,array('p.descripcion','p.codigo_barra'));
			$filtro.= ($filtro) ? " AND (t.status_asignacion = 1 or t.id_asignacion = $id_asignacion) AND t.id_trabajador = $id_trabajador" : " WHERE (t.status_asignacion = 1 or t.id_asignacion = $id_asignacion) AND t.id_trabajador = $id_trabajador";
			
			$query = "SELECT COUNT(t.id_asignacion) AS totalrows FROM asignadas t 
					INNER JOIN cat_productos p ON p.id_producto = t.id_producto
			$filtro ";
			//throw new Exception(mysqli_error()." ".$query);
			$res = mysqlQuery($query);
			if (!$res)
			throw new Exception(mysqli_error()." ".$query);
				
			$resultado  = mysqli_fetch_array($res, MYSQL_ASSOC);
			$total_rows = $resultado['totalrows'];
				
			$limit = (empty($_POST['limit'])) ? 50 : $_POST['limit'];
			$start = (empty($_POST['start'])) ?  0 : $_POST['start'];
				
			$query = " SELECT t.id_producto,t.id_asignacion,t.id_trabajador,p.descripcion,p.codigo_barra FROM asignadas t";
			$query.= " INNER JOIN cat_productos p ON p.id_producto = t.id_producto ";
			$query.= " $filtro ORDER BY t.id_asignacion LIMIT $start, $limit ";
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
		
		 $pedidoModel=new PedidoModel();
		
		$resp = $pedidoModel->guardar($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Pedidos','mensaje'=> 'El pedido ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}
	
	function guardarasignacion(){
		$params = $_POST;
		
		 $pedidoModel=new PedidoModel();
		
		$resp = $pedidoModel->guardarasignacion($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Pedidos','mensaje'=> 'La asignacion ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}
	
	function editar(){
		$params = $_POST;
		
		 $pedidoModel=new PedidoModel();
		
		$resp = $pedidoModel->editar($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Pedidos','mensaje'=> 'El pedido ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}
	
	function agregarpago(){
		$params = $_POST;
		
		 $pedidoModel=new PedidoModel();
		
		$resp = $pedidoModel->agregarpago($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Pedidos','mensaje'=> 'El pago ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}
	
	function agregardiasextra(){
		$params = $_POST;
		
		 $pedidoModel=new PedidoModel();
		
		$resp = $pedidoModel->agregardiasextra($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Pedidos','mensaje'=> 'Dias agregados satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}
	
	function obtenerpagos(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $id_pedido = (empty($_POST['id_pedido'])) ?  '0': $_POST['id_pedido'];	
					      
            $pedidoModel=new PedidoModel();
			
            $response = $pedidoModel->readAllPagos($start,$limit,$id_pedido);
		//var_dump($response);
        return $response; //RETURN PARA COMPRIMIR LA RESPUESTA CON GZIP
    }
	
	function getpedido(){
		
		  
        $params = $_POST;
		$id =$params['id_pedido'];
		//throw new Exception($id);
		$pedidoModel=new PedidoModel();
		
		$resp=$pedidoModel->getpedido($id); 
		
		$response=array();
        $response['success']=true;            
        $response['data']=$resp;
		
        return $response;
	}
	
	function getpago(){
		
		  
        $params = $_POST;
		$id =$params['id_pago'];
		//throw new Exception($id);
		$pedidoModel=new PedidoModel();
		
		$resp=$pedidoModel->getpago($id); 
		
		$response=array();
        $response['success']=true;            
        $response['data']=$resp;
		
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

	public function regresarabodega(){
       
	   $idValue=$_POST['id_asignacion'];
   
		
		$query="UPDATE asignadas SET status_asignacion=2 WHERE id_asignacion=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_asignacion'=>$idValue
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Pedidos',
					'mensaje'=>"No se pudo regresar a bodega:".mysqli_error()
				);
        }else{
            $response['success'] = true;
            
            $response['msg'] = array(
					'titulo'=>'Pedidos',
					'mensaje'=>"Se ha regresado a bodega"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
	}
	
	public function eliminarpago(){
       
	   $params = $_POST;
		
		$pedidoModel=new PedidoModel();
		
		$resp = $pedidoModel->eliminarpago($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Pedidos','mensaje'=> 'El pago ha sido eliminado') ;            
            
        $response['data']=$resp;
		
        return $response;
	}
	
	public function cancelarrenta(){
       
	   $idValue=$_POST['id_pedido'];
   
		
		$query="UPDATE pedidos SET status='I' WHERE id_pedido=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_pedido'=>$idValue
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Pedidos',
					'mensaje'=>"No se pudo cancelar la renta:".mysqli_error()
				);
        }else{
            $response['success'] = true;
            
            $response['msg'] = array(
					'titulo'=>'Pedidos',
					'mensaje'=>"Se ha cancelado la renta"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
	}
	
	public function entregaanticipada(){
       
	   $idValue=$_POST['id_pedido'];
   
		
		$query="UPDATE pedidos SET status_renta=2 WHERE id_pedido=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_pedido'=>$idValue
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Pedidos',
					'mensaje'=>"No se pudo entregar la renta:".mysqli_error()
				);
        }else{
            $response['success'] = true;
            
            $response['msg'] = array(
					'titulo'=>'Pedidos',
					'mensaje'=>"Se ha entregado la renta"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
	}

	function generarreportepedido(){
		$params = $_POST;
		
		$reporte=new ReportePedidoTicket();
		
		$formatos=array(
	 		'decimales'=>2,
			'texto'=>0
	 	);
		$pdf = '';
		
		$pdf=$reporte->generarReporte($params,$formatos);
		mt_srand (time());
		
		$numero_aleatorio = mt_rand(0,5000); 
		$_SESSION['repCor']['rand']=$numero_aleatorio ;
		$_SESSION['repCor']['pdf']=$pdf ;		
		$response=array(
			'success'=>true,
			'data'=>array(
				'identificador'=>$numero_aleatorio
			)
		);
		return $response;
	}
	
	function getpdfpedido(){		
		if (!isset($_SESSION['repCor'])){				
			throw new Exception('El archivo ha caducado, realice una nueva consulta');
		}
		if (!isset($_SESSION['repCor']['pdf'])){				
			throw new Exception('Se ha perdido la referencia al archivo, realice una nueva consulta');
		}
		$pdfName=$_SESSION['repCor']['pdf'];
		
		$reporte=new ReportePedidoTicket();
		$reporte->getPDF($pdfName);
	}
	
	function eliminar(){
		// $pedidoModel=new PedidoModel();
		// $titulo=$pedidoModel->name;
		
		// if ( empty($_POST['id_pedido']) ){
			// return array(
				// 'success'=>false,
				// 'msg'=>array('titulo'=>"Error en la solicitud de borrado",'mensaje'=>"Debe proporcionar la referencia al pedido que desea eliminar"),
				// 'data'=>$data
			// );	
		// }
		
		// $id=$_POST['id_pedido'];	
	
		// $affected = $pedidoModel->delete($id);
		
		// if (empty($affected)){
			// $success=false;
			// $mensaje="El Pedido no fue eliminado";
		// }else{
			// $success=true;
			// $mensaje="Pedido eliminado de la base de datos";
		// }	
		// $data=array('id_pedido'=>$id);
		
		// return array(
			// 'success'=>$success,
			// 'msg'=>array(
					// 'titulo'=>'Pedidos',
					// 'mensaje'=>$mensaje
				// ),
			// 'data'=>$data
		// );
		
		$idValue=$_POST['id_pedido'];
		
		$query="UPDATE asignadas SET status_asignacion=1 WHERE id_pedido=$idValue";
        $result=mysqlQuery($query);
   
		
		$query="UPDATE pedidos SET status='I' WHERE id_pedido=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_pedido'=>$idValue
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Pedidos',
					'mensaje'=>"No se pudo cancelar el pedido:".mysqli_error()
				);
        }else{
            $response['success'] = true;
            
            $response['msg'] = array(
					'titulo'=>'Pedidos',
					'mensaje'=>"Se ha cancelado el pedido"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
		
	}

	function generarreporterentas(){
		$params = $_POST;
		$reporte=new ReporteRentas();
		
		$formatos=array(
	 		'decimales'=>2,
			'texto'=>0
	 	);
		$pdf = '';
		$pdf=$reporte->generarReporte($params,$formatos);
		mt_srand (time());
		
		$numero_aleatorio = mt_rand(0,5000); 
		$_SESSION['repRentas']['rand']=$numero_aleatorio ;
		$_SESSION['repRentas']['pdf']=$pdf ;		
		$response=array(
			'success'=>true,
			'data'=>array(
				'identificador'=>$numero_aleatorio
			)
		);
		return $response;
		
		
		
		
	}
	
	function getpdfrentas(){		
		if (!isset($_SESSION['repRentas'])){				
			throw new Exception('El archivo ha caducado, realice una nueva consulta');
		}
		if (!isset($_SESSION['repRentas']['pdf'])){				
			throw new Exception('Se ha perdido la referencia al archivo, realice una nueva consulta');
		}
		$pdfName=$_SESSION['repRentas']['pdf'];
		
		$reporte=new ReporteRentas();
		$reporte->getPDF($pdfName);
	}
	
	
	function generarreporterentasexcel(){
		$params = $_GET;
		$reporte=new ReporteRentas();
		
		$pdf=$reporte->generarReporteExcel($params);
	}
	
	function autorizar(){
		
		$idValue=$_POST['id_pedido'];
   
		
		$query="UPDATE pedidos SET autorizada=1 WHERE id_pedido=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_pedido'=>$idValue
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Pedidos',
					'mensaje'=>"No se pudo autorizar el pedido:".mysqli_error()
				);
        }else{
            $response['success'] = true;
            
            $response['msg'] = array(
					'titulo'=>'Pedidos',
					'mensaje'=>"Se ha autorizado el pedido"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
		
	}
	

}
?>
