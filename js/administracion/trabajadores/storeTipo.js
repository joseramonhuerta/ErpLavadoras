/*
 * File: mfw.almacenes.storeTipo.js
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.ns('eNuevoOriente');
eNuevoOriente.storeTipo = Ext.extend(Ext.data.JsonStore, {
    constructor: function(cfg) {
        cfg = cfg || {};
        eNuevoOriente.storeTipo.superclass.constructor.call(this, Ext.apply({
            storeId: 'storeTipo',
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
                }
            ]
        }, cfg));
    }
});
Ext.reg('storeTipo', eNuevoOriente.storeTipo);
