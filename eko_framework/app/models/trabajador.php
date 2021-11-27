<?php

class TrabajadorModel extends Model{
    var $useTable = 'cat_trabajadores';
    var $name='Trabajador';
    var $primaryKey = 'id_trabajador';
    var $specific = true;
    var $camposAfiltrar = array('nombre');


    
    function readAll($start, $limit, $filtro, $filtroStatus) {
        
        if ($filtro != '') {
            $filtroSql = $this->filtroToSQL($filtro);
        } else {
            $filtroSql = '';
        }
		
		 if (strlen($filtroSql) > 0) {
				if ($filtroStatus=='A' or $filtroStatus=='a')
                $filtroSql.=" AND c.status='A' ";
				if ($filtroStatus=='I' or $filtroStatus=='i')
                $filtroSql.=" AND c.status='I' ";
            }else {
               if ($filtroStatus=='A' or $filtroStatus=='a')
                $filtroSql.="WHERE c.status='A' ";
				if ($filtroStatus=='I' or $filtroStatus=='i')
                $filtroSql.="WHERE c.status='I' ";
            }

        
      

        $query = "select count($this->primaryKey) as totalrows  FROM $this->useTable c
        $filtroSql";
        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		//throw new Exception($query);
        $resultado = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $totalRows = $resultado['totalrows'];
		//var_dump($totalRows);

        $query = "SELECT c.id_trabajador,  c.nombre, c.direccion, c.curp, c.telefono1, c.telefono2, c.celular, c.tipo, c.status, c.id_ruta, r.descripcion AS ruta, c.num_credencial 
					FROM $this->useTable c
					LEFT JOIN cat_rutas r on r.id_ruta = c.id_ruta
					$filtroSql ORDER BY c.id_trabajador limit $start,$limit ;";

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
		 		
		$Trabajador = $params['Trabajador'];
		$id_trabajador = $Trabajador['id_trabajador'];		
		$nombre = $Trabajador['nombre'];		
		$direccion = $Trabajador['direccion'];
		$curp = $Trabajador['curp'];
		$num_credencial = $Trabajador['num_credencial'];
		$telefono1 = $Trabajador['telefono1'];
		$telefono2 = $Trabajador['telefono2'];
		$celular = $Trabajador['celular'];
		$tipo = $Trabajador['tipo'];
		$id_ruta = $Trabajador['id_ruta'];
		
		if($id_trabajador > 0){
			$query="UPDATE $this->useTable SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE $this->primaryKey = ".$id_trabajador;
        }else{  //INSERT
            $query="INSERT INTO $this->useTable SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
        }
        	
		
		if (is_numeric($id_ruta)){	
			$query.=",id_ruta='".$id_ruta."'";
		}
		
		if (is_numeric($tipo)){	
			$query.=",tipo='".$tipo."'";
		}
		
		$query.=",nombre='".$nombre."'";	
		$query.=",direccion='".$this->EscComillas($direccion)."'";
		$query.=",curp='".$this->EscComillas($curp)."'";
		$query.=",num_credencial='".$this->EscComillas($num_credencial)."'";
		$query.=",telefono1='".$this->EscComillas($telefono1)."'";		
		$query.=",telefono2='".$this->EscComillas($telefono2)."'";
		$query.=",celular='".$this->EscComillas($celular)."'";

        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_trabajador;
		}
		
		$data=$this->gettrabajador($id);   
        
		
		
		 return $data['Trabajador'];
                     

    }
	
	public function gettrabajador($IDValue){	
		 $query = "SELECT c.id_trabajador,  c.nombre, c.direccion, c.curp, c.telefono1, c.telefono2, c.celular, c.tipo, c.status, c.id_ruta, r.descripcion AS ruta 
		 FROM $this->useTable c
		 LEFT JOIN cat_rutas r on r.id_ruta = c.id_ruta
         WHERE c.id_trabajador = $IDValue ;";			
		
		$arrTrabajador= $this->select($query);
		return array('Trabajador'=>$arrTrabajador[0]);
		
		
	}
	
	public function delete($id){
		$sqlDelete="DELETE FROM  $this->useTable WHERE $this->primaryKey = $id ";
		return $this->queryDelete($sqlDelete);	
        //return parent::delete($id);
    }
	
}
?>
