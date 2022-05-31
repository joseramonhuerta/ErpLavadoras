<?php
declare(strict_types = 1);

$ROOT = $_SERVER['DOCUMENT_ROOT'];
$SERVER = $_SERVER['SERVER_NAME'];
$COMPONENTS = $ROOT.'/components';

require_once($ROOT.'/vendor/autoload.php');
require_once($ROOT.'/db_connect_class.php');

Mustache_Autoloader::register();
$mustache = new Mustache_Engine(array('entity_flags' => ENT_QUOTES));

$conexion = new Conexion();
