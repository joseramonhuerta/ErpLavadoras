formTrabajadoresUi = Ext.extend(Ext.Panel, {
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
						itemId: 'formTrabajador',
						autoScroll: true,
						labelWidth: 115,
						padding:'10px',
						ref: '../formTrabajador',
						items: [
							{
								xtype: 'textfield',
								fieldLabel: 'Nombre',
								itemId: 'txtNombre',
								name: 'nombre',
								allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 200,
								width: 200,
								ref: '../../txtNombre',
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Direccion',
								itemId: 'txtDireccion',
								name: 'direccion',
								allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 200,
								width: 200,
								ref: '../../txtDireccion'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Curp',
								itemId: 'txtCURP',
								name: 'curp',
								//allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 20,
								width: 150,
								ref: '../../txtCURP'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Num. Credencial',
								itemId: 'txtNumCredencial',
								name: 'num_credencial',
								//allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 50,
								width: 150,
								ref: '../../txtNumCredencial'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Telefono 1',
								itemId: 'txtTelefono1',
								name: 'telefono1',
								// allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 20,
								width: 100,
								ref: '../../txtTelefono1'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Telefono 2',
								itemId: 'txtTelefono2',
								name: 'telefono2',
								// allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 20,
								width: 100,
								ref: '../../txtTelefono2'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Celular',
								itemId: 'txtCelular',
								name: 'celular',
								// allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 20,
								width: 100,
								ref: '../../txtCelular'
							},
							{
								xtype: 'combo',
								fieldLabel: 'Tipo',
								width: 160,
								labelStyle: 'font-weight:bold;',
								allowBlank: false,
								forceSelection: true,
								name: 'tipo',
								displayField: 'nombre',
								valueField: 'id',
								mode: 'local',
								triggerAction: 'all',
								hiddenName: 'tipo',
								editable: false,
								ref: '../../cmbTipo'
							},
							{
								 xtype: 'combo',
								fieldLabel: 'Ruta',
								width: 160,
								labelStyle: 'font-weight:bold;',
								allowBlank: false,
								forceSelection: true,
								hiddenName: 'id_ruta',
								name: 'id_ruta',
								displayField: 'descripcion',
								valueField: 'id_ruta',
								enableKeyEvents: true,
								pageSize: 20,
								triggerAction: 'all',
								minChars: 2,
								//triggerClass: 'x-form-search-trigger',
								ref: '../../cmbRuta'
								
								
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
										icon: 'images/iconos/user_todos.png',
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
								itemId: 'gridTrabajador',
								ref: '../../gridTrabajador',
								store: 'storeGridTrabajador',
								stripeRows: true,
								autoExpandColumn: 'colNombre',
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
										dataIndex: 'id_trabajador',
										header: 'Num',
										sortable: true,
										width: 50
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'nombre',
										header: 'Nombre Trabajador',
										sortable: true,
										width: 200,
										id: 'colNombre'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'direccion',
										header: 'Direccion',
										sortable: true,
										width: 300
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'telefono1',
										header: 'Telefono 1',
										sortable: true,
										width: 100,
										id: 'colTelefono1'
										
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'telefono2',
										header: 'Telefono 2',
										sortable: true,
										width: 100,
										id: 'colTelefono2'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'celular',
										header: 'Celular',
										sortable: true,
										width: 100,
										id: 'colCelular'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'ruta',
										header: 'Ruta',
										sortable: true,
										width: 100
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'tipo',
										header: 'Tipo',
										sortable: true,
										width: 100,
										id: 'colTipo'
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
        formTrabajadoresUi.superclass.initComponent.call(this);
    }
});			