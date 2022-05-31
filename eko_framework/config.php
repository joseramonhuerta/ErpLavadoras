<?php


/*===	DEFINIR PAR�METROS POR DEFAULT PARA EL CASO DE NO EXISTIR DATOS EN LA BASE DE DATOS			*/
define("LIMITE_EN_PAGINACION",	  50);		//	Numero de registros por p�gina para los grids
/* 	Revisar:	la ruta a los css de los temas deberia estar en una tabla o en un archivo de configuracion			*/
define("TEMA",					 'B');		//	A:AZUL, B:GRIS...

define("FORMATO_DE_TEXTO",		 '0');	


/* valores disponibles para el formato de texto:
	0=TEXTO SIN FORMATO									
      1=TEXTO EN MAY�SCULAS							
	  2=texto en min�sculas								
	  3=El Texto Es Capitalizado		
*/

//======   DEFINE ZONA HORARIA    =======//

define("CUSTOM_TIMEZONE", 'America/Mazatlan');
date_default_timezone_set (CUSTOM_TIMEZONE);

/*  =========================================================================
	DEFINE EL MENSAJE A MOSTRAR EN CASO DE QUE UN COMANDO MySQL FALLE
	0= Sin Degub: 	CAMBIA LOS MENSAJES DE MySQL POR MENSAJES PARA USUARIOS
	1= Con Debug:	MUESTRA LOS MENSAJES DE ERROR DE MySQL Y LA CONSULTA SQL
    =========================================================================*/
define("SQL_DEBUG", '1');	

//=========================================================================
/*
define("DB_HOST", "localhost");
define("DB_USER", "user_cristian");
define("DB_PASS", "kunashi1400");
define("DB_NAME", "user_nuevooriente");		
define("DB_MASTER", "user_nuevooriente");	
*/
/*
$database="user_nuevooriente";
$username="user_cristian";
$password="kunashi1400";
*/
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "user_lavadoras_pruebas");		
define("DB_MASTER", "user_lavadoras_pruebas");	
	

// define("DB_LICENCIAS", "db_mifactura");
define("MASTER", "user_lavadoras_pruebas");
?>