<?php
require ('eko_framework/app/models/producto.php');       //MODELO
require_once "eko_framework/app/models/reporte_inventarios.php";
class Productos extends ApplicationController {
    function getModelObject(){
    	if (empty($this->model)) {
    		$this->model=new Model();
    	}
    	return $this->model;
    } 
    function obtenerproductos(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $filtro = (empty($_POST['filtro'])) ?  '': $_POST['filtro']; 
			$filtroStatus = (empty($_POST['filtroStatus'])) ?  'A': $_POST['filtroStatus'];			
		      
            $productoModel=new ProductoModel();
			
            $response = $productoModel->readAll($start,$limit,$filtro,$filtroStatus);
		//var_dump($response);
        return $response; //RETURN PARA COMPRIMIR LA RESPUESTA CON GZIP
    }
	
	function guardar(){
		$params = $_POST;
		
		$productoModel=new ProductoModel();
		
		$resp = $productoModel->guardar($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Productos','mensaje'=> 'La información del Producto ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}

	function eliminar(){
		$productoModel=new ProductoModel();
		$titulo=$productoModel->name;
		
		if ( empty($_POST['id_producto']) ){
			return array(
				'success'=>false,
				'msg'=>array('titulo'=>"Error en la solicitud de borrado",'mensaje'=>"Debe proporcionar la referencia al Producto que desea eliminar"),
				'data'=>$data
			);	
		}
		
		$id=$_POST['id_producto'];	
	
		$affected = $productoModel->delete($id);
		
		if (empty($affected)){
			$success=false;
			$mensaje="El Producto no fue eliminado";
		}else{
			$success=true;
			$mensaje="Producto eliminado de la base de datos";
		}	
		$data=array('id_producto'=>$id);
		
		return array(
			'success'=>$success,
			'msg'=>array(
					'titulo'=>'Productos',
					'mensaje'=>$mensaje
				),
			'data'=>$data
		);
		
	}
	
	public function cambiarstatus(){
       
	   $idValue=$_POST['id_producto'];
   
		
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
		
		
        $query="UPDATE cat_productos SET status='$nuevoStatus' WHERE id_producto=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_producto'=>$id,
			'status'=>$nuevoStatus
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Productos',
					'mensaje'=>"Error al actualizar el estado del Producto:".mysql_error()
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
					'titulo'=>'Productos',
					'mensaje'=>"El Producto ha sido $estado"
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

	function generarreporteinventario(){
		$params = $_POST;
		$reporte=new ReporteInventarios();
			
		$formatos=array(
	 		'decimales'=>2,
			'texto'=>0
	 	);
		$pdf = '';
		$pdf=$reporte->generarReporte($params,$formatos);
		mt_srand (time());
		
		$numero_aleatorio = mt_rand(0,5000); 
		$_SESSION['repInventarios']['rand']=$numero_aleatorio ;
		$_SESSION['repInventarios']['pdf']=$pdf ;		
		$response=array(
			'success'=>true,
			'data'=>array(
				'identificador'=>$numero_aleatorio
			)
		);
		return $response;
		
		
		
		
	}
	
	function getpdfinventarios(){		
		if (!isset($_SESSION['repInventarios'])){				
			throw new Exception('El archivo ha caducado, realice una nueva consulta');
		}
		if (!isset($_SESSION['repInventarios']['pdf'])){				
			throw new Exception('Se ha perdido la referencia al archivo, realice una nueva consulta');
		}
		$pdfName=$_SESSION['repInventarios']['pdf'];
		
		$reporte=new ReporteInventarios();
		$reporte->getPDF($pdfName);
	}
	
	
	function generarreporteinventariosexcel(){
		$params = $_GET;
		$reporte=new ReporteInventarios();
		
		$pdf=$reporte->generarReporteExcel($params);
	}
	
}
?>
