<?php

class ClienteModel extends Model{
    var $useTable = 'cat_clientes';
    var $name='Cliente';
    var $primaryKey = 'id_cliente';
    var $specific = true;
    var $camposAfiltrar = array('c.nombre','c.calle', 'c.colonia','c.celular');


    
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

        $query = "SELECT c.id_cliente,  c.nombre, c.calle, c.colonia, c.cp, c.curp, c.num_credencial, c.telefono1, c.telefono2, c.celular, c.correo, c.status, r.id_ruta, r.descripcion AS ruta 
					FROM $this->useTable c
					LEFT JOIN cat_rutas r on r.id_ruta = c.id_ruta
					$filtroSql ORDER BY c.id_cliente limit $start,$limit ;";

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
		 		
		$Cliente = $params['Cliente'];
		$id_cliente = $Cliente['id_cliente'];		
		$nombre = $Cliente['nombre'];		
		$calle = $Cliente['calle'];
		$colonia = $Cliente['colonia'];
		
		$cp = $Cliente['cp'];
		$correo = $Cliente['correo'];
		$curp = $Cliente['curp'];
		$num_credencial = $Cliente['num_credencial'];
		$telefono1 = $Cliente['telefono1'];
		$telefono2 = $Cliente['telefono2'];
		$celular = $Cliente['celular'];
		$id_ruta = $Cliente['id_ruta'];
		
		if($id_cliente > 0){
			$query="UPDATE $this->useTable SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE $this->primaryKey = ".$id_cliente;
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
		
		$query.=",nombre='".$nombre."'";	
		$query.=",calle='".$this->EscComillas($calle)."'";
		$query.=",colonia='".$this->EscComillas($colonia)."'";
		$query.=",cp='".$this->EscComillas($cp)."'";
		$query.=",curp='".$this->EscComillas($curp)."'";
		$query.=",num_credencial='".$this->EscComillas($num_credencial)."'";
		$query.=",correo='".$this->EscComillas($correo)."'";
		$query.=",telefono1='".$this->EscComillas($telefono1)."'";		
		$query.=",telefono2='".$this->EscComillas($telefono2)."'";
		$query.=",celular='".$this->EscComillas($celular)."'";

        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_cliente;
		}
		
		$data=$this->getcliente($id);   
        
		
		
		 return $data['Cliente'];
                     

    }
	
	public function getcliente($IDValue){	
		 $query = "SELECT c.id_cliente,  c.nombre, c.calle, c.colonia, c.cp, c.curp, c.num_credencial, c.telefono1, c.telefono2, c.celular, c.correo, c.status, r.id_ruta, r.descripcion AS ruta  FROM $this->useTable c
		 LEFT JOIN cat_rutas r on r.id_ruta = c.id_ruta
         WHERE c.id_cliente = $IDValue ;";			
		
		$arrCliente= $this->select($query);
		return array('Cliente'=>$arrCliente[0]);
		
		
	}
	
	public function delete($id){
		$sqlDelete="DELETE FROM  $this->useTable WHERE id_cliente = $id ";
		return $this->queryDelete($sqlDelete);	
        //return parent::delete($id);
    }
	
}
?>
