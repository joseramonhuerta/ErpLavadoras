<?php
require ('eko_framework/app/models/gasto.php');       //MODELO
require_once "eko_framework/app/models/reporte_gastos.php";
class Gastos extends ApplicationController {
    public function getModelObject(){
    	if (empty($this->model)) {
    		$this->model=new Model();
    	}
    	return $this->model;
    } 
	
    public function obtenergastos(){ //<----------------PARA EL GRID
			
            $limit = (empty($_POST['limit'])) ? 20 : $_POST['limit'];
            $start = (empty($_POST['start'])) ?  0 : $_POST['start'];
            $filtro = (empty($_POST['filtro'])) ?  '': $_POST['filtro']; 
			$filtroStatus = (empty($_POST['filtroStatus'])) ?  'A': $_POST['filtroStatus'];			
		      
            $gastoModel=new GastoModel();
			
            $response = $gastoModel->readAll($start,$limit,$filtro,$filtroStatus);
		
        return $response;
    }
	
	public function guardar(){
		$params = $_POST;
		
		$gastoModel=new GastoModel();
		
		$resp = $gastoModel->guardar($params);
		
		$response=array();
        $response['success']=true;
        $response['msg'] = array('titulo'=>'Gastos','mensaje'=> 'La información del Gasto ha sido guardada satisfactoriamente') ;            
            
        $response['data']=$resp;
		
        return $response;
	}

	public function eliminar(){
		$gastoModel=new GastoModel();
		$titulo=$gastoModel->name;
		
		if ( empty($_POST['id_gasto']) ){
			return array(
				'success'=>false,
				'msg'=>array('titulo'=>"Error en la solicitud de borrado",'mensaje'=>"Debe proporcionar la referencia al Gasto que desea eliminar"),
				'data'=>$data
			);	
		}
		
		$id=$_POST['id_gasto'];	
	
		$affected = $gastoModel->delete($id);
		
		if (empty($affected)){
			$success=false;
			$mensaje="El Gasto no fue eliminado";
		}else{
			$success=true;
			$mensaje="Gasto eliminado de la base de datos";
		}	
		$data=array('id_gasto'=>$id);
		
		return array(
			'success'=>$success,
			'msg'=>array(
					'titulo'=>'Gastos',
					'mensaje'=>$mensaje
				),
			'data'=>$data
		);
		
	}
	
	public function cambiarstatus(){
       
	   $idValue=$_POST['id_gasto'];
   
		
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
		
		
        $query="UPDATE gastos SET status='$nuevoStatus' WHERE id_gasto=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_gasto'=>$id,
			'status'=>$nuevoStatus
		);
		
        if (!$result){
            $response['success']=false;
            $response['msg']= array(
					'titulo'=>'Gastos',
					'mensaje'=>"Error al actualizar el estado del Gasto:".mysql_error()
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
					'titulo'=>'Gastos',
					'mensaje'=>"El Gasto ha sido $estado"
				);
			
			$response['data'] = $data;
        }
		
        return $response;
	}

	public function filtroToSQL($filtro,$camposAfiltrar=array()) {
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
	
	function generarreportegastos(){
		$params = $_POST;
		$reporte=new ReporteGastos();
		
		$formatos=array(
	 		'decimales'=>2,
			'texto'=>0
	 	);
		$pdf = '';
		$pdf=$reporte->generarReporte($params,$formatos);
		mt_srand (time());
		
		$numero_aleatorio = mt_rand(0,5000); 
		$_SESSION['repGastos']['rand']=$numero_aleatorio ;
		$_SESSION['repGastos']['pdf']=$pdf ;		
		$response=array(
			'success'=>true,
			'data'=>array(
				'identificador'=>$numero_aleatorio
			)
		);
		return $response;
		
		
		
		
	}
	
	function getpdfgastos(){		
		if (!isset($_SESSION['repGastos'])){				
			throw new Exception('El archivo ha caducado, realice una nueva consulta');
		}
		if (!isset($_SESSION['repGastos']['pdf'])){				
			throw new Exception('Se ha perdido la referencia al archivo, realice una nueva consulta');
		}
		$pdfName=$_SESSION['repGastos']['pdf'];
		
		$reporte=new ReporteGastos();
		$reporte->getPDF($pdfName);
	}
	
	
	function generarreportegastosexcel(){
		$params = $_GET;
		$reporte=new ReporteGastos();
		
		$pdf=$reporte->generarReporteExcel($params);
	}
	

}
?>
