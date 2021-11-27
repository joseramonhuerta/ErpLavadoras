<?php
/*
 * Devuelve las rutas de los archivos javascript para el proyecto
 *  var $modoProduccion:
 *  indica si los archivos son para modo produccion o para el modo de desarrollo.
 * ----Produccion:
 *  A la ruta del JS le agrega '../' al inicio
 *  Te da la ruta para ext-all en lugar de ext-all-debug
 *
 *---- Desarrollo:
 *  te da la ruta de ext-all-debug en lugar de ext-all
 */
function getJsFiles($modoProduccion=true){
    $arrayFiles=Array();
	$arrayFiles[]="js/funciones.js";	  
		  
      $arrayFiles[]="js/administracion/comun/encoder.js";	  
      $arrayFiles[]="js/FusionWidgets_Enterprise/JSClass/FusionCharts.js";
      
    #----------------------FIREBUG------------------------------------
     
    if (!$modoProduccion){
 //       $arrayFiles[]="https://getfirebug.com/firebug-lite.js";
    }
    #----------------------LIBRERIAS EXTJS------------------------------------
    $arrayFiles[]="js/ext-3.4.0/adapter/ext/ext-base.js";    
    if ($modoProduccion){
        //$arrayFiles[]="js/ext-3.4.0/ext-all.js";      
        $arrayFiles[]="js/ext-3.4.0/ext-all-debug.js";  
    }else{        
        $arrayFiles[]="js/ext-3.4.0/ext-all-debug.js";
    }

    $arrayFiles[]="js/ext-3.4.0/src/locale/ext-lang-es.js";     //<---Idioma al español
	$arrayFiles[]="js/ext-ux/fixed_opera_vtype_bug.js";
    #----------------------MENSAJES EN LA BARRA SUPERIOR------------------------------------#
      $arrayFiles[]="js/app.js";
    #----------------------CREAR ESTILOS AL VUELO-------------------------------------------#	
    $arrayFiles[]="js/ext-ux/Ext.ux.TDGi.js";
    #----------------------        FORMATOS      -------------------------------------------#
    $arrayFiles[]="js/ext-ux/formatos.js";
    #----------------------        MENSAJES      -------------------------------------------#
    $arrayFiles[]="js/ext-ux/mensajes.js";
    #---------------------- TIPOS DE CANTIDAD Y MONEDA--------------------------------------#
    $arrayFiles[]="js/ext-ux/CantidadField.js";
    $arrayFiles[]="js/ext-ux/MonedaField.js";
    #----------------------         FILE UPLOADER           --------------------------------------#
   $arrayFiles[]="js/ext-ux/fileUploadField.js";
	// $arrayFiles[]="js/ext-ux/fileUploadField2.js";
    #----------------------         BOTON ELIMINAR           --------------------------------------#
    $arrayFiles[]="js/ext-ux/BotonEliminar.js";
    $arrayFiles[]="js/ext-ux/BotonesActivarDesactivar.js";
    #----------------------         CHECK COLUMN           --------------------------------------#
    $arrayFiles[]="js/ext-ux/gridCheckColumn.js";
    #----------Grid add column-----------------#
    $arrayFiles[]="js/ext-ux/grid_addcolumn.js";
    #----------SUPERBOX-----------------#
   // $arrayFiles[]="js/ext-ux/SuperBoxSelect/SuperBoxSelect.js";
   // <script type = "text/javascript" src= "js/jquery/jquery-1.4.1.js"> </script>
     #----------JQUERY 1.4.1-----------------#
    $arrayFiles[]="js/jquery/jquery-1.4.1.js";
    
    if ($modoProduccion){
        $arrayFiles[]="js/ext-ux/escape.js";
    }else{
        $arrayFiles[]="js/ext-ux/noescape.js";
    }
    #----------------------         COMUN           --------------------------------------#
    
    $arrayFiles[]="js/lib/eko_grid.js";
    $arrayFiles[]="js/administracion/comun/combo_negocios.js";
    $arrayFiles[]="js/ext-ux/BotonesStatus.js";
    $arrayFiles[]="js/administracion/comun/RFC_TextField.js";
    $arrayFiles[]="js/administracion/comun/grid_buscador.js";
    $arrayFiles[]="js/administracion/comun/comun_grid_buscador.js";
    $arrayFiles[]="js/administracion/comun/comun_form_edicion.js";
    $arrayFiles[]="js/administracion/comun/form_edicion.js";
    $arrayFiles[]="js/administracion/comun/panel_edicion.js";
    $arrayFiles[]="js/administracion/comun/basic_toolbar.js";
    $arrayFiles[]="js/administracion/comun/toolbar_buscador_basico.js";
    $arrayFiles[]="js/administracion/comun/toolbar_buscador_activos.js";
    $arrayFiles[]="js/administracion/comun/combo_ciudades.js";
    $arrayFiles[]="js/administracion/comun/tab_panel.js";
	
	
	
	//------------------          Main		     ------------------//
	$arrayFiles[]="js/administracion/main/Main.ui.js";
	$arrayFiles[]="js/administracion/main/Main.js";
	
	
	//------------------          Form Usuarios		     ------------------//
	$arrayFiles[]="js/administracion/usuarios/formUsuarios.ui.js";
	$arrayFiles[]="js/administracion/usuarios/formUsuarios.js";
	$arrayFiles[]="js/administracion/usuarios/storeGridUsuario.js";
	$arrayFiles[]="js/administracion/usuarios/storeRol.js";
	$arrayFiles[]="js/administracion/usuarios/storeStatus.js";
	$arrayFiles[]="js/administracion/usuarios/storeTrabajadores.js";
	$arrayFiles[]="js/administracion/usuarios/storeSiNo.js";
	
	//------------------          Form Clientes		     ------------------//
	$arrayFiles[]="js/administracion/clientes/formClientes.ui.js";
	$arrayFiles[]="js/administracion/clientes/formClientes.js";
	$arrayFiles[]="js/administracion/clientes/storeGridCliente.js";
	$arrayFiles[]="js/administracion/clientes/storeRuta.js";
	$arrayFiles[]="js/administracion/clientes/storeStatus.js";
	
	//------------------          Form Trabajadores		     ------------------//
	$arrayFiles[]="js/administracion/trabajadores/formTrabajadores.ui.js";
	$arrayFiles[]="js/administracion/trabajadores/formTrabajadores.js";
	$arrayFiles[]="js/administracion/trabajadores/storeGridTrabajador.js";
	$arrayFiles[]="js/administracion/trabajadores/storeRuta.js";
	$arrayFiles[]="js/administracion/trabajadores/storeStatus.js";
	$arrayFiles[]="js/administracion/trabajadores/storeTipo.js";
	
	
	//------------------          Form Productos		     ------------------//
	$arrayFiles[]="js/administracion/productos/formProductos.ui.js";
	$arrayFiles[]="js/administracion/productos/formProductos.js";
	$arrayFiles[]="js/administracion/productos/storeGridProducto.js";
	$arrayFiles[]="js/administracion/productos/storeStatus.js";

	
	//------------------          Form Pedidos		     ------------------//
	$arrayFiles[]="js/administracion/pedidos/formPedidos.ui.js";
	$arrayFiles[]="js/administracion/pedidos/formPedidos.js";
	$arrayFiles[]="js/administracion/pedidos/storeFormPedidosClientes.js";
	$arrayFiles[]="js/administracion/pedidos/storeFormPedidosRuta.js";
	$arrayFiles[]="js/administracion/pedidos/storeFormPedidosPlazoPagos.js";
	$arrayFiles[]="js/administracion/pedidos/storeFormPedidosTrabajadores.js";
	$arrayFiles[]="js/administracion/pedidos/storeFormPedidosTrabajadoresPorRuta.js";
	
	$arrayFiles[]="js/administracion/pedidos/storeGridPedidos.js";
	$arrayFiles[]="js/administracion/pedidos/formPedidosWindow.ui.js";
	$arrayFiles[]="js/administracion/pedidos/formPedidosWindow.js";
	
	//------------------          Form Asignacion		     ------------------//
	$arrayFiles[]="js/administracion/asignacion/formAsignacion.ui.js";
	$arrayFiles[]="js/administracion/asignacion/formAsignacion.js";
	$arrayFiles[]="js/administracion/asignacion/storeFormAsignacionTrabajadores.js";
	$arrayFiles[]="js/administracion/asignacion/storeFormAsignacionProductos.js";
	$arrayFiles[]="js/administracion/asignacion/storeGridAsignacion.js";
	
	//------------------          Form Rentas		     ------------------//
	$arrayFiles[]="js/administracion/rentas/formRentas.ui.js";
	$arrayFiles[]="js/administracion/rentas/formRentas.js";
	$arrayFiles[]="js/administracion/rentas/storeFormRentasClientes.js";
	$arrayFiles[]="js/administracion/rentas/storeFormRentasTrabajadores.js";
	$arrayFiles[]="js/administracion/rentas/storeGridRentas.js";
	$arrayFiles[]="js/administracion/rentas/formRentasWindow.ui.js";
	$arrayFiles[]="js/administracion/rentas/formRentasWindow.js";
	$arrayFiles[]="js/administracion/rentas/formRentasPagosWindow.ui.js";
	$arrayFiles[]="js/administracion/rentas/formRentasPagosWindow.js";
	$arrayFiles[]="js/administracion/rentas/formRentasGridPagosWindow.ui.js";
	$arrayFiles[]="js/administracion/rentas/formRentasGridPagosWindow.js";
	$arrayFiles[]="js/administracion/rentas/storeGridRentasPagos.js";
	$arrayFiles[]="js/administracion/rentas/storeGridRentasProductos.js";
	$arrayFiles[]="js/administracion/rentas/formRentasDiasExtraWindow.ui.js";
	$arrayFiles[]="js/administracion/rentas/formRentasDiasExtraWindow.js";
	$arrayFiles[]="js/administracion/rentas/storeFormRentasPlazoPagos.js";
	
	
	//------------------          Form Reporte Rentas		     ------------------//
	$arrayFiles[]="js/administracion/reportes/formReporteRentas/formReporteRentas.ui.js";
	$arrayFiles[]="js/administracion/reportes/formReporteRentas/formReporteRentas.js";
	$arrayFiles[]="js/administracion/reportes/formReporteRentas/storeFormReporteRentasClientes.js";
	$arrayFiles[]="js/administracion/reportes/formReporteRentas/storeFormReporteRentasTrabajadores.js";
	
	//------------------          Form Gastos		     ------------------//
	$arrayFiles[]="js/administracion/gastos/formGastos.ui.js";
	$arrayFiles[]="js/administracion/gastos/formGastos.js";
	$arrayFiles[]="js/administracion/gastos/storeGridGastos.js";
	$arrayFiles[]="js/administracion/gastos/storeStatus.js";
	
	//------------------          Form Reporte Gastos		     ------------------//
	$arrayFiles[]="js/administracion/reportes/formReporteGastos/formReporteGastos.ui.js";
	$arrayFiles[]="js/administracion/reportes/formReporteGastos/formReporteGastos.js";

	//------------------          Form Reporte Inventario		     ------------------//
	$arrayFiles[]="js/administracion/reportes/formReporteInventario/formReporteInventario.ui.js";
	$arrayFiles[]="js/administracion/reportes/formReporteInventario/formReporteInventario.js";
	$arrayFiles[]="js/administracion/reportes/formReporteInventario/storeFormReporteInventarioProductos.js";
	
	
	$arrayFiles[]="js/administracion/inicio.js";
    if ($modoProduccion){	
        for($i=0 ; $i<sizeof($arrayFiles) ;$i++){
            $arrayFiles[$i]='../'.$arrayFiles[$i]; //POR LA RUTA DEL SCRIPT DEL COMPRESOR
        }
    }
    return $arrayFiles;
}
?>