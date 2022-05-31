<?php

class PedidoModel extends Model{
    var $useTable = 'pedidos';
    var $name='Pedido';
    var $primaryKey = 'id_pedido';
    var $specific = true;
    var $camposAfiltrar = array('c.calle','c.colonia','c.celular','p.observaciones','pr.codigo_barra' , 'pr.descripcion');


    
    function readAllPedidos($start, $limit, $filtro, $filtroStatus) {
        
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

        
		$filtroSql.=" AND autorizada = 1";
		
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
		c.nombre as nombre_cliente, c.calle, c.celular, c.colonia, 
		CASE 
			WHEN  TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW())  >= 1 THEN 3 
			WHEN  TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW())  >= -30 AND TIMESTAMPDIFF(MINUTE,fecha_entrega,NOW()) < 1  THEN 2 
			ELSE 1
			END AS status_entrega,p.autorizada,p.origen  
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

        $query = "SELECT a.id_asignacion, DATE_FORMAT(a.fecha,'%d/%m/%Y') as fecha, a.id_trabajador,t.nombre as nombre_trabajador, a.id_producto,CONCAT(p.codigo_barra,' - ',p.descripcion) as descripcion, CASE a.status_asignacion WHEN  1 then 'Asignado a Trabajador' WHEN 2 THEN 'En Bodega' WHEN 3 THEN 'Entregada al Cliente' END as status_asignacion
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
	
	function readAllRentas($start,$limit,$fechainicio,$fechafin,$id_cliente,$id_trabajador,$filtroStatus,$filtroFechas,$filtroCobradas, $filtroRecogidas, $filtro) {
        
        
         if ($filtro != '') {
            $filtroSql = $this->filtroToSQL($filtro);
        } else {
            $filtroSql = '';
        }
       
		$fechainicio.=" 00:00:00";		
		$fechafin.=" 23:59:59";
		
		/*
		//filtros old
		if ($filtroStatus==0)
				$filtroSql.="WHERE p.status = 'A' AND p.status_pedido = 1 AND ((p.fecha_entrega between '$fechainicio' AND '$fechafin') OR p.status_renta = 2)";
		else
				$filtroSql.="WHERE p.status = 'A' AND p.status_pedido = 1 AND ((p.fecha_entrega between '$fechainicio' AND '$fechafin') OR p.status_renta = 2) AND p.status_renta = $filtroStatus";
		
		
		if ($id_cliente > 0)
			$filtroSql.=" AND p.id_cliente = $id_cliente ";
		
		if ($id_trabajador > 0)
			$filtroSql.=" AND p.id_trabajador = $id_trabajador ";

        */
		
		 if (strlen($filtroSql) > 0) {
			$filtroSql.=" AND autorizada = 1 AND ";
		 
		 }else{
			 
			$filtroSql.=" WHERE autorizada = 1 AND"; 
		 }
		
		if($filtroCobradas == 1){
			$filtroSql.=" p.status = 'A' AND p.status_pedido >= 1 ";
			if ($filtroFechas == 1)
				$filtroSql.=" AND DATE(p.fecha_ultimo_pago) between '$fechainicio' AND '$fechafin' ";
			else
				$filtroSql.=" AND DATE(p.fecha_ultimo_pago) = CURDATE() ";
			
		}else if($filtroRecogidas ==1){
			$filtroSql.=" p.status = 'A' AND p.status_pedido >= 1 ";
			if ($filtroFechas == 1)
				$filtroSql.=" AND DATE(p.fecha_recogida) between '$fechainicio' AND '$fechafin' ";
			else
				$filtroSql.=" AND DATE(p.fecha_recogida) = CURDATE() ";
		}else{
			$filtroSql.=" p.status = 'A' AND p.status_pedido = 1";
			
			if ($filtroFechas == 1)
				$filtroSql.=" AND p.fecha_entrega between '$fechainicio' AND '$fechafin' ";
		}
		
		
		
		if ($id_cliente > 0)
			$filtroSql.=" AND p.id_cliente = $id_cliente ";
		
		if ($id_trabajador > 0)
			$filtroSql.=" AND p.id_trabajador_ocacional = $id_trabajador ";
		
		if ($filtroStatus > 0)
			$filtroSql.=" AND p.status_renta = $filtroStatus ";    
	  

        $query = "select count($this->primaryKey) as totalrows  FROM $this->useTable p LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente
		LEFT JOIN cat_productos pr on pr.id_producto = p.id_producto
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
        $query = "SELECT p.id_pedido, DATE_FORMAT(p.fecha_entrega,'%d/%m/%Y %h:%i %p') as fecha_entrega,DATE_FORMAT(p.fecha_entrega_cliente,'%d/%m/%Y %h:%i %p') as fecha_entrega_cliente, p.id_trabajador,t1.nombre as nombre_trabajador, p.id_trabajador_ocacional,t2.nombre as nombre_trabajador_ocacional, p.plazo_pago, p.referencia, p.observaciones, p.id_producto,Concat(pr.codigo_barra,' - ', pr.descripcion) as descripcion, p.precio_renta,c.colonia,
		p.status,p.status_pedido,
		CASE p.plazo_pago WHEN 1 THEN 7 WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 3 END as dias_renta,
		c.nombre as nombre_cliente, c.calle, c.celular, 
		p.status_renta,p.dias_extra,
				DATE_FORMAT(p.fecha_ultimo_vencimiento,'%d/%m/%Y') as fecha_ultimo_vencimiento,
				DATE_FORMAT(p.fecha_ultimo_pago,'%d/%m/%Y') as fecha_ultimo_pago,
				DATE_FORMAT(p.fecha_recogida,'%d/%m/%Y') as fecha_recogida,
				p.id_ultimo_pago,a.id_asignacion
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
		p.status,p.id_pedido,pp.id_cliente,c.nombre as nombre_cliente, IFNULL(p.id_trabajador,u.id_usuario) AS id_trabajador, IFNULL(t.nombre,u.nombre_usuario) as nombre_trabajador
		FROM pagos p
		INNER JOIN pedidos pp on pp.id_pedido = p.id_pedido
		LEFT JOIN cat_clientes c on c.id_cliente = pp.id_cliente
		LEFT JOIN cat_trabajadores t on t.id_trabajador = p.id_trabajador
		LEFT JOIN cat_usuarios u on u.id_usuario = p.usercreador
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
		
		$id_trabajador_ruta = $Pedido['id_trabajador'];
		$id_trabajador = $Pedido['id_trabajador_ocacional'];
				
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
		$hora = date("H:i:s");      
		$datetime="$fecha $hora";
		$fecha=date('Y-m-d H:i:s',strtotime($datetime));
		
		
		$id_trabajador = $Asignacion['id_trabajador'];
		$id_producto = $Asignacion['id_producto'];
		
		
		//verificar si la lavadora se encuentra ya asignada a un trabajador o se encuentra rentada y no permitir asignar de nuevo
		
		$query = "select count(id_asignacion) as totalrows  FROM asignadas WHERE id_producto = $id_producto AND status_asignacion in (1,3)";
        $res = mysqlQuery($query);
        if (!$res)
            throw new Exception(mysqli_error() . " " . $query);
		
        $resultado = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $totalRows = $resultado['totalrows'];
		
		if($totalRows > 0)
			throw new Exception("El producto ya se encuentra asignada o se encuentra rentada");	
		
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
		$plazo_pago = $Pedido['plazo_pago'];
		$fechaUltVenc = $Pedido['fecha_ultimo_vencimiento'];
		$datetimeUltVenc="$fechaUltVenc 00:00:00";
		$fechaUltVenc=date('Y-m-d H:i:s',strtotime($datetimeUltVenc));
				
		
		$precio_renta = $Pedido['precio_renta'];
		$observaciones = $Pedido['observaciones'];
		$fecha_ultimo_pago = $Pedido['fecha_ultimo_pago'];
		$id_trabajador = $Pedido['id_trabajador'];
		$id_trabajador_ocacional = $Pedido['id_trabajador_ocacional'];
		$id_trabajador_ocacional_old = $Pedido['id_trabajador_ocacional_old'];
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
		
		if (is_numeric($id_trabajador_ocacional)){	
			$query.=",id_trabajador_ocacional='".$id_trabajador_ocacional."'";
		}
		
		if (is_numeric($id_producto)){	
			$query.=",id_producto='".$id_producto."'";
		}
		/*
		if ($dias_extra > 0){	
			$query.=",fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,".$dias_extra.")";
		}		
		*/
		if (is_numeric($plazo_pago)){	
			$query.=",plazo_pago='".$plazo_pago."'";
		}
		$query.=",fecha_ultimo_pago='".$fecha_ultimo_pago."'";
		$query.=",fecha_entrega='".$fecha."'";
		$query.=",fecha_ultimo_vencimiento='".$fechaUltVenc."'";
		/*$query.=",status_renta=1";*/
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
		
		if($id_trabajador_ocacional_old > 0 && ($id_asignacion > 0 && $id_trabajador_ocacional <> $id_trabajador_ocacional_old)){
			$queryA="UPDATE asignadas SET id_trabajador = $id_trabajador_ocacional WHERE id_asignacion = $id_asignacion; ";
			$this->update($queryA);
		}else if($id_asignacion > 0 && ($id_asignacion_nueva > 0 && $id_asignacion <> $id_asignacion_nueva)){
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
		$query.=",origen=1";	
		
        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_pago;
		}
		
		/* Actualizar tabla pedidos con los datos del pago agregado, actualizar fecha vencimiento y ultimo pago*/
		
	
		
		$consulta="SELECT p.precio_renta,p.fecha_ultimo_vencimiento,p.plazo_pago
			FROM pedidos p
			WHERE p.id_pedido = {$id_pedido}";
			
		$resultado= mysqlQuery($consulta);
				
		
		 $reg = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$fecha_ultimo_vencimiento=$reg['fecha_ultimo_vencimiento'];
		$plazo_pago=$reg['plazo_pago'];
		$dias = 0;
		switch ($plazo_pago) {
			case 1:
				$dias = 7;
				break;
			case 2:
				$dias = 1;
				break;
			case 3:
				$dias = 2;
				break;
			case 4:
				$dias = 3;
				break;
		}	
		
		//actualizo la ultima fecha de pago, tambien debo actualizar la ultima fecha de pago y fecha_ultimo vencimiento que es la fecha de pago mas los dias de renta ,fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias})
		$consulta="UPDATE pedidos SET fecha_ultimo_pago=now(),fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias}),
		status_renta = 1,id_ultimo_pago={$id},Observaciones='' WHERE id_pedido={$id_pedido}";
		$this->update($consulta);     
		
		
		$data=$this->getpago($id);   
        
		
		
		 return $data['Pago'];
                     

    }
	
	public function eliminarpago($params){
			
		$idValue=$params['id_pago'];
   
		
		$query="UPDATE pagos SET status='I' WHERE id_pago=$idValue";
        $result=mysqlQuery($query);
        $response=array();
		$data=array(
			'id_asignacion'=>$idValue
		);
		
		
		
		//selecciono el id_pedido para actualizar los datos del ultimo pago activo
		$consulta="SELECT p.id_pedido
			FROM pagos p
			WHERE p.id_pago = {$idValue}";
			
		$resultado= mysqlQuery($consulta);
				
		
		$reg = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$id_pedido=$reg['id_pedido'];
		
		//busco el ultimo pago activo
		$consulta="SELECT p.id_pago,p.fecha_pago FROM pagos p WHERE p.id_pedido = {$id_pedido} AND status='A' ORDER by p.fecha_pago DESC LIMIT 1";
			
		$resultado= mysqlQuery($consulta);		
		$reg = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$id_pago=$reg['id_pago'];
		$fecha_pago=$reg['fecha_pago'];
		
		//buscar el pedido para obtener el plazo
		$consulta="SELECT p.fecha_ultimo_vencimiento,p.plazo_pago
			FROM pedidos p
			WHERE p.id_pedido = {$id_pedido}";
			
		$resultado= mysqlQuery($consulta);
				
		
		$reg = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		//$fecha_ultimo_vencimiento=$reg['fecha_ultimo_vencimiento'];
		$plazo_pago=$reg['plazo_pago'];
		$dias = 0;
		switch ($plazo_pago) {
			case 1:
				$dias = -7;
				break;
			case 2:
				$dias = -1;
				break;
			case 3:
				$dias = -2;
				break;
			case 4:
				$dias = -3;
				break;
		}	
		
		
		
		
		$consulta="UPDATE pedidos SET fecha_ultimo_pago='{$fecha_pago}',fecha_ultimo_vencimiento=ADDDATE(fecha_ultimo_vencimiento,{$dias}),
		id_ultimo_pago={$id_pago} WHERE id_pedido={$id_pedido}";
		$this->update($consulta); 
		
		
		
        return true;
		
	}

	
	public function getpedido($IDValue){	
		 $query = "SELECT p.id_pedido,p.id_trabajador,t.nombre as nombre_trabajador,p.id_trabajador_ocacional,t.nombre as nombre_trabajador_ocacional,p.numero_recibo,DATE_FORMAT(p.fecha_entrega,'%d/%m/%Y') as fecha_entrega,DATE_FORMAT(p.fecha_entrega,'%h:%i %p') as hora_entrega,DATE_FORMAT(p.fecha_ultimo_vencimiento,'%d/%m/%Y') as fecha_ultimo_vencimiento, DATE_FORMAT(p.fecha_ultimo_pago,'%d/%m/%Y') as fecha_ultimo_pago, p.precio_renta, p.plazo_pago, p.observaciones, c.nombre as nombre_cliente,p.dias_extra,p.id_producto, a.id_asignacion  
		 FROM $this->useTable p ";
		 $query .= " LEFT JOIN cat_trabajadores t on t.id_trabajador = p.id_trabajador";
		  $query .= " LEFT JOIN cat_trabajadores t2 on t2.id_trabajador = p.id_trabajador_ocacional";
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
