/*
 * File: mfw.almacenes.storeFormRentasPlazoPagos.js
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.ns('eNuevoOriente');
eNuevoOriente.storeFormRentasPlazoPagos = Ext.extend(Ext.data.JsonStore, {
    constructor: function(cfg) {
        cfg = cfg || {};
        eNuevoOriente.storeFormRentasPlazoPagos.superclass.constructor.call(this, Ext.apply({
            storeId: 'storeFormRentasPlazoPagos',
			root: 'data',
			// autoLoad: false,
            fields: [
                {
                    name: 'id',
					 type: 'string'
                },
                {
                    name: 'nombre',
                    type: 'string'
                },
				{
                    name: 'valor',
                    type: 'string'
                }
            ]
        }, cfg));
    }
});
Ext.reg('storeFormRentasPlazoPagos', eNuevoOriente.storeFormRentasPlazoPagos);
