<?php
require ('eko_framework/app/models/login.php');       //MODELO
class Login extends ApplicationController {
    //var $uses=array('Login');
    var $components = array('Auth'=>array(
        'allowedActions'=>array('identificar')
    ));
     var $loginModel;
	 var $model='LoginModel';   
    
	 function  beforeAction() {
    //   echo "MODELO";
       $this->loginModel=new LoginModel();
        parent::beforeAction();
    }
	
    function identificar() {
        try{
            $response=array();
            $user=$_POST['username'];
            $pass=$_POST['pass'];
            $identificado=$this->loginModel->identificar($user, $pass);
     
            if ($identificado) {           
                $_SESSION['Auth']['User']['id_usuario'] = $identificado['id_usuario'];
                $_SESSION['Auth']['User']['usuario'] = $identificado['usuario'];		
                $_SESSION['Auth']['User']['nombre_usuario'] = $identificado['nombre_usuario'];
                $_SESSION['Auth']['User']['rol'] = $identificado['rol'];            
                $_SESSION['Auth']['User']['correo'] = $identificado['correo'];            
                
                $_SESSION['identificado']['rol'] = $identificado['rol'];
                $_SESSION['identificado']['id_usuario'] = $identificado['id_usuario'];
                $_SESSION['identificado']['usuario'] = $identificado['usuario'];	
                $_SESSION['identificado']['nombre_usuario'] = $identificado['nombre_usuario'];
                $_SESSION['identificado']['correo'] = $identificado['correo'];				
                $_SESSION['identificado']['identificado'] = true;
                
                $response['success']=true;	                
                
            } else {
                unset($_SESSION['identificado']);
            $response['success']=false;
            $response['msg']="El usuario o la contraseña son incorrectos";
            }
            
            return $response;
        }catch(Exception $e){
            $response['success'] = false;
            $response['msg'] = $e->getMessage();
            return $response;    
        }
        
    }
}
?>
