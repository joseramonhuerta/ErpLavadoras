/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.3.32-MariaDB : Database - user_nuevooriente
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`user_` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `asignadas` */

DROP TABLE IF EXISTS `asignadas`;

CREATE TABLE `asignadas` (
  `id_asignacion` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `id_trabajador` BIGINT(20) DEFAULT NULL,
  `id_producto` BIGINT(20) DEFAULT NULL,
  `fecha` DATETIME DEFAULT NULL,
  `status_asignacion` TINYINT(1) DEFAULT 1 COMMENT '1=Asignada a trabajador,2=En bodega,3=Entregada al cliente',
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  `id_pedido` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id_asignacion`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `cat_clientes` */

DROP TABLE IF EXISTS `cat_clientes`;

CREATE TABLE `cat_clientes` (
  `id_cliente` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) DEFAULT NULL,
  `calle` VARCHAR(200) DEFAULT NULL,
  `colonia` VARCHAR(100) DEFAULT NULL,
  `cp` VARCHAR(5) DEFAULT NULL,
  `curp` VARCHAR(20) DEFAULT NULL,
  `num_credencial` VARCHAR(50) DEFAULT NULL,
  `telefono1` VARCHAR(20) DEFAULT NULL,
  `telefono2` VARCHAR(20) DEFAULT NULL,
  `celular` VARCHAR(20) DEFAULT NULL,
  `correo` VARCHAR(50) DEFAULT NULL,
  `usuario` VARCHAR(20) DEFAULT NULL,
  `pass` VARCHAR(20) DEFAULT NULL,
  `id_ruta` BIGINT(20) DEFAULT NULL,
  `status` CHAR(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `cat_clientes_electronica` */

DROP TABLE IF EXISTS `cat_clientes_electronica`;

CREATE TABLE `cat_clientes_electronica` (
  `id_cliente` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` VARCHAR(255) DEFAULT NULL,
  `celular` VARCHAR(10) DEFAULT NULL,
  `direccion` VARCHAR(255) DEFAULT NULL,
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

/*Table structure for table `cat_modulos` */

DROP TABLE IF EXISTS `cat_modulos`;

CREATE TABLE `cat_modulos` (
  `id_modulo` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `cat_productos` */

DROP TABLE IF EXISTS `cat_productos`;

CREATE TABLE `cat_productos` (
  `id_producto` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `codigo_barra` VARCHAR(20) DEFAULT NULL,
  `descripcion` VARCHAR(200) DEFAULT NULL,
  `precio` DECIMAL(14,2) DEFAULT NULL,
  `status` CHAR(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `cat_rutas` */

DROP TABLE IF EXISTS `cat_rutas`;

CREATE TABLE `cat_rutas` (
  `id_ruta` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(200) DEFAULT NULL,
  `status` CHAR(1) DEFAULT NULL COMMENT 'A=Activo, I=Inactivo',
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_ruta`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `cat_trabajadores` */

DROP TABLE IF EXISTS `cat_trabajadores`;

CREATE TABLE `cat_trabajadores` (
  `id_trabajador` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) DEFAULT NULL,
  `direccion` VARCHAR(200) DEFAULT NULL,
  `curp` VARCHAR(20) DEFAULT NULL,
  `num_credencial` VARCHAR(50) DEFAULT NULL,
  `telefono1` VARCHAR(20) DEFAULT NULL,
  `telefono2` VARCHAR(20) DEFAULT NULL,
  `celular` VARCHAR(20) DEFAULT NULL,
  `tipo` TINYINT(1) DEFAULT NULL COMMENT '1=Chofer,2=Cobrador,3=tecnico',
  `id_ruta` BIGINT(20) DEFAULT NULL,
  `status` CHAR(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_trabajador`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `cat_usuarios` */

DROP TABLE IF EXISTS `cat_usuarios`;

CREATE TABLE `cat_usuarios` (
  `id_usuario` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(150) NOT NULL,
  `usuario` VARCHAR(100) NOT NULL,
  `pass` VARCHAR(255) NOT NULL,
  `correo` VARCHAR(200) DEFAULT NULL,
  `rol` TINYINT(1) DEFAULT NULL COMMENT '1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super',
  `id_trabajador` BIGINT(20) DEFAULT NULL,
  `app_lavadoras` TINYINT(1) DEFAULT 1,
  `app_ordenes_servicio` TINYINT(1) DEFAULT 1,
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  `status` CHAR(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  PRIMARY KEY (`id_usuario`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `cat_usuarios_modulos` */

DROP TABLE IF EXISTS `cat_usuarios_modulos`;

CREATE TABLE `cat_usuarios_modulos` (
  `id_usuario_modulo` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `id_usuario` BIGINT(20) NOT NULL,
  `id_modulo` BIGINT(20) NOT NULL,
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_usuario_modulo`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `gastos` */

DROP TABLE IF EXISTS `gastos`;

CREATE TABLE `gastos` (
  `id_gasto` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME DEFAULT NULL,
  `concepto` VARCHAR(200) DEFAULT NULL,
  `importe` DECIMAL(14,2) DEFAULT NULL,
  `status` CHAR(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_gasto`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `ordenes_servicio` */

DROP TABLE IF EXISTS `ordenes_servicio`;

CREATE TABLE `ordenes_servicio` (
  `id_orden_servicio` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `fecha` DATE DEFAULT NULL,
  `nombre_cliente` VARCHAR(200) DEFAULT NULL,
  `celular` VARCHAR(10) DEFAULT NULL,
  `nombre_equipo` VARCHAR(100) DEFAULT NULL,
  `modelo_equipo` VARCHAR(50) DEFAULT NULL,
  `serie_equipo` VARCHAR(50) DEFAULT NULL,
  `descripcion_falla` VARCHAR(255) DEFAULT NULL,
  `ruta_imagen` VARCHAR(255) DEFAULT NULL,
  `nombre_imagen` VARCHAR(100) DEFAULT NULL,
  `descripcion_diagnostico` VARCHAR(255) DEFAULT NULL,
  `nombre_tecnico` VARCHAR(100) DEFAULT NULL,
  `descripcion_reparacion` VARCHAR(255) DEFAULT NULL,
  `importe_presupuesto` DECIMAL(18,2) DEFAULT 0.00,
  `status_servicio` TINYINT(1) DEFAULT 0 COMMENT '0=Recibido,1=Revision,2=Cotizacion,3=Reparacion,4=Reparado,5=Entregado,6=Devolucion',
  `token` VARCHAR(255) DEFAULT NULL,
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  `imagen` LONGTEXT DEFAULT NULL,
  `id_tecnico` BIGINT(20) DEFAULT NULL,
  `id_cliente` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id_orden_servicio`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `pagos` */

DROP TABLE IF EXISTS `pagos`;

CREATE TABLE `pagos` (
  `id_pago` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `id_pedido` BIGINT(20) DEFAULT NULL,
  `id_trabajador` BIGINT(20) DEFAULT NULL,
  `fecha_pago` DATETIME DEFAULT NULL,
  `importe` DECIMAL(14,2) DEFAULT NULL,
  `status` CHAR(1) DEFAULT 'A',
  `origen` TINYINT(1) DEFAULT 0 COMMENT '1=Sistema Web,2=Aplicacion',
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_pago`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `pedidos` */

DROP TABLE IF EXISTS `pedidos`;

CREATE TABLE `pedidos` (
  `id_pedido` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `id_cliente` BIGINT(20) DEFAULT NULL,
  `id_trabajador` BIGINT(20) DEFAULT NULL,
  `fecha_entrega` DATETIME DEFAULT NULL,
  `plazo_pago` TINYINT(1) DEFAULT NULL,
  `id_ruta` BIGINT(20) DEFAULT NULL,
  `id_trabajador_ocacional` BIGINT(20) DEFAULT NULL,
  `referencia` VARCHAR(200) DEFAULT NULL,
  `observaciones` TEXT DEFAULT NULL,
  `fecha_ultimo_vencimiento` DATETIME DEFAULT NULL,
  `fecha_ultimo_pago` DATETIME DEFAULT NULL,
  `id_producto` BIGINT(20) DEFAULT NULL,
  `precio_renta` DECIMAL(14,2) DEFAULT NULL,
  `numero_recibo` VARCHAR(50) DEFAULT NULL,
  `fecha_entrega_cliente` DATETIME DEFAULT NULL,
  `fecha_recogida` DATETIME DEFAULT NULL,
  `dias_extra` INT(11) DEFAULT 0,
  `status` CHAR(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `status_pedido` TINYINT(1) DEFAULT 0 COMMENT '0=Pendiente,1=Rentada,2=Cobrada,3=Recogida',
  `status_renta` TINYINT(1) DEFAULT 1 COMMENT '1=Sin Pendiente,2=Vencida/Pendiente de Pago',
  `id_ultimo_pago` BIGINT(20) DEFAULT NULL,
  `usercreador` BIGINT(20) DEFAULT NULL,
  `fechacreador` DATETIME DEFAULT NULL,
  `usermodif` BIGINT(20) DEFAULT NULL,
  `fechamodif` DATETIME DEFAULT NULL,
  `origen` TINYINT(1) DEFAULT 1 COMMENT '1=sistema,2=aplicacion',
  `autorizada` TINYINT(1) DEFAULT 1 COMMENT '0=No autorizada,1=autorizada',
  PRIMARY KEY (`id_pedido`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `ActualizaStatusRenta` */

/*!50106 DROP EVENT IF EXISTS `ActualizaStatusRenta`*/;

DELIMITER $$

/*!50106 CREATE DEFINER=`user_ramon`@`%` EVENT `ActualizaStatusRenta` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-08-20 13:27:49' ON COMPLETION PRESERVE ENABLE DO BEGIN
	    UPDATE pedidos SET status_renta = 2 WHERE status_pedido = 1 AND DATE(ADDDATE(fecha_ultimo_vencimiento, CASE plazo_pago WHEN 1 THEN 7 WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 3 END)) <= CURDATE();
	END */$$
DELIMITER ;

/* Procedure structure for procedure `spReporteInventario` */

/*!50003 DROP PROCEDURE IF EXISTS  `spReporteInventario` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`user_ramon`@`%` PROCEDURE `spReporteInventario`(V_id_producto BIGINT)
BEGIN
	DROP TEMPORARY TABLE IF EXISTS tmpProductos;
	
	CREATE TEMPORARY TABLE tmpProductos( 
		id_producto BIGINT,
		status_asignacion INT /*1=venta, 2= mov*/
	);
	
	INSERT INTO tmpProductos(id_producto,status_asignacion)
	SELECT id_producto,2 FROM cat_productos p WHERE p.status = 'A'
	ORDER BY p.id_producto;
	
		
	IF V_id_producto > 0 THEN
		DELETE FROM tmpProductos WHERE id_producto <> V_id_producto;
	END IF;					
	
	
	UPDATE 	tmpProductos p
	SET status_asignacion = IFNULL((SELECT status_asignacion FROM asignadas a WHERE p.id_producto = a.id_producto
	ORDER BY fecha DESC LIMIT 1),2);
		
	SELECT p.codigo_barra,p.descripcion,CASE tmp.status_asignacion WHEN 1 THEN 'ASIGNADA A TRABAJADOR' WHEN 2 THEN 'EN BODEGA' WHEN 3 THEN 'RENTADA' END AS asignacion  FROM 	tmpProductos tmp
	INNER JOIN cat_productos p ON p.id_producto = tmp.id_producto
	ORDER BY tmp.status_asignacion DESC,p.descripcion;	
	
	
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
