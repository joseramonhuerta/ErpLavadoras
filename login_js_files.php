<?php
function getJsFiles($modoProduccion=true){
    $arrayFiles=Array();
		
        $arrayFiles[]="js/ext-3.4.0/adapter/ext/ext-base.js";  
		$arrayFiles[]="js/ext-3.4.0/ext-all-debug.js";
	
      
        $arrayFiles[]="js/ext-3.4.0/src/locale/ext-lang-es.js";
        $arrayFiles[]="js/app.js";
        $arrayFiles[]="js/ext-ux/mensajes.js";
		$arrayFiles[]="js/ext-ux/fixed_opera_vtype_bug.js";
		
		$arrayFiles[]="js/login/main.ui.js";
		$arrayFiles[]="js/login/main.js";
		
		$arrayFiles[]="js/login/comportamiento_login.js";
		
		
	 if ($modoProduccion){
        for($i=0 ; $i<sizeof($arrayFiles) ;$i++){
            $arrayFiles[$i]='../'.$arrayFiles[$i]; //POR LA RUTA DEL SCRIPT DEL COMPRESOR
        }
    }
	
	return $arrayFiles;
}
	
?>