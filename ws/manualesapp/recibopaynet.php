<?php

$amount = $_GET['amount'];
$currency = $_GET['currency'];
$reference = $_GET['reference'];
$barcode_url = $_GET['barcode_url'];

?>

<html>
<head>
<title>Recibo Paynet</title>
  <style>
    * {
        font-size:30px;
        font-family:Courier;
       
    }

    .divimporte{
        color:#fff;
        background-color: #f1a603;		
		border: 0px solid;

    }

    .referencia{
        font-size:15px;
		text-align:center;
    }

    .totalapagar{
        font-size:15px;
       font-weight: bold;
    }
    .total{
        font-size:30px;
        font-weight: bold;

    }

    .currency{
        font-size:15px;
         line-height : 5px;
		 font-weight: bold;
    }
    
    table, tr, td {
    	border: 0px solid;
  }
    

  </style>
</head>
<body>

	<table>
        <tr>
        	<td width="50px" class="divimporte"></td>
        	<td><p style="font-size:20px;font-weight: bold;text-align:right;">Servicio a pagar </p></td>
			<td><img src="https://erp.servfix.com.mx/ws/manualesapp/images/recibopaynet/logo_paynet.jpg" width="125" height="75"></td>		
        </tr>  
        <tr>
        	<td></td>	
         	<td colspan="2"><img src="<? echo $barcode_url; ?>" width="350" height="75"></td>
						
        </tr>
        <tr>
        	<td width="50px" class="divimporte"></td>	
        	<td class="referencia"  colspan="2"><? echo $reference; ?></td>
				
        </tr>
        <tr>
        	<td width="50px"></td>	
        	<td class="referencia"  colspan="2"><p style="font-size:12px; text-align:justify;">En caso de que el escáner no se capaz de leer el
            codigo <br> de barras, escribir la referencia tal como se muestra.</p></td>
        </tr>
        <tr class="divimporte">        	
        	<td></td>   
            <td  colspan="2"> 
            <div style="margin: 1rem;padding: 0rem;">
              <p class="totalapagar">Total a pagar
              <br><span class="total"><? echo $amount; ?></span> <span class="currency"><? echo $currency; ?></span>
              <br>+ comisión: 8.00 <? echo $currency; ?></p>
            </div>    
          </td>   
        </tr>
		<tr>
		<td colspan="3"><img src="https://erp.servfix.com.mx/ws/manualesapp/images/recibopaynet/Horizontal_1.jpg" width="450" height="150"></td>
		</tr>
	</table> 

</body>
</html>
<!--

-->