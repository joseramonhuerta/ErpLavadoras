formUsuariosUi = Ext.extend(Ext.Panel, {
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
						itemId: 'formUsuario',
						autoScroll: true,
						labelWidth: 120,
						padding:'10px',
						ref: '../formUsuario',
						items: [
							{
								xtype: 'textfield',
								fieldLabel: 'Nombre Usuario',
								itemId: 'txtNombreUsuario',
								name: 'nombre_usuario',
								allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 100,
								width: 200,
								ref: '../../txtNombreUsuario',
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Usuario',
								itemId: 'txtUsuario',
								name: 'usuario',
								allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 100,
								width: 200,
								ref: '../../txtUsuario'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Contraseña',
								itemId: 'txtPass',
								name: 'pass',
								inputType: 'password',
                                allowBlank: false,
								labelStyle: 'font-weight: bold',
								maxLength: 100,
								width: 200,
								ref: '../../txtPass'
							},
							{
								xtype: 'textfield',
								fieldLabel: 'Correo',
								itemId: 'txtCorreo',
								name: 'correo',
								vtype:'email',
								labelStyle: 'font-weight: bold',
								maxLength: 100,
								width: 200,
								ref: '../../txtCorreo'
							},
							{
								xtype: 'combo',
								fieldLabel: 'Rol',
								width: 160,
								labelStyle: 'font-weight:bold;',
								allowBlank: false,
								forceSelection: true,
								name: 'rol',
								displayField: 'nombre',
								valueField: 'id',
								mode: 'local',
								triggerAction: 'all',
								hiddenName: 'rol',
								editable: false,
								ref: '../../cmbRol'
							},
							{
								 xtype: 'combo',
								fieldLabel: 'Trabajador',
								width: 200,
								allowBlank: true,
								forceSelection: false,
								hiddenName: 'id_trabajador',
								name: 'id_trabajador',
								displayField: 'nombre_trabajador',
								valueField: 'id_trabajador',
								enableKeyEvents: true,
								pageSize: 20,
								triggerAction: 'all',
								minChars: 2,
								
								ref: '../../cmbTrabajador'
							},
							{
								xtype: 'combo',
								fieldLabel: 'App Lavadoras',
								width: 50,
								labelStyle: 'font-weight:bold;',
								allowBlank: false,
								forceSelection: true,
								name: 'app_lavadoras',
								displayField: 'nombre',
								valueField: 'id',
								mode: 'local',
								triggerAction: 'all',
								hiddenName: 'app_lavadoras',
								editable: false,
								ref: '../../cmbAppLavadoras'
							},
							{
								xtype: 'combo',
								fieldLabel: 'App Orden Servicio',
								width: 50,
								labelStyle: 'font-weight:bold;',
								allowBlank: false,
								forceSelection: true,
								name: 'app_ordenes_servicio',
								displayField: 'nombre',
								valueField: 'id',
								mode: 'local',
								triggerAction: 'all',
								hiddenName: 'app_ordenes_servicio',
								editable: false,
								ref: '../../cmbAppOrdenesServicio'
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
								itemId: 'gridUsuario',
								ref: '../../gridUsuario',
								store: 'storeGridUsuario',
								//stripeRows: true,
								autoExpandColumn: 'colNombreUsuario',
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
										sortable: true,
										width: 25,
										id: 'colAuditoria'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'nombre_usuario',
										header: 'Nombre Usuario',
										sortable: true,
										width: 300,
										id: 'colNombreUsuario'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'usuario',
										header: 'Usuario',
										sortable: true,
										width: 200
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'correo',
										header: 'Correo',
										sortable: true,
										width: 200,
										id: 'colCorreo'
									},
									{
										xtype: 'gridcolumn',
										dataIndex: 'rol',
										header: 'Rol',
										sortable: true,
										width: 150,
										id: 'colRol'
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
        formUsuariosUi.superclass.initComponent.call(this);
    }
});			