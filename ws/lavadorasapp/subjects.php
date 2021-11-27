<?php 
$hostname="localhost";
$database="user_nuevooriente";
$username="user_cristian";
$password="kunashi1400";
$json=array();
	
				

		$conexion=mysqli_connect($hostname,$username,$password,$database);

		$consulta="SELECT id, subject_Name
		FROM subjectstable";
		$resultado=mysqli_query($conexion,$consulta);

		if($consulta){

			// if($reg=mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
				// $json['datos'][]=$reg;
			// }
			
			while ($row = mysqli_fetch_array($resultado)) {
                $json[] = $row;
            }
			mysqli_close($conexion);
			echo json_encode($json);
		}

		else{
			$results["id"]='';
			$results["subject_Name"]='';
			$json[]=$results;
			echo json_encode($json);
		}
	


 ?>