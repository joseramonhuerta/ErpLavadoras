<?php

    $host = 'localhost';
     //$user = 'espaciom_cristan';
    //$password = 'kunashi1400';
	
	$user = 'root';
    $password = '';
    $db = 'espaciom_nuevoOriente';

    $conection = @mysqli_connect($host,$user,$password,$db);

    

    if(!$conection){
    	echo "Error en la conexion";
    }

?>