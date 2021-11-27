formGastosUi = Ext.extend(Ext.Panel, {
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
						itemId: 'formGasto',
						autoScroll: true,
						labelWidth: 115,
						padding:'10px',
						ref: '../formGasto',
						items: [
							/*{
								xtype: 'container',
								flex: 1,
								layout: 'hbox',
								items: [															
									{
										xtype: 'container',
										layout: 'form',
										labelAlign: 'top',
										items: [															
											{
												xtype: 'datefield',
												fieldLabel: 'Fecha',
												itemId: 'txtFecha',
												name: 'fecha',
												width: 100,
												labelStyle: 'font-weight:bold',												
												ref: '../../../../txtFecha'
											}
										]
									},
									{
										xtype: 'container',
										width: 10
										
									},
									{
										xtype: 'container',
										layout: 'form',
										labelAlign: 'top',
										items: [															
											{
												xtype: 'timefield',
												fieldLabel: 'Hora',
												itemId: 'txtHora',
												name: 'hora',
												width: 100,
												format: 'g:i:s A',
												labelStyle: 'font-weight:bold',												
												ref: '../../../../txtHora'
											}
										]
									}
								]	
							},*/
							{
								xtype: 'datefield',
								fieldLabel: 'Fecha',
								itemId: 'txtFecha',
								name: 'fecha',
								width: 100,
								labelStyle: 'font-weight:bold',												
								ref: '../../txtFecha'
							},
							{
								xtype: 'timefield',
								fieldLabel: 'Hora',
								itemId: 'txtHora',
								name: 'hora',
								width: 100,
								format: 'g:i:s A',
								labelStyle: 'font-weight:bold',												
								ref: '../../txtHora'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Concepto',
								itemId: 'txtConcepto',
								name: 'concepto',
								allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 200,
								width: 200,
								ref: '../../txtConcepto',
							},
							{
								xtype: 'numberfield',
								fieldLabel: 'Importe',
								itemId: 'txtImporte',
								name: 'importe',
								width: 100,
								allowNegative: false,
								allowBlank: false,
								style: 'text-align:right;',
								labelStyle: 'font-weight:bold',
								ref: '../../txtImporte'
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
										icon: 'images/iconos/servicios_red.png',
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
								itemId: 'gridGasto',
								ref: '../../gridGasto',
								store: 'storeGridGasto',
								stripeRows: true,
								autoExpandColumn: 'colConcepto',
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
										dataIndex: 'id_gasto',
										header: 'Folio',
										sortable: true,
										width: 50
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'fecha',
										header: 'Fecha',
										sortable: true,
										width: 100
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'hora',
										header: 'Hora',
										sortable: true,
										width: 80
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'concepto',
										header: 'Concepto',
										sortable: true,
										width: 200,
										id: 'colConcepto'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'importe',
										header: 'Importe',
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
        formGastosUi.superclass.initComponent.call(this);
    }
});			