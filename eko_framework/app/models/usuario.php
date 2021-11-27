<?php

class UsuarioModel extends Model{
    var $useTable = 'cat_usuarios';
    var $name='Usuario';
    var $primaryKey = 'id_usuario';
    var $specific = true;
    var $camposAfiltrar = array('nombre_usuario','usuario');


    
    function readAll($start, $limit, $filtro, $filtroStatus) {
        
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

        $query = "SELECT id_usuario,  nombre_usuario, usuario,from_base64(pass) AS pass,correo, rol, status,id_trabajador,app_lavadoras,app_ordenes_servicio FROM $this->useTable
                $filtroSql ORDER BY id_usuario limit $start,$limit ;";

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
		 		
		$User = $params['Usuario'];
		$id_usuario = $User['id_usuario'];		
		$nombre_usuario = $User['nombre_usuario'];		
		$usuario = $User['usuario'];
		$pass = $User['pass'];
		$correo = $User['correo'];
		$rol = $User['rol'];
		$app_lavadoras = $User['app_lavadoras'];
		$app_ordenes_servicio = $User['app_ordenes_servicio'];
		$id_trabajador = $User['id_trabajador'];
		
        if($id_usuario > 0){
			$query="UPDATE $this->useTable SET ";
            
            $query.="usermodif=$IDUsu";    //LOG
            $query.=",fechamodif=now()";
            $where=" WHERE $this->primaryKey = ".$id_usuario;
        }else{  //INSERT
            $query="INSERT INTO $this->useTable SET ";
            $query.="usercreador=$IDUsu";    //LOG
            $query.=",fechacreador=now()";
          
            $registroNuevo=true;
			$where='';
        }
        	
		
		if (is_numeric($rol)){	
			$query.=",rol='".$rol."'";
		}
		
		if (is_numeric($id_trabajador)){	
			$query.=",id_trabajador='".$id_trabajador."'";
		}
		
		if (is_numeric($app_lavadoras)){	
			$query.=",app_lavadoras='".$app_lavadoras."'";
		}
		
		if (is_numeric($app_ordenes_servicio)){	
			$query.=",app_ordenes_servicio='".$app_ordenes_servicio."'";
		}
		
		$query.=",nombre_usuario='".$nombre_usuario."'";	

		$query.=",usuario='".$this->EscComillas($usuario)."'";
		$query.=",pass=to_base64('".$this->EscComillas($pass)."')";
		$query.=",correo='".$this->EscComillas($correo)."'";		
		

        $query=$query.$where;
		 
		if ($registroNuevo){            
			$id= $this->insert($query); 			
			
		}else{		
			$result=$this->update($query);               
			$id=$id_usuario;
		}
		
		$data=$this->getusuario($id);   
        
		
		
		 return $data['Usuario'];
                     

    }
	
	public function getusuario($IDValue){
		
		 $query = "SELECT id_usuario,  nombre_usuario, usuario,from_base64(pass) AS pass,correo, rol, status,id_trabajador,app_lavadoras,app_ordenes_servicio FROM $this->useTable
         WHERE id_usuario = $IDValue ;";
			
		
		$arrUsuario= $this->select($query);
		return array('Usuario'=>$arrUsuario[0]);
		
		
	}
	
	public function delete($id){
		$sqlDelete="DELETE FROM  $this->useTable WHERE id_usuario = $id ";
		return $this->queryDelete($sqlDelete);	
        //return parent::delete($id);
    }
	/*
	public function validarpermisomodulo($params){
		$id_usuario = $params['id_usuario'];		
		$id_modulo = $params['id_modulo'];	
		$rol = $params['rol'];
		
		$conPermiso = false;		
		
		if($rol == 1){
			$conPermiso = true;		
		}else{
			$query="SELECT um.id_usuario_modulo FROM cat_usuarios_modulos um 
				INNER JOIN cat_usuarios u on u.id_usuario = um.id_usuario
				INNER JOIN cat_modulos m on m.id_modulo = um.id_modulo
			WHERE um.id_usuario={$id_usuario} AND um.id_modulo={$id_modulo} AND u.status = 'A';";
			$arrayResult= $this->select($query);
			
			
			if (sizeof($arrayResult)>0){
				$conPermiso = true;	
			}else{
				$conPermiso = false;	
			}		
			
		}
		
		return $conPermiso;
		
		
		
	}
	*/
}
?>
