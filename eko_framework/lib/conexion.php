<?php
class dbConexion {
	public $link,$dbase;
	private static $instance;
	private $transaction=false;
	
	public function switchDB($dbname){
		mysqli_close(self::$instance->link);
		self::$instance = new dbConexion($basedatos,true);       
    }
		
	 public static function singleton($basedatos=false){
        if (!isset(self::$instance)) {            
			//SI LA CONEXION NO EXISTE
            self::$instance = new dbConexion($basedatos,false);
        }else if (isset(self::$instance) && self::$instance->transaction==false){		
			mysqli_close(self::$instance->link);
			self::$instance = new dbConexion($basedatos,true);
		}
		
        return self::$instance;
    }
	
	public function startTransaction(){
		$this->transaction=true;
		mysqli_query($this->link, 'SET AUTOCOMMIT=0');		
		mysqli_query($this->link, 'START TRANSACTION');		 
	}
	
	public function dbConexion($basedatos=false) {
		$this->transaction=false;
		$this->dbase = ($basedatos) ? $basedatos : DB_NAME; // a cual bd se conecta
		
		//$this->link  = @mysql_connect(DB_HOST, DB_USER, DB_PASS, false, 131074|8192);
		$this->link  = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
		if (!$this->link) {			
			throw new Exception("Error de Conexión: El sistema no pudo conectarse con el servidor de Bases de datos");
			//$response['success']=false;
			//$response['msg']='ERROR: El sistema no pudo conectarse con el servidor de Bases de datos';
			//$response['msg']=mysql_error();
			//echo json_encode($response);
			//exit;
		}
		if (!mysqli_select_db($this->link, $this->dbase)) {
			
			throw new Exception("Error de Conexión: No pudo seleccionarse la base de datos:".mysqli_error());			
		}					
		mysqli_query($this->link, "SET NAMES utf8");
	
	}

   	public function __destruct() {
           // mysql_close( $this->link );
   	}
        
	// public function useMaster(){
		// if (!mysqli_select_db(DB_MASTER,$this->link)) {
		   // throw new Exception(mysql_error());
	   // }
	// }
}
?>