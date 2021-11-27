<?php

require 'eko_framework/app/models/pedido.php';
require_once 'eko_framework/lib/model.php';

// require 'eko_framework/app/models/certificado.php';
class Sistema extends ApplicationController{
     var $uses=array('Pedido');
	var $model="Model";
    var $components = array(
		'ACL'=>array(
        'allowedActions'=>array(
        	'verificasesion',
			'getParametros',
			'validarpermisomodulo'
    	)
		)
	);
	
	public function getParametros(){
		$parametros=array();
		
		$parametros['Parametros']['tipo_texto']	=FORMATO_DE_TEXTO;
		$parametros['Parametros']['ciudad_default']=CIUDAD_ID;
		$parametros['Parametros']['pais_default']=PAIS_ID;
		$parametros['Parametros']['estado_default']=ESTADO_ID;
		$parametros['Parametros']['registros_pagina']=LIMITE_EN_PAGINACION;
		
		$parametros['User']['id_usuario'] = $_SESSION['Auth']['User']['id_usuario'];
		$parametros['User']['nombre_usuario'] = $_SESSION['Auth']['User']['nombre_usuario'];
		$parametros['User']['correo'] = $_SESSION['Auth']['User']['correo'];
		$parametros['User']['rol'] = $_SESSION['Auth']['User']['rol'];
		
		$userConfig=array();
		$userConfig['forUsu']=$parametros['Parametros']['tipo_texto'];
		$userConfig['emaUsu']=$_SESSION['Auth']['User']['correo'];
		$userConfig['nomUsu']=$_SESSION['Auth']['User']['nombre_usuario'];
		$parametros['UserConfig'] = $userConfig;
		
		return $parametros;
	}
    
	public function verificasesion(){		
		try{
			$pedidoModel=new PedidoModel();			
			$pedidoModel->actualizastatusrentas();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());			
		}
		
		return true;
	}
	
	public function validarpermisomodulo(){	
		$params = $_POST;
			
		$id_usuario = $params['id_usuario'];		
		$id_modulo = $params['id_modulo'];	
		$rol = $params['rol'];
		
		//$conPermiso = false;		
		
		if($rol == 1 /*Administrador*/){
			$conPermiso = true;		
		}else{
			$query="SELECT um.id_usuario_modulo FROM cat_usuarios_modulos um 
				INNER JOIN cat_usuarios u on u.id_usuario = um.id_usuario
				INNER JOIN cat_modulos m on m.id_modulo = um.id_modulo
			WHERE um.id_usuario={$id_usuario} AND um.id_modulo={$id_modulo} AND u.status = 'A';";			
			
			$result= mysqlQuery($query);			
			
			if(mysqli_num_rows($result) > 0){				
				$conPermiso = true;					
			}else{
				$conPermiso = false;
			}
		}
		$response=array();
		$response['permiso']=$conPermiso;
		return $response;
	}
	
	
}
?>
