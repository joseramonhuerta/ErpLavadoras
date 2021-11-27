<?php
require ('eko_framework/includes/pdf_js.php');
require ('eko_framework/includes/funciones.php');
//ESTA CLASE DEBERIA TENER PUROS CICLOS DE IMPRESION,
// DEBERIA PROCESAR INFORMACION SOLAMENTE PARA EL ASPECTO VISUAL
class ReportePedidoTicketPDF extends PDF_JavaScript{
	var $cerrando=false;
	var $colorHeader;
	var $colorLetrasHeader;
	var $imprimirHeader=true;
	var $imprimirTotales=false;
	var $nueva=true;
	var $decimales=2;
	var $aceptarSalto=true;
	var $imprimirSubtotalesDesdeFooter=true;
	function ReportePedidoTicketPDF($orientation='L',$unit='mm',$format='Letter',$datos,$formatos){
		if (empty($this->yEncabezadoDeTabla))	$this->yEncabezadoDeTabla=45;
	 	$this->datos=$datos;
	 	$this->formatos=$formatos;
	 	$this->wCliente=65;	
		// throw new Exception($this->formatos['decimales']);	
		 							//$decimales=$this->formatos['decimales'];	 	
	 	$this->acumuladas=0;	//Sumatoria de facturas NO Canceladas	 	
		parent::__construct('L','mm',$format);
	 	$this->AliasNbPages(); 
		// $this->SetAutoPageBreak(true, 40);
		$this->colorHeader;
		$this->colorLetrasHeader;
		$this->SetFillColor(0, 0, 0);
		//$this->SetTextColor(255, 255, 255);
	}
	function AutoPrint($dialog=false)
	{
		//Open the print dialog or start printing immediately on the standard printer
		$param=($dialog ? 'true' : 'false');
		$script="print($param);";
		$this->IncludeJS($script);
	}

