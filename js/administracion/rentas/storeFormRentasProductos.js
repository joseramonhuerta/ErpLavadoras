/*
 * File: mfw.almacenes.storeFormRentasProductos.js
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.ns('eNuevoOriente');
eNuevoOriente.storeFormRentasProductos = Ext.extend(Ext.data.JsonStore, {
    constructor: function(cfg) {
        cfg = cfg || {};
        eNuevoOriente.storeFormRentasProductos.superclass.constructor.call(this, Ext.apply({
            storeId: 'storeFormRentasProductos',
			autoDestroy: true,
			idProperty: 'id_producto',
			messageProperty: 'msg',
			url: 'app.php/pedidos/obtenerproductos',
            root: 'data',
			totalProperty: 'totalRows',
            fields:[{
						name: 'id_producto',
						type: 'int'
					},{
						name: 'descripcion',
						type: 'string'
					},
					{
						name: 'codigo_barra',
						type: 'string'
					}
			]
        }, cfg));
    }
});
Ext.reg('storeFormRentasProductos', eNuevoOriente.storeFormRentasProductos);
