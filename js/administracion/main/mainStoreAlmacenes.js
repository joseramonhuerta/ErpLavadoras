/*
 * File: eNuevoOriente.mainStoreAlmacenes.js
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
eNuevoOriente.mainStoreAlmacenes = Ext.extend(Ext.data.JsonStore, {
    constructor: function(cfg) {
        cfg = cfg || {};
        eNuevoOriente.mainStoreAlmacenes.superclass.constructor.call(this, Ext.apply({
            storeId: 'mainStoreAlmacenes',
			autoDestroy: true,
            root: 'data',
            fields:["id_almacen","nombre_almacen"],
            url: 'app.php/sistema/obteneralmacenes'
        }, cfg));
    }
});
Ext.reg('mainStoreAlmacenes', eNuevoOriente.mainStoreAlmacenes);new eNuevoOriente.mainStoreAlmacenes();