formReporteGastosUi = Ext.extend(Ext.form.FormPanel, {
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
			}
		];
        formReporteGastosUi.superclass.initComponent.call(this);
    }
});		