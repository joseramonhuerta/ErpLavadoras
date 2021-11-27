formProductosUi = Ext.extend(Ext.Panel, {
    width: 1252,
    layout: 'card',
    activeItem: 0,
    initComponent: function() {
        this.items = [
            {
				xtype: 'panel',
				border: false,
				layout: 'border',
				items: [
					{
						xtype: 'form',
						region: 'west',
						border: false,
						width: 350,
						itemId: 'formProducto',
						autoScroll: true,
						labelWidth: 115,
						padding:'10px',
						ref: '../formProducto',
						items: [
							{
								xtype: 'textfield',
								fieldLabel: 'Descripcion',
								itemId: 'txtDescripcion',
								name: 'descripcion',
								allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 200,
								width: 200,
								ref: '../../txtDescripcion',
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Codigo Barras',
								itemId: 'txtCodigoBarras',
								name: 'codigo_barra',
								allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 150,
								width: 150,
								ref: '../../txtCodigoBarras'
							},
							{
								xtype: 'numberfield',
								fieldLabel: 'Precio',
								itemId: 'txtPrecio',
								name: 'precio',
								width: 100,
								allowNegative: false,
								allowBlank: false,
								style: 'text-align:right;',
								labelStyle: 'font-weight:bold',
								ref: '../../txtPrecio'
							},
							{
								xtype: 'textfield',
								anchor: '100%',
								hidden: true,
								name: 'status',
								value: 'A',
								bubbleEvents: [
									'cambioDeStatus'
								],
								ref: '../../txtStatus'
							}
							
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
										ref: '../../../btnGuardar'
									},
									{
										xtype: 'button',
										text: 'Desactivar',
										icon: 'images/iconos/productos_red.png',
										disabled: true,
										ref: '../../../btnDesactivar',
										style: 'margin-left:10px'
									}
								]
							}
					},
					{
						xtype: 'panel',
						layout: 'border',
						border: false,
						region: 'center',
						items: [
							{
								xtype: 'panel',
								region: 'west',
								width: 10,
								border: false
							},
							{
								xtype: 'grid',
								region: 'center',
								width: 100,
								itemId: 'gridProducto',
								ref: '../../gridProducto',
								store: 'storeGridProducto',
								stripeRows: true,
								autoExpandColumn: 'colDescripcion',
								tbar: {
									xtype: 'toolbar',
									items: [
										{
											xtype: 'button',
											text: 'Nuevo',
											ref: '../../../../btnAgregar'
										},
										{
											xtype: 'tbseparator'
										},
										{
											xtype: 'button',
											text: 'Editar',
											disabled: true,
											ref: '../../../../btnEditar'
										},
										{
											xtype: 'tbseparator'
										},
										{
											xtype: 'button',
											text: 'Eliminar',
											disabled: true,
											ref: '../../../../btnEliminar'
										},
										{
											xtype: 'tbfill'
										},
										{
											xtype: 'displayfield',
											value: 'Status:',
											style: 'margin-right:5px;'
										},
										{
											xtype: 'combo',
											triggerAction: 'all',
											mode: 'local',
											displayField: 'nombre',
											valueField: 'id',
											width: 100,
											forceSelection: true,
											allowBlank: false,
											name: 'status',
											hiddenName: 'status',
											itemId: 'cmbStatus',
											style: '',
											editable: false,
											ref: '../../../../cmbStatus'
										},
										{
											xtype: 'tbseparator',
											style: ''
										},
										{
											xtype: 'textfield',
											emptyText: 'Introduzca el texto a buscar',
											width: 250,
											ref: '../../../../txtFiltro'
										}
									]
								},							
								columns: [
									{
										xtype: 'gridcolumn',
										dataIndex: 'id_producto',
										header: 'Num',
										sortable: true,
										width: 50
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'descripcion',
										header: 'Descripcion',
										sortable: true,
										width: 200,
										id: 'colDescripcion'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'codigo_barra',
										header: 'Codigo Barras',
										sortable: true,
										width: 120
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'precio',
										header: 'Precio',
										sortable: true,
										align: 'right',
										width: 100
										
									}
								],
								view: new Ext.grid.GridView({
									
								}),
								bbar: {
									xtype: 'paging',
									displayInfo: true
								}
								
							}
						]
					}
				]
				
			}
		];
        formProductosUi.superclass.initComponent.call(this);
    }
});			