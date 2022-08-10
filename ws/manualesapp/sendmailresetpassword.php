<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once('db_connect.php');
require_once '/home/servfix/public_html/erp/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$json=array();
$datos = array();
$msg="";
	if(isset($_GET)){
		$email=$_GET['email'];		
		
		try
		{
			$consulta = "SELECT IFNULL(id_usuario,0) AS id_usuario,FROM_BASE64(pass) AS pass FROM cat_usuarios WHERE email_usuario = '$email' AND STATUS = 'A'";
			$resultado = mysqli_query($conexion,$consulta);
			$registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
			$id_usuario = $registro['id_usuario'];
			$password = $registro['pass'];
			
			if($id_usuario > 0){
				//Server settings
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'mail.servfix.com.mx';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'notificaciones@servfix.com.mx';                     //SMTP username
				$mail->Password   = 'espaciomaker';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

				//Recipients
				$mail->setFrom('notificaciones@servfix.com.mx', 'Servfix');
				$mail->addAddress($email, 'Jose User');     //Add a recipient
			   
				
				//Content
				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = 'Envio de password';
				$mail->Body    = 'La contraseña es: '.$password;			
				$success = true;
				$msg = 'Correo enviado';
				$mail->send();
			}else{
				$success = false;
				$msg = 'No se encontro el usuario';				
			}
			
			
			$json['success'] = $success;
			$json['msg'] = $msg;				
			
			mysqli_close($conexion);
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($json);
			
		}catch(Exception $e){
			mysqli_close($conexion);
			$msg = $e;
			
		
		
		}		
	}
	else{
			$msg = 'No se recibieron todos los parametros';
			//$results["id_pago"]="0";
			$json['success'] = false;
			$json['msg'] = $msg;
			
			echo json_encode($json);
	}



 ?>