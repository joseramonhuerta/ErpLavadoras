/*
 * File: miErpWeb.storeGridAsignacion.js
 * Date: Wed May 25 2011 16:58:59 GMT-0600 (Hora verano, Montañas (México))
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.ns('eNuevoOriente');
eNuevoOriente.storeGridAsignacion = Ext.extend(Ext.data.JsonStore, {
    constructor: function(cfg) {
        cfg = cfg || {};
        eNuevoOriente.storeGridAsignacion.superclass.constructor.call(this, Ext.apply({
            storeId: 'storeGridAsignacion',
			idProperty: 'id_asignacion',
			messageProperty: 'msg',
            root: 'data',
			totalProperty: 'totalRows',
            fields:[
				{
                    name: 'id_asignacion'
                    
                },
				{
                    name: 'fecha',
                    type: 'string'
                },
				{
                    name: 'id_trabajador'
                    
                },				
				{
                    name: 'nombre_trabajador',
                    type: 'string'
                },
				{
                    name: 'id_producto'
                    
                },
				{
                    name: 'descripcion',
                    type: 'string'
                },
				{
                    name: 'status_asignacion',
                    type: 'string'
                }
				
			
			],
            url: 'app.php/pedidos/obtenerasignadas'
        }, cfg));
    }
});
Ext.reg('storeGridAsignacion', eNuevoOriente.storeGridAsignacion);