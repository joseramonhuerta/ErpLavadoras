/*
 * File: formRentasPagosWindow.ui.js
 * Date: Tue Dec 25 2018 23:34:27 GMT-0700 (Hora estándar Montañas (México))
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

formRentasPagosWindowUi = Ext.extend(Ext.Window, {
    title: 'Pagos',
    width: 300,
    height: 170,
    modal: true,
    border: false,
    draggable: false,
    resizable: false,
    initComponent: function() {
        this.items = [
            {
                xtype: 'form',
				itemId: 'formRentasPagosWindow',
				border: false,
				ref: 'formRentasPagosWindow',
				padding: 10,
				items: [
					{
						xtype: 'container',
						layout: 'hbox',
						items:[
							{
								xtype: 'container',
								layout: 'form',
								labelAlign: 'top',
								flex: 1,
								//width:100,
								items:[
									{
										xtype: 'textfield',
										fieldLabel: 'Num. Recibo',
										itemId: 'txtNumRecibo',
										name: 'chofer',
										width: 100,
										submitValue: false,
										disabled: true,
										ref: '../../../txtNumRecibo'
									}
								]
							},
							{
								xtype: 'container',
								width: 20
							},
							{
								xtype: 'container',
								layout: 'form',
								labelAlign: 'top',
								//width:100,
								items: [
									{
										xtype: 'datefield',
										itemId: 'txtFechaEntrega',
										name: 'fecha_entrega',
										hidden: true,
										ref: '../../../txtFechaEntrega'
									},	
									{
										xtype: 'timefield',
										fieldLabel: 'Hora Entrega',
										itemId: 'txtHoraEntrega',
										name: 'hora',
										width: 100,
										allowBlank: false,
										format: 'g:i:s A',
										labelStyle: 'font-weight:bold',												
										ref: '../../../txtHoraEntrega'
									}
								]
							}
						]
					},
					{
						xtype: 'container',
						layout: 'hbox',
						items:[
							{
								xtype: 'container',
								layout: 'form',
								labelAlign: 'top',
								flex: 1,
								//width:100,
								items:[
									{
										xtype: 'numberfield',
										fieldLabel: 'Precio Renta',
										itemId: 'txtPrecioRenta',
										name: 'precio_renta',
										width: 100,
										allowNegative: false,
										submitValue: false,
										allowBlank: false,
										style: 'text-align: right',
										ref: '../../../txtPrecioRenta'
									}
								]
							}
						]
					},
				],
				bbar: {
								xtype: 'toolbar',
								buttonAlign: 'right',
								items: [
									{
										xtype: 'button',
										text: 'Guardar',
										icon: 'images/iconos/save.png',
										itemId: 'btnGuardar',
										ref: '../../btnGuardar'
									},
									{
										xtype: 'button',
										text: 'Cancelar',
										icon: 'images/iconos/cancel.png',
										ref: '../../btnCancelar',
										style: 'margin-left:10px'
									}
								]
							}
                
            }
        ];
        formRentasPagosWindowUi.superclass.initComponent.call(this);
    }
});
