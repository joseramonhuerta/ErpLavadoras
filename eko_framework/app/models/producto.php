<?php

class ProductoModel extends Model{
    var $useTable = 'cat_productos';
    var $name='Producto';
    var $primaryKey = 'id_producto';
    var $specific = true;
    var $camposAfiltrar = array('descripcion','codigo_barra');


    
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

        $query = "SELECT c.id_producto,  c.descripcion, c.codigo_barra, c.precio, c.status
					FROM $this->useTable c					
					$filtroSql ORDER BY c.id_producto limit $start,$limit ;";

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
		 		
		$Producto = $params['Producto'];
		$id_producto = $Producto['id_producto'];		
		$descripcion = $Producto['descripcion'];		
		$codigo_barra = $Producto['codigo_barra'];
		$precio = $Producto['precio'];
		
		
		if($id_producto > 0){
			$query="UPDATE $this->useTable SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE $this->primaryKey = ".$id_producto;
			
			$query_codigo = "select count($this->primaryKey) as totalrows  FROM $this->useTable WHERE codigo_barra = '{$codigo_barra}' and id_producto <> $id_producto";
			$res_codigo = mysqlQuery($query_codigo);
			if (!$res_codigo)
				throw new Exception(mysqli_error() . " " . $query_codigo);
			
			$resultado_codigo = mysqli_fetch_array($res_codigo, MYSQLI_ASSOC);
			$totalCodigo = $resultado_codigo['totalrows'];
			if($totalCodigo > 0)
					throw new Exception("El codigo de barras {$codigo_barra} ya se encuentra registrado en otro producto.");
        }else{  //INSERT
            $query="INSERT INTO $this->useTable SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
			
			$query_codigo = "select count($this->primaryKey) as totalrows  FROM $this->useTable WHERE codigo_barra = '{$codigo_barra}'";
			$res_codigo = mysqlQuery($query_codigo);
			if (!$res_codigo)
				throw new Exception(mysqli_error() . " " . $query_codigo);
			
			$resultado_codigo = mysqli_fetch_array($res_codigo, MYSQLI_ASSOC);
			$totalCodigo = $resultado_codigo['totalrows'];
			if($totalCodigo > 0)
					throw new Exception("El codigo de barras {$codigo_barra} ya se encuentra registrado en otro producto.");	
        }        			
				
		$query.=",descripcion='".$descripcion."'";	
		$query.=",codigo_barra='".$this->EscComillas($codigo_barra)."'";
		$query.=",precio='".$this->EscComillas($precio)."'";
		

        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_producto;
		}
		
		$data=$this->getproducto($id);   
        
		
		
		 return $data['Producto'];
                     

    }
	
	public function getproducto($IDValue){	
		 $query = "SELECT c.id_producto,  c.descripcion, c.codigo_barra, c.precio, c.status 
		 FROM $this->useTable c		 
         WHERE c.id_producto = $IDValue ;";			
		
		$arrProducto= $this->select($query);
		return array('Producto'=>$arrProducto[0]);
		
		
	}
	
	public function delete($id){
		$sqlDelete="DELETE FROM  $this->useTable WHERE $this->primaryKey = $id ";
		return $this->queryDelete($sqlDelete);	
        //return parent::delete($id);
    }
	
}
?>
