formReporteRentasUi = Ext.extend(Ext.form.FormPanel, {
    title: 'Reporte de Rentas',
    width: 717,
    height: 465,
    padding: 10,
    autoScroll: true,
    initComponent: function() {
        this.tbar = {
            xtype: 'toolbar',
            items: [{
                xtype: 'splitbutton',
                text: 'Imprimir',
                icon: 'images/iconos/bullet_printer.png',
                ref: '../btnImprimir',
                menu: {
                    xtype: 'menu',
                    items: [{
                        xtype: 'menuitem',
                        text: 'PDF',
                        itemId: 'btnPDF',
                        icon: 'images/iconos/pdf.png',
                        ref: '../../../btnPDF'
                    }, {
                        xtype: 'menuitem',
                        text: 'Excel',
                        itemId: 'btnExcel',
                        icon: 'images/iconos/excel.png',
                        ref: '../../../btnExcel'
                    }]
                }
            }]
        };
        this.items = [
			{
				xtype:'datefield',
				fieldLabel:'Fecha Inicio',
				itemId:'txtFechaInicio',
				name:'FechaInicio',
				labelStyle:'font-weight:bold',
				ref:'txtFechaInicio'
			},
			
			{
				xtype:'datefield',
				fieldLabel:'Fecha Fin',
				itemId:'txtFechaFin',
				name:'FechaFin',
				labelStyle:'font-weight:bold',
				ref:'txtFechaFin'
			},
			{
				xtype: 'combo',
				fieldLabel: 'Cliente',
				width: 300,
				itemId: 'cmbCliente',
				name: 'id_cliente',
				valueField: 'id_cliente',
				displayField: 'nombre',
				enableKeyEvents: true,
				labelStyle: 'font-weight:bold',
				minChars: 0,
				pageSize: 20,
				triggerConfig: {
					tag: 'span',
					cls: 'x-form-twin-triggers',
					style: 'padding-right:2px',
					cn: [
						{
							tag: "img",
							src: Ext.BLANK_IMAGE_URL,
							cls: "x-form-trigger x-form-clear-trigger"
						},
						{
							tag: "img",
							src: Ext.BLANK_IMAGE_URL,
							cls: "x-form-trigger x-form-search-trigger"
						}
					]
				},
				ref: 'cmbCliente'
				
			},
			{
				 xtype: 'combo',
				fieldLabel: 'Cobrador',
				width: 300,
				labelStyle: 'font-weight:bold;',
				hiddenName: 'id_trabajador',
				name: 'id_trabajador',
				displayField: 'nombre_trabajador',
				valueField: 'id_trabajador',
				enableKeyEvents: true,
				pageSize: 20,
				triggerAction: 'all',
				minChars: 2,
				triggerConfig: {
					tag: 'span',
					cls: 'x-form-twin-triggers',
					style: 'padding-right:2px',
					cn: [
						{
							tag: "img",
							src: Ext.BLANK_IMAGE_URL,
							cls: "x-form-trigger x-form-clear-trigger"
						},
						{
							tag: "img",
							src: Ext.BLANK_IMAGE_URL,
							cls: "x-form-trigger x-form-search-trigger"
						}
					]
				},
				ref: 'cmbTrabajador'
				
			}/*,
			{
				xtype: 'combo',
				fieldLabel: 'Estatus Renta',
				triggerAction: 'all',
				mode: 'local',
				displayField: 'nombre',
				valueField: 'id',
				width: 100,
				forceSelection: true,
				allowBlank: false,
				name: 'status_renta',
				hiddenName: 'status_renta',
				itemId: 'cmbStatusRenta',
				style: '',
				editable: false,
				ref: 'cmbStatusRenta'
			}*/
		];
        formReporteRentasUi.superclass.initComponent.call(this);
    }
});		