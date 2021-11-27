/*
 * File: miErpWeb.storeGridCliente.js
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
eNuevoOriente.storeGridCliente = Ext.extend(Ext.data.JsonStore, {
    constructor: function(cfg) {
        cfg = cfg || {};
        eNuevoOriente.storeGridCliente.superclass.constructor.call(this, Ext.apply({
            storeId: 'storeGridCliente',
			idProperty: 'id_cliente',
			messageProperty: 'msg',
            root: 'data',
			totalProperty: 'totalRows',
            fields:[
				{
                    name: 'id_cliente'
                    
                },
				{
                    name: 'nombre',
                    type: 'string'
                },
				{
                    name: 'calle',
                    type: 'string'
                },
				{
                    name: 'colonia',
                    type: 'string'
                },
				{
                    name: 'cp',
                    type: 'string'
                },
				{
                    name: 'telefono1',
                    type: 'string'
                },
				{
                    name: 'telefono2',
                    type: 'string'
                },
				{
                    name: 'celular',
                    type: 'string'
                },
				{
                    name: 'curp',
                    type: 'string'
                },
				{
                    name: 'num_credencial',
                    type: 'string'
                },
				{
                    name: 'colonia',
                    type: 'string'
                },
				{
                    name: 'correo',
                    type: 'string'
                },
				{
                    name: 'id_ruta'
                    
                },
				{
                    name: 'ruta',
                    type: 'string'
                },
				{
                    name: 'status',
                    type: 'string'
                }
			
			],
            url: 'app.php/clientes/obtenerclientes'
        }, cfg));
    }
});
Ext.reg('storeGridCliente', eNuevoOriente.storeGridCliente);