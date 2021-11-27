formReporteInventarioUi = Ext.extend(Ext.form.FormPanel, {
    title: 'Reporte de Gastos',
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
				xtype: 'combo',
				fieldLabel: 'Producto',
				width: 300,
				itemId: 'cmbProducto',
				name: 'id_producto',
				valueField: 'id_producto',
				displayField: 'descripcion',
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
				ref: 'cmbProducto'
				
			}
		];
        formReporteInventarioUi.superclass.initComponent.call(this);
    }
});		