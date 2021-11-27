<?php

class GastoModel extends Model{
    var $useTable = 'gastos';
    var $name='Gasto';
    var $primaryKey = 'id_gasto';
    var $specific = true;
    var $camposAfiltrar = array('concepto');


    
    public function readAll($start, $limit, $filtro, $filtroStatus) {
        
        if ($filtro != '') {
            $filtroSql = $this->filtroToSQL($filtro);
        } else {
            $filtroSql = '';
        }
		
		 if (strlen($filtroSql) > 0) {
				if ($filtroStatus=='A' or $filtroStatus=='a')
                $filtroSql.=" AND status='A' ";
				if ($filtroStatus=='I' or $filtroStatus=='i')
                $filtroSql.=" AND status='I' ";
            }else {
               if ($filtroStatus=='A' or $filtroStatus=='a')
                $filtroSql.="WHERE status='A' ";
				if ($filtroStatus=='I' or $filtroStatus=='i')
                $filtroSql.="WHERE status='I' ";
            }

        
      

        $query = "select count($this->primaryKey) as totalrows  FROM $this->useTable
        $filtroSql";
        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		//throw new Exception($query);
        $resultado = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $totalRows = $resultado['totalrows'];
		//var_dump($totalRows);

        $query = "SELECT id_gasto,  concepto, DATE_FORMAT(fecha,'%d/%m/%Y') as fecha, DATE_FORMAT(fecha,'%h:%i %p') as hora, importe, status
					FROM $this->useTable 					
					$filtroSql ORDER BY id_gasto limit $start,$limit ;";

        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		
        $response = ResulsetToExt::resToArray($res);
        $response['totalRows'] = $totalRows;
		
        return $response;
    }


	public function guardar($params){
		
    	$registroNuevo=false;
		$IDUsu=$_SESSION['Auth']['User']['id_usuario'];     
		 		
		$Gasto = $params['Gasto'];
		$id_gasto = $Gasto['id_gasto'];		
		$fecha = $Gasto['fecha'];		
		$hora = $Gasto['hora'];
		$datetime="$fecha $hora";
		$fecha=date('Y-m-d H:i:s',strtotime($datetime));
		$concepto = $Gasto['concepto'];
		$importe = $Gasto['importe'];
		
		
		if($id_gasto > 0){
			$query="UPDATE $this->useTable SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE $this->primaryKey = ".$id_gasto;
						
        }else{  //INSERT
            $query="INSERT INTO $this->useTable SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
						
        }        			
		
		$query.=",fecha='".$fecha."'";		
		$query.=",concepto='".$concepto."'";	
		$query.=",importe='".$this->EscComillas($importe)."'";
		

        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_gasto;
		}
		
		$data=$this->getgasto($id);   
        
		
		
		 return $data['Gasto'];
                     

    }
	
	public function getgasto($IDValue){	
		 $query = "SELECT id_gasto,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha,DATE_FORMAT(fecha,'%h:%i %p') as hora,  concepto, importe, status 
		 FROM $this->useTable
         WHERE id_gasto = $IDValue ;";			
		
		$arrGasto= $this->select($query);
		return array('Gasto'=>$arrGasto[0]);
		
		
	}
	
	public function delete($id){
		$sqlDelete="DELETE FROM  $this->useTable WHERE $this->primaryKey = $id ";
		return $this->queryDelete($sqlDelete);	
        //return parent::delete($id);
    }
	
}
?>