	function AutoPrintToPrinter($server, $printer, $dialog=false)
	{
		//Print on a shared printer (requires at least Acrobat 6)
		$script = "var pp = getPrintParams();";
		if($dialog)
			$script .= "pp.interactive = pp.constants.interactionLevel.full;";
		else
			$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
		$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
		$script .= "print(pp);";
		$this->IncludeJS($script);
	}	
	function AcceptPageBreak(){
		if ($this->aceptarSalto==true){
			return true;
			parent::AcceptPageBreak();	
		}		
	}
	function AddPage($orientation=''){
		$this->nueva=true;
		
		parent::AddPage($orientation);
	//	$this->tieneDetalles=false;
		$numPag=$this->PageNo();
		$this->subtotal[$numPag]=0;	//Subtotal Por Página
		$this->subtotalImpuestos[$numPag]=0;	//Subtotal Por Página
	}
	function Cell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link=''){
		parent::Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
		$this->nueva=false;
	}
	function Close(){
		$this->cerrando=true;
		parent::Close();		
	}
	public function Header() {
		//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]])
		$wCliente=65;
		$datos=$this->datos['data'];
		// $filtros=$this->datos['filtros'];
		// $empresa=$datos['empresa'];
		// $sucursal=$datos['turno']['nombre_sucursal'];
		// $nombre_fiscal = $datos['turno']['nombre_fiscal'];
		//$direccion = strtoupper($empresa['calle']." #".$empresa['numext']." ".$empresa['numint']);
		// $colonia = strtoupper('COL. '.$empresa['colonia']." ".$empresa['cp']);
		// $localidad = strtoupper($empresa['nom_ciu'].", ".$empresa['nom_est'].", ".$empresa['nom_pai']);
		
		
		
		$fecha_entrega=$datos['pedido']['fecha_entrega'];		
		$nombre_cliente=$datos['pedido']['nombre_cliente'];
		$nombre_trabajador=$datos['pedido']['nombre_trabajador'];
		$calle=$datos['pedido']['calle'];
		$colonia=$datos['pedido']['colonia'];
		
		//----------------------------------------------------
		//			Titulo del reporte
		//----------------------------------------------------
		$this->SetTextColor(0, 0, 0);
		$font="Arial";		
		$ancho=65;	
		

		
		$hCell=3.5;//		Alto de la celda
		$border=0;
		$filtroEstado='';
		
		$this->SetFont($font,'',10);		
		
		$this->Ln();
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Lavadoras Leon",$border,0,'C');	#	Valor
		
		$this->SetFont($font,'',7);
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Tel. 668-02-02",$border,0,'C');	#	Valor
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"669-255-97-61",$border,0,'C');	#	Valor
		$this->Ln(5);
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Mazatlan, Sin.",$border,0,'L');	#	Valor
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Fecha: ".$fecha_entrega,$border,0,'L');	
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"____________________________________________",$border,0,'L');	#	Valor
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Recibo: ",$border,0,'C');	#	Valor
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"____________________________________________",$border,0,'L');	#	Valor
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Chofer: ".$nombre_trabajador ,$border,0,'L');
		$this->Ln(5);
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Cliente: ".$nombre_cliente ,$border,0,'L');		
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Direccion: ".$calle ,$border,0,'L');
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Colonia: ".$colonia ,$border,0,'L');
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"____________________________________________",$border,0,'L');	#	Valor
		
		
       		
		$fill=1;
		$border=1;
		$this->subtotal=array();
		$this->subtotalImpuestos=array();
		
		$this->imprimeHeader();
		
      
        
	}
	
	function imprimeHeader(){
		// $border =0;
		// if ($this->imprimirHeader==true){
			
        // }
	}
	
	function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);
 
        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;
 
        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }
 
        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
 
        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }
 
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }
 
    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }
	
	public function imprimeDetalles($datos){
		
		$decimales=$this->decimales;
		$datos=$this->datos['data'];
		$wCliente=65;
		$this->SetTextColor(0, 0, 0);
		$ancho=65;
		$border=0;
		$fill=0;
		$zebra=1;
		$hCell=4;
		//$this->SetY(45);
		//$numPag=$this->PageNo();
		// $this->subtotal[$numPag]=0;	//Subtotal Por Pagina
		// $this->subtotalImpuestos[$numPag]=0;	//Subtotal Por Pagina
		// $this->impuestosAcumulados=0;
		$font="Arial";
		$this->SetFont($font,'',6);
		$this->SetTextColor(0,0,0);
		$canceladas=array();
		$this->imprimirSubtotalesDesdeFooter=true;
		// echo 'sizeof: '.sizeof($datos);
		// exit;
		//meen
		$this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
		$fill = false; //Para alternar el relleno
		
		$codigo_barra=$datos['pedido']['codigo_barra'];
		$fecha_vencimiento=$datos['pedido']['fecha_vencimiento'];
		
		$this->Ln(5);
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Lavadora: ".$codigo_barra ,$border,0,'L');
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Fecha Vencimiento: ".$fecha_vencimiento ,$border,0,'L');
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"___________________________________________________",$border,0,'L');	#	Valor
		
		// $this->ln(2);
		$this->imprimirHeader=false;
		$this->imprimirSubtotalesDesdeFooter=false;
		$ultimo=true;
		//$this->imprimirTotales($ultimo);
        $this->SetTextColor(0, 0, 0);
			
		// $hCell=5;
		// $PageBreakTrigger=$this->h-$this->bMargin;
		$this->despuesdelosdetalles();
	}
	
	function despuesdelosdetalles(){
		$decimales=$this->decimales;
		$datos=$this->datos['data'];
		$total = number_format ($datos['pedido']['precio_renta'] ,$decimales ,  '.' , ',' );
		$this->Ln(5);
		$ancho = 65;
		$hCell=4;
		$border = 0;
		$columna = 2;
		$alto   = 3.5;
		$this->SetX(2);
		$this->SetFont('Arial','',7);
		$this->SetX($columna);
		$this->Cell($ancho, $alto, "Monto: $ ".$total, $border, 0, 'C');
	
		
		
		$this->Ln(5);
		$this->SetX(2);
		$this->MultiCell(65,$hCell,"Recibi de Lavadoras Leon ubicado en av. Gardenia col. Flores Magon 210 A en Mazatlan, Sin. una lavadora con valor de 4500 en calidad de renta. Me comprometo hacer buen uso de ella y hacerme responsable en caso de robo o extravio pagando el total del costo de la misma " ,$border,1,'L');
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"_________________________" ,$border,0,'C');
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Firma" ,$border,0,'C');
		$this->Ln();
		$this->SetX(2);
		$this->Cell($ancho,$hCell,"Gracias por su preferencia" ,$border,0,'C');
		
	}
	
	function jsDateToMysql($jsDate){
        $date = "04/30/1973";
        list($dia, $mes, $aÃ±o) = explode('/', $jsDate);
        @list($aÃ±o,$time) = explode(' ', $aÃ±o);
        $convertida="$aÃ±o-$mes-$dia";

        if ($time!=''){
            list($hora, $minuto, $segundo) = explode(':', $time);
            $convertida.=" $hora:$minuto:$segundo";
        }
        return $convertida;
    }
		
	function imprimirTotales($ultimo=false){
		$this->aceptarSalto=false;
		$decimales=$this->decimales;	
		//$i=$this->PageNo();
		
		$datos=$this->datos['data'];
		
	
		$total = number_format ($datos['pedido']['precio_renta'] ,$decimales ,  '.' , ',' );
		
		$ancho = 65;
		$border = 0;
		$columna = 2;
		$alto   = 3.5;
		$this->SetFont('Arial','',7);
		$this->SetX($columna);
		$this->Cell($ancho, $alto, "Monto: $ ".$total, $border, 0, 'C');
		
		
		$this->aceptarSalto=true;
		
		
	}
	public function Footer() {
		
		// if ($this->imprimirSubtotalesDesdeFooter==true){
			
		// }
		//
		$yFooter = -11;
		$wFooter = 10;
		$this->SetY($yFooter);
		$this->SetFont('Arial','I',8);
		// $this->imprimirTotales();
		
	}
	
	function formatearTexto($cadena){
		$formato=$this->formatos['texto'];
		// echo 'formato: '.$formato;
		// exit;
		switch($formato){
			case 1:		//MAYUSCULAS

				return strtoupper($cadena);
				break;
			case 2:		//minusculas
				
				return strtolower($cadena);
				break;
			case 3:		//Capitalizado
				
				return  ucwords($cadena);
				break;
			default:
				throw new Exception("Formato desconocido: ".$formato);
		}

	}
}
?>
