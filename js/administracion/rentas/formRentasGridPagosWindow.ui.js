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

formRentasGridPagosWindowUi = Ext.extend(Ext.Window, {
    title: 'Pagos',
    width: 600,
    height: 430,
    modal: true,
    border: false,
    draggable: false,
    resizable: false,
    initComponent: function() {
        this.items = [
            {
				xtype: 'grid',
				//region: 'center',
				//width: 600,
				height: 400,
				itemId: 'gridRentasPagos',
				ref: 'gridRentasPagos',
				store: 'storeGridRentasPagos',
				stripeRows: true,
				autoExpandColumn: 'colNombre',
				tbar: {
					xtype: 'toolbar',
					items: [
						{
							xtype: 'button',
							text: 'Editar',
							disabled: true,
							ref: '../../btnEditarPago',
							icon: 'images/iconos/ordven_edit.png',
						},
						{
							xtype: 'tbseparator'
						},
						{
							xtype: 'button',
							text: 'Eliminar',
							disabled: true,
							ref: '../../btnEliminarPago',
							icon: 'images/iconos/ordven_delete.png',
						}
					]
				},
				columns: [
					{
						xtype: 'gridcolumn',
						dataIndex: 'id_pago',
						header: 'Recibo Pago',
						sortable: true,
						width: 80
					},
					{
						xtype: 'gridcolumn',
						dataIndex: 'fecha_pago',
						header: 'Fecha Pago',
						sortable: true,
						width: 80
					},
					{
						xtype: 'gridcolumn',
						dataIndex: 'hora_pago',
						header: 'Hora Pago',
						sortable: true,
						width: 80
					},
					{
						xtype: 'gridcolumn',
						dataIndex: 'nombre_cliente',
						header: 'Nombre Cliente',
						sortable: true,
						width: 220,
						id: 'colNombre'
					},
					{
						xtype: 'gridcolumn',
						dataIndex: 'importe',
						header: 'Importe',
						sortable: true,
						align: 'right',
						width: 80
					},
					{
						xtype: 'gridcolumn',
						dataIndex: 'nombre_trabajador',
						header: 'Cobrador',
						sortable: true,
						width: 130
					}
				],
				view: new Ext.grid.GridView({
					
				}),
				bbar: {
					xtype: 'paging',
					displayInfo: true
				}
				
			}
        ];
        formRentasGridPagosWindowUi.superclass.initComponent.call(this);
    }
});
