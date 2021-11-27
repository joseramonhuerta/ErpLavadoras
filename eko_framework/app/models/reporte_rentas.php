<?php
/*
 *	Esta clase deberia analizar y preparar toda la informacion, dejarla lista para que el PDF imprima usando solamente ciclos
 * por el momento hay logica repartida en esta clase y en reporte_de_facturacion_pdf.php
 */
class ReporteRentas{
	function generarReporte($params,$formatos){
		
		$datos=$this->obtenerDatos($params);					//Obtiene los datos de la base de datos
		if (empty($datos) ){
			throw new Exception("No hay datos que mostrar");
		}		
		// $preparados=$this->prepararParaImpresion($datos,$params);		//analiza los datos y los agrupa listos para imprimirlos en el PDF
		
		
		
		$pdf=$this->crearReporte($datos,$formatos);		//Crea el pdf
		return $pdf; 
	}
	function getPDF($nombrePDF){
		
		$ruta="eko_framework/tmp/";
		$pdf=$ruta.$nombrePDF;
		
		if (!file_exists ($pdf)){
			throw new Exception("No fue encontrado el archivo, realize de nuevo la consulta");
		}
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");		
		header ("Content-Type: application/pdf");
		//header ("Content-Type: application/force-download");
		header("Content-Disposition: inline; filename=$nombrePDF");
		//header ("Content-Disposition: attachment; filename=$nombrePDF ");
		header ("Content-Length: ".filesize($pdf));		
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$fp=fopen($pdf, "r");

		fpassthru($fp);
		fclose ($fp);	
		if (!unlink($pdf)){
			throw new Exception("No Borrado");	
		}
		
		
	}
	function crearReporte($datos,$formatos){
		//throw new Exception("ramon");
		require "eko_framework/app/models/reporte_rentas_pdf.php";
			
		$pdf=new ReporteRentasPDF('P','mm','Letter',$datos,$formatos);
		$pdf->AddPage('P');
		
		$pdf->imprimeDetalles($datos);				
					
		$nombrePDF='rep_fact_.pdf';
		$pdf->Output('eko_framework/tmp/'.$nombrePDF, 'F');	
			
		return $nombrePDF;
	}
	function obtenerDatos($params){
		 //------------------------------------------------------------------
		//		. . . Se va a armar una cadena con el filtro WHERE . . . 
		//------------------------------------------------------------------
		$this->model=new Model();
		$model=$this->model;
		//$model->camposAfiltrar = array('NomCliente','RFCCliente');  
		
		
		$IDCliente=(empty($params['IDCliente'])) ?  '': $params['IDCliente'];
		$IDTrabajador=(empty($params['IDTrabajador'])) ?  '': $params['IDTrabajador'];
		$fechaInicio=(empty($params['FechaIni'])) ?  '': $params['FechaIni'];
		$fechaFin=(empty($params['FechaFin'])) ?  '': $params['FechaFin'];
		$fechaInicio.=" 00:00:00"; 
		$fechaFin.=" 23:59:59";
		$fechaFinFiltro=(empty($params['FechaFin'])) ?  '': $params['FechaFin'];
		$Cliente=(empty($params['Cliente'])) ?  'TODOS': $params['Cliente'];
		$Trabajador=(empty($params['Trabajador'])) ?  'TODOS': $params['Trabajador'];
		// $filtros = array();
		// $filtros['fechaInicio'] = ;
		
		$filtroSql=" WHERE p.status = 'A' AND pp.status = 'A' AND p.status_renta > 0 AND pp.fecha_pago BETWEEN '$fechaInicio' AND '$fechaFin'";
		
		
        
		if (strlen($IDCliente) > 0) {
            $filtroSql.=" AND p.id_cliente = $IDCliente ";
        }
		
		if (strlen($IDTrabajador) > 0) {
            $filtroSql.=" AND pp.id_trabajador = $IDTrabajador ";
        }
		
		$query = "SELECT DATE_FORMAT('$fechaInicio','%d/%m/%Y') as fecha_inicio,DATE_FORMAT('$fechaFinFiltro','%d/%m/%Y') as fecha_fin, '$Cliente' as Cliente,'$Trabajador' as Trabajador";
		
		$resArr = $model->query($query);
		if ( empty($resArr) ){
			return array();
		}
		
		$query = "SELECT SUM(pp.importe) as total FROM pagos pp
				INNER JOIN pedidos p ON p.id_pedido = pp.id_pedido
				INNER JOIN cat_clientes c ON c.id_cliente = p.id_cliente					
				$filtroSql";
				
		
				
		$resArrRentas = $model->query($query);
		if ( empty($resArrRentas) ){
			return array();
		}
				
		$query = "SELECT pp.id_pago,pp.id_pedido,DATE_FORMAT(pp.fecha_pago,'%d/%m/%Y') AS fecha,c.nombre, importe as total,u.nombre_usuario  FROM pagos pp
					INNER JOIN pedidos p ON p.id_pedido = pp.id_pedido
					INNER JOIN cat_clientes c ON c.id_cliente = p.id_cliente
					LEFT JOIN cat_usuarios u ON u.id_usuario = pp.usercreador		
					$filtroSql
					ORDER BY pp.fecha_pago,c.nombre";		
				
		
		// throw new Exception($query);		
		$resArrDetalles = $model->query($query);
		if ( empty($resArrDetalles) ){
			return array();
		}
		
		
		// $serie = $resArr[0]['serie_movimiento'];
			
		//--------------Si se ha filtrado por cliente, mando aparte los datos del cliente
		
		$response=array();
      	$response['data']['filtros']=$resArr[0]; 
		$response['data']['rentas']=$resArrRentas[0];
		$response['data']['detalles']=$resArrDetalles;   
		// print_r($resArrDetalles,true);		
        //$response['data']=$resArr;   
	    //$response['filtros']=$params;	
			
		// throw new Exception($resArr['data']['serie_movimiento'][0]);
        return $response;
	}
	function obtenerDatosExcel($params){
		 //------------------------------------------------------------------
		//		. . . Se va a armar una cadena con el filtro WHERE . . . 
		//------------------------------------------------------------------
		$this->model=new Model();
		$model=$this->model;
		//$model->camposAfiltrar = array('NomCliente','RFCCliente');  
		
		
		$IDCliente=(empty($params['IDCliente'])) ?  '': $params['IDCliente'];
		$IDTrabajador=(empty($params['IDTrabajador'])) ?  '': $params['IDTrabajador'];
		$fechaInicio=(empty($params['FechaIni'])) ?  '': $params['FechaIni'];
		$fechaFin=(empty($params['FechaFin'])) ?  '': $params['FechaFin'];
		$fechaInicio.=" 00:00:00"; 
		$fechaFin.=" 23:59:59";
		$fechaFinFiltro=(empty($params['FechaFin'])) ?  '': $params['FechaFin'];
		$Cliente=(empty($params['Cliente'])) ?  'TODOS': $params['Cliente'];
		$Trabajador=(empty($params['Trabajador'])) ?  'TODOS': $params['Trabajador'];
		// $filtros = array();
		// $filtros['fechaInicio'] = ;
		
		$filtroSql=" WHERE p.status = 'A' AND pp.status = 'A' AND p.status_renta > 0 AND pp.fecha_pago BETWEEN '$fechaInicio' AND '$fechaFin'";
		
		
        
		if (strlen($IDCliente) > 0) {
            $filtroSql.=" AND p.id_cliente = $IDCliente ";
        }
		
		if (strlen($IDTrabajador) > 0) {
            $filtroSql.=" AND pp.id_trabajador = $IDTrabajador ";
        }
		
		$query = "SELECT DATE_FORMAT('$fechaInicio','%d/%m/%Y') as fecha_inicio,DATE_FORMAT('$fechaFinFiltro','%d/%m/%Y') as fecha_fin, '$Cliente' as Cliente,'$Trabajador' as Trabajador";
		
		$resArr = $model->query($query);
		if ( empty($resArr) ){
			return array();
		}
		
		$query = "SELECT SUM(pp.importe) as total FROM pagos pp
				INNER JOIN pedidos p ON p.id_pedido = pp.id_pedido
				INNER JOIN cat_clientes c ON c.id_cliente = p.id_cliente					
				$filtroSql";
				
		
				
		$resArrRentas = $model->query($query);
		if ( empty($resArrRentas) ){
			return array();
		}
				
		$query = "SELECT pp.id_pago,pp.id_pedido,DATE_FORMAT(pp.fecha_pago,'%d/%m/%Y') AS fecha,c.nombre, importe as total,
					IFNULL(t.nombre,u.nombre_usuario) as nombre_usuario FROM pagos pp
					INNER JOIN pedidos p ON p.id_pedido = pp.id_pedido
					INNER JOIN cat_clientes c ON c.id_cliente = p.id_cliente 
					LEFT JOIN cat_trabajadores t ON t.id_trabajador = pp.id_trabajador
					LEFT JOIN cat_usuarios u ON u.id_usuario = pp.usercreador
					$filtroSql
					ORDER BY pp.fecha_pago,c.nombre";		
				
		
		// throw new Exception($query);		
		$resArrDetalles = $model->query($query);
		if ( empty($resArrDetalles) ){
			return array();
		}
		
		
		// $serie = $resArr[0]['serie_movimiento'];
			
		//--------------Si se ha filtrado por cliente, mando aparte los datos del cliente
		
		$response=array();
      	$response['data']=$resArrDetalles;   
		// print_r($resArrDetalles,true);		
        //$response['data']=$resArr;   
	    //$response['filtros']=$params;	
			
		// throw new Exception($resArr['data']['serie_movimiento'][0]);
        return $response;
	}
	function prepararParaImpresion($datos,$filtros){
		$resArr=$datos['data'];
        $response=array();
		$response['data']=$resArr;
		return $response;
	}
	function creadaEnElPeriodo($fInicial,$fFinal,$FechaFacSinHora){		
		//throw new Exception("$fInicial,$fFinal,$FechaFacSinHora");
		$fechaInicial=strtotime ($this->model->jsDateToMysql($fInicial));		
		$fechaFinal=strtotime ($this->model->jsDateToMysql($fFinal));
		$fechaFacturacion=strtotime ($this->model->jsDateToMysql($FechaFacSinHora));
		
		
		//$fechaInicial=DateTime::createFromFormat('d/m/Y', $fInicial)->getTimestamp();
		//$fechaFinal=DateTime::createFromFormat('d/m/Y H:i:s', $fFinal)->getTimestamp();
		//$fechaFacturacion=DateTime::createFromFormat('d/m/y', $FechaFacSinHora)->getTimestamp();
		if ($fechaInicial<=$fechaFacturacion && $fechaFacturacion<=$fechaFinal){
			//throw new Exception("TRUE: "."$fechaInicial<=$fechaFacturacion && $fechaFacturacion<=$fechaFinal");
			return true;
		}else{
			//throw new Exception("FALSE: "."$fechaInicial<=$fechaFacturacion && $fechaFacturacion<=$fechaFinal");
			return false;
		}	
	}
	function mesToLetras($mes){
		$numMes=floor ($mes);
		$mesEnLetras='';
		switch($numMes){
			case 1:
				$mesEnLetras="ENERO";
			break;
			case 2:
				$mesEnLetras="FEBRERO";
			break;
			case 3:
				$mesEnLetras="MARZO";
			break;
			case 4:
				$mesEnLetras="ABRIL";
			break;
			case 5:
				$mesEnLetras="MAYO";
			break;
			case 6:
				$mesEnLetras="JUNIO";
			break;
			case 7:
				$mesEnLetras="JULIO";
			break;
			case 8:
				$mesEnLetras="AGOSTO";
			break;
			case 9:
				$mesEnLetras="SEPTIEMBRE";
			break;
			case 10:
				$mesEnLetras="OCTUBRE";
			break;
			case 11:
				$mesEnLetras="NOVIEMBRE";
			break;
			case 12:
				$mesEnLetras="DICIEMBRE";
			break;
			default:
				throw new Exception("Mes desconocido: ".$numMes);			
		}
		return $mesEnLetras;
	}
	function redondeado ($numero, $decimales) {
   		$factor = pow(10, $decimales);
   		return (round($numero*$factor)/$factor); 
	} 
	function generarReporteExcel($params){
	$datos=$this->obtenerDatosExcel($params);					
		if (empty($datos) ){
			throw new Exception("No hay datos que mostrar");
		}		
		$preparados=$this->prepararParaImpresion($datos,$params);		
		
			
			
			$informes = $preparados["data"];
			foreach($res as $row){
				$informes[] = $row;
			}

			if(empty($informes)){
				if(!empty($_GET['ajax'])){
					echo '0'; 	
				}
				exit;
			}else if(!empty($_GET['ajax'])){
				echo '1';
				exit;
			}
			
			require_once 'eko_framework/includes/phpexcel/PHPExcel.php';
			include 'eko_frameworkincludes/phpexcel/PHPExcel/IOFactory.php';
			
			$nombreReporte = "Reporte de Rentas ";
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("")
            	->setLastModifiedBy("")
            	->setTitle($nombreReporte)
            	->setSubject("reporte");
            $objPHPExcel->setActiveSheetIndex(0);

            $rowCount = 1;
	
            $encabezado = array(
			    'font'  => array(
			        'bold' => true,
			        'color' => array('rgb' => 'FFFFFF'),
			        'size'  => 12,
			    ),
			    'fill' => array(
			        'type' => PHPExcel_Style_Fill::FILL_SOLID,
			        'color' => array('rgb' => $_GET['color'])
			    ),
			    'alignment' => array(
			        'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP ,
			    )
			);

			$titulo = array(
			    'font'  => array(
			        'bold' => true,
			        'size'  => 18,
			    ),
			    'alignment' => array(
			        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			    )
			);

			$_GET['empresasText'] = trim($_GET['empresasText'], " ");
			$_GET['empresasText'] = trim($_GET['empresasText'], ",");
			$_GET['empresasText'] = trim($_GET['empresasText'], "undefined");

			setlocale(LC_ALL,"es_ES");
			$fechaNueva = $_GET['dateDesde']; //1234 6789
			$fechaNueva = date("dm", strtotime($fechaNueva));
			$fechaNuevaY = date("Y", strtotime($fechaNueva));
	
			$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');

			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);


			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($titulo);
		
