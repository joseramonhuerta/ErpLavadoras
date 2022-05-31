<?php 
require_once('db_connect.php');

$json=array();
	if(isset($_GET["id_manual"])){
		$id_manual=$_GET['id_manual'];
				

		
		$consulta="SELECT mp.id_manual_pagina AS id_pagina, mp.num_pagina AS pagina, IFNULL(mp.nombre_pagina,'') AS titulo FROM cat_manuales_paginas mp
					INNER JOIN cat_manuales m ON m.id_manual = mp.id_manual
					WHERE mp.id_manual = {$id_manual}
					ORDER BY mp.num_pagina ASC";
		
		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){			
			while ($row = mysqli_fetch_array($resultado)) {
                $json[] = $row;
            }
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
		}

		else{
			$results["pagina"]='';
			
			
			$json[]=$results;
			mysqli_close($conexion);
			echo json_encode($json);
		}
	
	}else{
			$results["pagina"]='';
			
			
			$json[]=$results;
			echo json_encode($json);
	}



 ?>