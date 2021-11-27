/*
 * File: mfw.almacenes.storeFormAsignacionTrabajadores.js
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.ns('eNuevoOriente');
eNuevoOriente.storeFormAsignacionTrabajadores = Ext.extend(Ext.data.JsonStore, {
    constructor: function(cfg) {
        cfg = cfg || {};
        eNuevoOriente.storeFormAsignacionTrabajadores.superclass.constructor.call(this, Ext.apply({
            storeId: 'storeFormAsignacionTrabajadores',
			autoDestroy: true,
			idProperty: 'id_trabajador',
			messageProperty: 'msg',
			url: 'app.php/pedidos/obtenertrabajadores',
            root: 'data',
			totalProperty: 'totalRows',
            fields:[{
						name: 'id_trabajador',
						type: 'int'
					},
					{
						name: 'nombre_trabajador',
						type: 'string'
					},
					{
						name: 'id_ruta',
						type: 'int'
					},
					{
						name: 'ruta',
						type: 'string'
					}
			]
        }, cfg));
    }
});
Ext.reg('storeFormAsignacionTrabajadores', eNuevoOriente.storeFormAsignacionTrabajadores);