			$fechaNueva = $rest = substr($fechaNueva, 0, 7);
			setlocale(LC_ALL,"es_ES");
			// $hoy = date("j F Y g:i a");
			$year = date("Y");
			$month = date("m");
			$day = date("d");
			// echo $day.$month.$year;
			// exit;
			if($month=='01'){
				$month = 'Enero';
			}else if($month=='02'){
				$month = 'Febrero';
			}else if($month=='03'){
				$month = 'Marzo';
			}else if($month=='04'){
				$month = 'Abril';
			}else if($month=='05'){
				$month = 'Mayo';
			}else if($month=='06'){
				$month = 'Junio';
			}else if($month=='07'){
				$month = 'Julio';
			}else if($month=='08'){
				$month = 'Agosto';
			}else if($month=='09'){
				$month = 'Septiembre';
			}else if($month=='10'){
				$month = 'Octubre';
			}else if($month=='11'){
				$month = 'Noviembre';
			}else if($month=='12'){
				$month = 'Diciembre';
			}
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', $nombreReporte.$day.' '.$month.' '.$year);
			
			
			//$objPHPExcel->getActiveSheet()->mergeCells('A2:F3');
		
			
			$filtrosFormat = array(
			    'font'  => array(
			        // 'bold' => true,
			        'size'  => 13
			    ),
			    'alignment' => array(
			        'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
			    )
			);
			
