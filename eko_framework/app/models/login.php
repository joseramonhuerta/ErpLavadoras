<?php

class LoginModel extends Model{
    var $useTable = '';
    var $name='Login';
    var $primaryKey = '';
    var $specific = false;
    var $camposAfiltrar = array();


    
    public function identificar($user, $pass) {        
       try{
            $query="SELECT u.id_usuario as id_usuario,u.nombre_usuario as nombre_usuario,u.usuario,u.rol,u.correo FROM cat_usuarios u        
            WHERE u.usuario='$user' AND u.pass=to_base64('$pass');";
            //throw new Exception($query);
            $arrayResult=$this->query($query, DB_NAME);
            
            
            if (sizeof($arrayResult)>0){
                return $arrayResult[0];	
            }else{
                return array();
            }

        }catch(Exception $e){
            //throw new Exception($e->getMessage());
            return $e->getMessage();
        }
                 
    }

}
?>
