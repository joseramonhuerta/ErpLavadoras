<?php

class PedidoModel extends Model{
    var $useTable = 'pedidos';
    var $name='Pedido';
    var $primaryKey = 'id_pedido';
    var $specific = true;
    var $camposAfiltrar = array('c.nombre');


    
    function readAll($start, $limit, $filtro, $filtroStatus) {
        
        if ($filtro != '') {
            $filtroSql = $this->filtroToSQL($filtro);
        } else {
            $filtroSql = '';
        }
		
		 if (strlen($filtroSql) > 0) {
			if ($filtroStatus=='A' or $filtroStatus=='a')
				$filtroSql.=" AND p.status='A' AND p.status_pedido = 0 ";
			else if ($filtroStatus=='I' or $filtroStatus=='i')
				$filtroSql.=" AND p.status='I' AND p.status_pedido = 0 ";
			else 
				$filtroSql.=" AND p.status_pedido = 0 ";
		}else {
		   if ($filtroStatus=='A' or $filtroStatus=='a')
				$filtroSql.="WHERE p.status='A' AND p.status_pedido = 0 ";
			else if ($filtroStatus=='I' or $filtroStatus=='i')
				$filtroSql.="WHERE p.status='I' AND p.status_pedido = 0 ";
			else
				$filtroSql.="WHERE p.status_pedido = 0 ";
		}

        
      //throw new Exception($filtroSql);

        $query = "select count($this->primaryKey) as totalrows  FROM $this->useTable p LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente
        $filtroSql";
        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		//throw new Exception($query);
        $resultado = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $totalRows = $resultado['totalrows'];
		//var_dump($totalRows);

        $query = "SELECT p.id_pedido, DATE_FORMAT(p.fecha_entrega,'%d/%m/%Y') as fecha_entrega, DATE_FORMAT(p.fecha_entrega,'%h:%i %p') as hora_entrega, p.id_trabajador,t1.nombre as nombre_trabajador, p.id_trabajador_ocacional,t2.nombre as nombre_trabajador_ocacional, p.plazo_pago, p.referencia, p.observaciones, p.precio_renta,
		p.status,p.status_pedido,
		c.nombre as nombre_cliente, c.calle, c.celular, 
		CASE 
			WHEN  TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW())  >= 1 THEN 3 
			WHEN  TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW())  >= -30 AND TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW()) < 1  THEN 2 
			ELSE 1
			END AS status_entrega  
					FROM $this->useTable p
					LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente
					LEFT JOIN cat_rutas r on r.id_ruta = p.id_ruta
					LEFT JOIN cat_trabajadores t1 on t1.id_trabajador = p.id_trabajador
					LEFT JOIN cat_trabajadores t2 on t2.id_trabajador = p.id_trabajador_ocacional
					$filtroSql ORDER BY p.id_pedido limit $start,$limit ;";

        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		
        $response = ResulsetToExt::resToArray($res);
        $response['totalRows'] = $totalRows;
		
        return $response;
    }

	function readAsignadas($start, $limit, $filtro) {
        
        if ($filtro != '') {
            $filtroSql = $this->filtroToSQL($filtro);
        } else {
            $filtroSql = '';
        }
		
		 if (strlen($filtroSql) > 0) {
			$filtroSql.=" AND a.status_asignacion= 1 ";
		}else {
		  
				$filtroSql.="WHERE a.status_asignacion= 1 ";
		}

        
      //throw new Exception($filtroSql);

        $query = "select count(a.id_asignacion) as totalrows  FROM asignadas a
        $filtroSql";
        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		//throw new Exception($query);
        $resultado = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $totalRows = $resultado['totalrows'];
		//var_dump($totalRows);

        $query = "SELECT a.id_asignacion, DATE_FORMAT(a.fecha,'%d/%m/%Y') as fecha, a.id_trabajador,t.nombre as nombre_trabajador, a.id_producto,CONCAT(p.codigo_barra,' - ',p.descripcion) as descripcion, CASE a.status_asignacion WHEN  1 then 'Asignado a Trabajador' WHEN 2 THEN 'En Bodega' END as status_asignacion
					FROM asignadas a
					LEFT JOIN cat_trabajadores t on t.id_trabajador = a.id_trabajador					
					LEFT JOIN cat_productos p on p.id_producto = a.id_producto
					$filtroSql ORDER BY a.id_asignacion limit $start,$limit ;";

        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		
        $response = ResulsetToExt::resToArray($res);
        $response['totalRows'] = $totalRows;
		
        return $response;
    }
	
	function readAllRentas($start,$limit,$fechainicio,$fechafin,$id_cliente,$id_trabajador,$filtroStatus) {
        
        
         $filtroSql = '';
       
		$
		$fechainicio.=" 00:00:00";		
		$fechafin.=" 23:59:59";
		
		/*AND ((p.fecha_entrega between '$fechainicio' AND '$fechafin') or p.status_renta = 2) p.status_renta = $filtroStatus*/		
		
		if ($filtroStatus==0)
				$filtroSql.="WHERE p.status = 'A' AND p.status_pedido = 1 AND ((p.fecha_entrega between '$fechainicio' AND '$fechafin') OR p.status_renta = 2)";
		else
				$filtroSql.="WHERE p.status = 'A' AND p.status_pedido = 1 AND ((p.fecha_entrega between '$fechainicio' AND '$fechafin') OR p.status_renta = 2) AND p.status_renta = $filtroStatus";
		
		
		if ($id_cliente > 0)
			$filtroSql.=" AND p.id_cliente = $id_cliente ";
		
		if ($id_trabajador > 0)
			$filtroSql.=" AND p.id_trabajador = $id_trabajador ";

        
      //throw new Exception($filtroSql);

        $query = "select count($this->primaryKey) as totalrows  FROM $this->useTable p LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente
        $filtroSql";
        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		//throw new Exception($query);
        $resultado = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $totalRows = $resultado['totalrows'];
		//var_dump($totalRows);
		/*
		CASE 
			WHEN  TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW())  >= 1 THEN 3 
			WHEN  TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW())  >= -30 AND TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW()) < 1  THEN 2 
			ELSE 1
			END AS status_entrega,
		*/
        $query = "SELECT p.id_pedido, DATE_FORMAT(p.fecha_entrega_cliente,'%d/%m/%Y') as fecha_entrega, DATE_FORMAT(p.fecha_entrega_cliente,'%h:%i %p') as hora_entrega, p.id_trabajador,t1.nombre as nombre_trabajador, p.id_trabajador_ocacional,t2.nombre as nombre_trabajador_ocacional, p.plazo_pago, p.referencia, p.observaciones, p.id_producto,Concat(pr.codigo_barra,' - ', pr.descripcion) as descripcion, p.precio_renta,
		p.status,p.status_pedido,
		CASE p.plazo_pago WHEN 1 THEN 7 WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 3 END as dias_renta,
		c.nombre as nombre_cliente, c.calle, c.celular, 
		p.status_renta,p.dias_extra,
				DATE_FORMAT(p.fecha_ultimo_vencimiento,'%d/%m/%Y') as fecha_ultimo_vencimiento,
				DATE_FORMAT(p.fecha_ultimo_pago,'%d/%m/%Y') as fecha_ultimo_pago,p.id_ultimo_pago,a.id_asignacion
					FROM $this->useTable p
					LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente
					LEFT JOIN cat_rutas r on r.id_ruta = p.id_ruta
					LEFT JOIN cat_trabajadores t1 on t1.id_trabajador = p.id_trabajador
					LEFT JOIN cat_trabajadores t2 on t2.id_trabajador = p.id_trabajador_ocacional
					LEFT JOIN cat_productos pr on pr.id_producto = p.id_producto
					LEFT JOIN asignadas a on a.id_pedido = p.id_pedido
					$filtroSql ORDER BY p.status_renta desc, p.fecha_entrega_cliente desc limit $start,$limit ;";

        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		
        $response = ResulsetToExt::resToArray($res);
        $response['totalRows'] = $totalRows;
		
        return $response;
    }
	
	function readAllPagos($start,$limit,$id_pedido) {
        
        
        $filtroSql = '';
       
		$filtroSql.="WHERE p.status = 'A' AND p.id_pedido = $id_pedido ";
		
		
		
        
      //throw new Exception($filtroSql);

        $query = "select count(p.id_pago) as totalrows  FROM pagos p $filtroSql";
        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		//throw new Exception($query);
        $resultado = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $totalRows = $resultado['totalrows'];
		//var_dump($totalRows);

        $query = "SELECT p.id_pago, DATE_FORMAT(p.fecha_pago,'%d/%m/%Y') as fecha_pago, 
		DATE_FORMAT(p.fecha_pago,'%h:%i %p') as hora_pago,p.importe,
		p.status,p.id_pedido,pp.id_cliente,c.nombre as nombre_cliente, pp.id_trabajador, t.nombre as nombre_trabajador
		FROM pagos p
		INNER JOIN pedidos pp on pp.id_pedido = p.id_pedido
		LEFT JOIN cat_clientes c on c.id_cliente = pp.id_cliente
		LEFT JOIN cat_trabajadores t on t.id_trabajador = pp.id_trabajador
		$filtroSql ORDER BY p.id_pago limit $start,$limit ;";

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
		 		
		$Pedido = $params['Pedido'];
		$id_pedido = $Pedido['id_pedido'];	
		$id_cliente = $Pedido['id_cliente'];		
		$fecha = $Pedido['fecha'];
		$hora = $Pedido['hora'];
		$datetime="$fecha $hora";
		$fecha=date('Y-m-d H:i:s',strtotime($datetime));
		$id_ruta = $Pedido['id_ruta'];
		$referencia = $Pedido['referencia'];
		
		$plazo_pago = $Pedido['plazo_pago'];
		$precio_renta = $Pedido['precio_renta'];
		$observaciones = $Pedido['observaciones'];
		
		$id_trabajador_ruta = $Pedido['id_trabajador_ruta'];
		$id_trabajador = $Pedido['id_trabajador'];
				
		if($id_pedido > 0){
			$query="UPDATE $this->useTable SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE $this->primaryKey = ".$id_pedido;
        }else{  //INSERT
            $query="INSERT INTO $this->useTable SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
        }
        	
		if (is_numeric($id_cliente)){	
			$query.=",id_cliente='".$id_cliente."'";
		}
		if (is_numeric($id_ruta)){	
			$query.=",id_ruta='".$id_ruta."'";
		}
		if (is_numeric($id_trabajador_ruta)){	
			$query.=",id_trabajador='".$id_trabajador_ruta."'";
		}
		if (is_numeric($id_trabajador)){	
			$query.=",id_trabajador_ocacional='".$id_trabajador."'";
		}
		
		if (is_numeric($plazo_pago)){	
			$query.=",plazo_pago='".$plazo_pago."'";
		}
		
		$query.=",fecha_entrega='".$fecha."'";
		$query.=",fecha_entrega_cliente='".$fecha."'";
		$query.=",fecha_ultimo_vencimiento='".$fecha."'";
		$query.=",fecha_ultimo_pago='".$fecha."'";	
		$query.=",referencia='".$this->EscComillas($referencia)."'";
		$query.=",observaciones='".$this->EscComillas($observaciones)."'";
		$query.=",precio_renta='".$precio_renta."'";	
		$query.=",status_pedido=0";

        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_pedido;
		}
		
		$data=$this->getpedido($id);   
        
		
		
		 return $data['Pedido'];
                     

    }
	
	public function guardarasignacion($params){
		
    	$registroNuevo=false;
		$IDUsu=$_SESSION['Auth']['User']['id_usuario'];     
		 		
		$Asignacion = $params['Asignacion'];
		$id_asignacion = $Asignacion['id_asignacion'];	
		$fecha = $Asignacion['fecha'];		
		$datetime="$fecha 00:00:00";
		$fecha=date('Y-m-d H:i:s',strtotime($datetime));
		
		
		$id_trabajador = $Asignacion['id_trabajador'];
		$id_producto = $Asignacion['id_producto'];
		
		if($id_asignacion > 0){
			$query="UPDATE asignadas SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE id_asignacion = ".$id_asignacion;
        }else{  //INSERT
            $query="INSERT INTO asignadas SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
        }
        	
		
		if (is_numeric($id_trabajador)){	
			$query.=",id_trabajador='".$id_trabajador."'";
		}
		
		if (is_numeric($id_producto)){	
			$query.=",id_producto='".$id_producto."'";
		}
				
		$query.=",fecha='".$fecha."'";	
		
        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_asignacion;
		}
		
		$data=$this->getasignacion($id);   
        
		
		
		 return $data['Asignacion'];
                     

    }
	
	public function editar($params){
		
    	$registroNuevo=false;
		$IDUsu=$_SESSION['Auth']['User']['id_usuario'];     
		 		
		$Pedido = $params['Pedido'];
		$id_pedido = $Pedido['id_pedido'];
		$id_producto = $Pedido['id_producto'];		
		$id_asignacion = (empty($Pedido['id_asignacion'])) ? 0 : $Pedido['id_asignacion'];
		$id_asignacion_nueva = (empty($Pedido['id_asignacion_nueva'])) ? 0 : $Pedido['id_asignacion_nueva'];		
		$fecha = $Pedido['fecha'];
		$hora = $Pedido['hora'];
		$datetime="$fecha $hora";
		$fecha=date('Y-m-d H:i:s',strtotime($datetime));
				
		
		$precio_renta = $Pedido['precio_renta'];
		$observaciones = $Pedido['observaciones'];
		$fecha_ultimo_pago = $Pedido['fecha_ultimo_pago'];
		$id_trabajador = $Pedido['id_trabajador'];
		//$dias_extra = $Pedido['dias_extra'];		
		
		if($id_pedido > 0){
			$query="UPDATE $this->useTable SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE $this->primaryKey = ".$id_pedido;
        }else{  //INSERT
            $query="INSERT INTO $this->useTable SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
        }
        	
		if (is_numeric($id_trabajador)){	
			$query.=",id_trabajador='".$id_trabajador."'";
		}
		
		if (is_numeric($id_producto)){	
			$query.=",id_producto='".$id_producto."'";
		}
		/*
		if ($dias_extra > 0){	
			$query.=",fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,".$dias_extra.")";
		}		
		*/
		
		$query.=",fecha_ultimo_pago='".$fecha_ultimo_pago."'";
		$query.=",fecha_entrega='".$fecha."'";
		$query.=",observaciones='".$this->EscComillas($observaciones)."'";
		$query.=",precio_renta='".$precio_renta."'";	
		//$query.=",dias_extra='".$dias_extra."'";	
		
        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_pedido;
		}
		
		if($id_asignacion > 0 && ($id_asignacion_nueva > 0 && $id_asignacion <> $id_asignacion_nueva)){
			$queryA="UPDATE asignadas SET id_pedido = $id, status_asignacion = 3 WHERE id_asignacion = $id_asignacion_nueva; ";
			$this->update($queryA);
			
			$queryB="UPDATE asignadas SET id_pedido = null, status_asignacion = 1 WHERE id_asignacion = $id_asignacion; ";
			$this->update($queryB);
			
		}
		
		$data=$this->getpedido($id);   
        
		
		
		 return $data['Pedido'];
                     

    }
	
	public function agregarpago($params){
		
    	$registroNuevo=false;
		$IDUsu=$_SESSION['Auth']['User']['id_usuario'];     
		 		
		$Pago = $params['Pago'];
		$id_pedido = $Pago['id_pedido'];	
		$id_pago = $Pago['id_pago'];		
		$fecha = $Pago['fecha'];
		$hora = $Pago['hora'];
		$datetime="$fecha $hora";
		$fecha=date('Y-m-d H:i:s',strtotime($datetime));
				
		
		$precio_renta = $Pago['precio_renta'];		
		
		if($id_pago > 0){
			$query="UPDATE pagos SET ";            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE id_pago = ".$id_pago;
        }else{  //INSERT
            $query="INSERT INTO pagos SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
        }
        	
		if (is_numeric($id_pedido)){	
			$query.=",id_pedido='".$id_pedido."'";
		}
		
		
		$query.=",fecha_pago='".$fecha."'";			
		$query.=",importe='".$precio_renta."'";	
		
        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_pago;
		}
		
		$data=$this->getpago($id);   
        
		
		
		 return $data['Pago'];
                     

    }
	
	public function getpedido($IDValue){	
		 $query = "SELECT p.id_pedido,p.id_trabajador,t.nombre as nombre_trabajador,p.numero_recibo,DATE_FORMAT(p.fecha_entrega,'%d/%m/%Y') as fecha_entrega,DATE_FORMAT(p.fecha_entrega,'%h:%i %p') as hora_entrega,DATE_FORMAT(p.fecha_ultimo_vencimiento,'%d/%m/%Y') as fecha_ultimo_vencimiento, DATE_FORMAT(p.fecha_ultimo_pago,'%d/%m/%Y') as fecha_ultimo_pago, p.precio_renta, case p.plazo_pago when 1 then 'SEMANAL' when 2 then '1 DIA' when 3 then '2 DIAS' when 4 then '3 DIAS' end as plazo_pago, p.observaciones, c.nombre as nombre_cliente,p.dias_extra,p.id_producto, a.id_asignacion  
		 FROM $this->useTable p ";
		 $query .= " LEFT JOIN cat_trabajadores t on t.id_trabajador = p.id_trabajador";
		 $query .= " LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente";
		 $query .= " LEFT JOIN asignadas a on p.id_pedido = a.id_pedido";			 
         $query .= " WHERE p.id_pedido = $IDValue ;";			
		
		$arrPedido= $this->select($query);
		return array('Pedido'=>$arrPedido[0]);
		
		
	}
	
	public function getpago($IDValue){	
		 $query = "SELECT p.id_pedido,p.id_pago,DATE_FORMAT(p.fecha_pago,'%d/%m/%Y') as fecha_pago,DATE_FORMAT(p.fecha_pago,'%h:%i %p') as hora_pago, p.importe FROM pagos p ";
		 $query .= " WHERE p.id_pago = $IDValue ;";			
		
		$arrPago = $this->select($query);
		return array('Pago'=>$arrPago[0]);
		
		
	}
	
	public function getasignacion($IDValue){	
		 $query = "SELECT id_asignacion, id_trabajador,id_producto  
		 FROM asignadas ";
		 $query .= " WHERE id_asignacion = $IDValue ;";			
		
		$arrPedido= $this->select($query);
		return array('Asignacion'=>$arrPedido[0]);
		
		
	}
	
	public function delete($id){
		$sqlDelete="DELETE FROM  $this->useTable WHERE id_pedido = $id ";
		return $this->queryDelete($sqlDelete);	
        //return parent::delete($id);
    }
	
	public function actualizastatusrentas(){
		 $query = "UPDATE pedidos SET status_renta = 2
					WHERE status_pedido = 1 AND 
					DATE(ADDDATE(fecha_ultimo_vencimiento, CASE plazo_pago WHEN 1 THEN 7 WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 3 END)) <= CURDATE()";

		$result=$this->update($query);     
		
	}
	
	public function agregardiasextra($params){
		
    	$registroNuevo=false;
		$IDUsu=$_SESSION['Auth']['User']['id_usuario'];     
		 		
		$Pedido = $params['Pedido'];
		$id_pedido = $Pedido['id_pedido'];	
		$dias_extra = $Pedido['dias_extra'];		
		
		if ($dias_extra > 0){
			
			$query="UPDATE $this->useTable SET ";		
			$query.="usermodif=$IDUsu";    //LOG
			$query.=",fechamodif=now()";
			$where=" WHERE $this->primaryKey = ".$id_pedido;	
			
			$query.=",fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,".$dias_extra.")";
			$query.=",dias_extra= dias_extra + ".$dias_extra;	
			
			$query=$query.$where;
			 
			if ($registroNuevo){            
				$id= $this->insert($query); 			
				
			}else{		
				$result=$this->update($query);               
				$id=$id_pedido;
			}
		}
		
		$data=$this->getpedido($id);	
		
		 return $data['Pedido'];
                     

    }
}
?>