			$objRichText = new PHPExcel_RichText();

			
			
			$rowCount = 4;

            $objPHPExcel->getActiveSheet()->getStyle('A4:E4')->applyFromArray($encabezado);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
            
            
			
			// NOMBRE CLIENTE, RFC, FECHA ULT. REGISTRO, MES DE OPERACIÓN, AÑO DE OPERACIÓN, SALDO, CONSUMO CALCULADO, SALDO 
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "RECIBO")
							  ->SetCellValue('B'.$rowCount, "FECHA")
							  ->SetCellValue('C'.$rowCount, "CLIENTE")
							  ->SetCellValue('D'.$rowCount, "IMPORTE")
							  ->SetCellValue('E'.$rowCount, "USUARIO");
			$rowCount++;
			$filablanca = array(
			    'fill' => array(
			        'type' => PHPExcel_Style_Fill::FILL_SOLID,
			        'color' => array('rgb' => 'FFFFFF')
			    )
			);

			$filagris = array(
			    'fill' => array(
			        'type' => PHPExcel_Style_Fill::FILL_SOLID,
			        'color' => array('rgb' => 'F4F4F4')
			    )
			);
			//ciclo
			$blanco = 1;
			
			foreach ($informes as $key => $value) {
						
				$colorBackGround = 'A3F3B2';
				$colorLetra = '359C33';
				if($value['SaldoCalculado'] < 1) {
					$colorBackGround = 'F59A9C';
					$colorLetra = '790000';
				} 

				
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value['id_pago'])
							  ->SetCellValue('B'.$rowCount, $value['fecha'])
							  ->SetCellValue('C'.$rowCount, $value['nombre'])
							  ->SetCellValue('D'.$rowCount, $value['total'])
							  ->SetCellValue('E'.$rowCount, $value['nombre_usuario']);

				$rowCount++;
			}
			//fin ciclo
			$firma = array(
			    'font'  => array(
			        'color' => array('rgb' => '000000'),
			        'bold' => true,
			    ),
			    'alignment' => array(
	                'horizontal' =>	PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	                'wrap' => true
	            )
			);

			
			
			$objPHPExcel->getActiveSheet()->setTitle($nombreReporte);
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment; filename=\"Reporte de Rentas.xlsx\"");
			header("Cache-Control: max-age=0");
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			ob_end_clean();
			$objWriter->save('php://output');
			//$objWriter->save('../Reporte de Rentas.xlsx');
			//header("Location: ../Reporte de Rentas.xlsx");
			exit();
			
			
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//header("Content-Disposition: attachment;filename={$filename}");
		//header('Cache-Control: max-age=0');
		//$objWriter->save('php://output');
			
			
		
	}
}
?>