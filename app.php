<?php

class App{
	private $db = NULL;
	private $user = NULL;

	function __construct() {
		$server = "localhost";
    	$user = "sebas_db";
    	$pass = "BEwqgaF1TW";
    	$bd = "sebas_db";


    	try {
            $this->db = new PDO("mysql:host=".$server."; dbname=".$bd , $user, $pass );
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage() );
        }

        if ( array_key_exists( 'AUTH', $_COOKIE ) ) {

         	$user = json_decode( $_COOKIE[ 'AUTH' ] );

        	if( $user ) $this->user = $user;
	    }
	}


    public function run(){
        $result = '';


		if ( isset( $_REQUEST ) && !empty( $_REQUEST ) ){
			switch ( $_REQUEST[ 'action' ] ) {




	                case 'dashboard': return include( 'templates/dashboard.php' );  break;

	                case 'show-customer':   $result = $this->showCustomer(); break;

	                case 'search-customer': $result = $this->searchCustomer(); break;

	                case 'edit-customer':   
	                    $result = $this->editCustomer($_REQUEST['id']); 
	                break;              

	                case 'update-customer': $result = $this->updateCustomer(); break;
	                
	                case 'delete-customer': 
	                    $result = $this->deleteCustomer($_REQUEST['id']); 
	                break;              
	                
	                case 'show-employee':   
	                	$result = $this->showEmployee();
	                break;

	                case 'search-employee': $result = self::searchEmployee(); break;

	                case 'edit-employee': 
	                    $result = $this->editEmployee($_REQUEST['id']); 
	                break;

	                case 'update-employee': $result = $this->updateEmployee(); break;

	                case 'delete-employee': 
	                    $result = $this->deleteEmployee($_REQUEST['id']);
	                break;  

	                case 'defaulter': $result = $this->defaulter(); break;

	                case 'show-reserve': $result = $this->showReserve(); break;

	                case 'insert-reserve': $result = $this->insertReserve($_REQUEST['id']); break;

//	                case 'calendario': $result = $this->calendario($date); break;
	                case 'calendario': $result = $this->calendario(); break;

	                case 'get-bookings': 
	                	$date = null;
	                	if($_REQUEST['user']) $date = $_REQUEST['user'];
	                	$result = $this->getBookings($date, $instalacion ); 
	                break;

					case 'login':
						if ( $this->login($_REQUEST['user'], $_REQUEST['pass'] ) ){
							
							$user =  $this->login( $_REQUEST['user'], $_REQUEST['pass'] );

							if ( $user ) {
								$result = self::get_template( 'dashboard' );

								//$fecha = Date(' dmy ');
								$this->user = $user;
								
								setcookie( 'AUTH', json_encode( $user ), time() + 24 * 60 * 60 );

							} else {
								$result = self::showLogin([
									'alert' => [
										'type' => 'danger',
										'msg' => 'Usuario o contraseña incorrectos',
									]
								]);
							}

						} else {
							$result = self::showLogin([
								'alert' => [
									'type' => 'danger',
									'msg' => 'Usuario o contraseña incorrectos',
								]
							]);
						}
					break;
					
	                case 'log-off':
	                    session_start();
	                    session_unset();
	                    session_destroy();
	                    setcookie( time() - 1 );
	                    $result = self::showLogin();
	                break;

	                default:
	                    return include( 'templates/dashboard.php' );    
	                break;
	            }
	        
        
        } else {
        	$result = self::showLogin();

        }

      echo (self::print( $result ));
    }

	public static function showLogin($msg = null){
		return self::get_template( 'login', 'form', $msg );
	}

//		return include( 'login','form', ['nombre' => 'LOQUESEA'] );
	public static function get_template( $slug, $nombre = "", $attrs = null ) {
	    // Get the template slug
		if ($nombre) {
	        $slug = "{$slug}-{$nombre}.php";
	    } else {
	        $slug = "{$slug}.php";
	    }

	    $slug = rtrim( $slug, '.php' );
	    $template = $slug . '.php';

	    $file = 'templates/' . $template;

		if ( file_exists( $file ) ) {
		
			if ( $attrs ) extract( $attrs );

	        include( $file );
	    }

	}

	public function showCustomer(){
		if ( $this->user->tipo === 'E' ) {

			$sql = "SELECT * FROM usuario WHERE tipo='S'";
			
			if ( isset( $_REQUEST['dni'] ) ) $sql .= " WHERE DNI LIKE '".$_REQUEST['dni']."'";

			$sql .=" ORDER by Nombre";

			$socios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
			
			return self::get_template( 'socios/socios', null, [
				'socios' => $socios
			]);

		}	else {
			echo"Usuario NO Autorizado";
				return self::get_template( 'dashboard' );
	        }	
	}

	public function searchCustomer(){
		return self::get_template( 'socios/pidesocio' , null, []);
	}
		
	public function editCustomer($id){
		$sql = "SELECT * FROM usuario WHERE IdUser = {$id}";
		$socio = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		
		return self::get_template( 'socios/editasocio', null, [
			'socio' => $socio		
		]);
	}

	public function updateCustomer(){
		extract( $_REQUEST );
		$socio = [
			'IdUser' => $id,
			'DNI' => $dni,			
			'Nombre' => $name,
			'Caso' => $case, 
			'Promo' => $promo,
			'Cuota' => $fee
		];

		$sql = "UPDATE usuario SET IdUser=:IdUser, DNI=:DNI, Nombre=:Nombre, Caso=:Caso, Promo=:Promo, Cuota=:Cuota WHERE IdUser=:IdUser";
		
		if( $this->db->prepare( $sql )->execute( $socio ) === TRUE ) {
			return self::get_template( 'socios/editasocio', null, [
				'socio' => $socio,
				'alert' => [
					'type' => 'success',
					'msg' => 'Cliente actualizado con exito'
				] 
			]);
		} else {

			return 'error';
		}
	}


	public function deleteCustomer($id){
		$sql = "DELETE  FROM usuario WHERE IdUser = {$id}";
		$socios = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		return $this->showCustomer();
	}

	public function defaulter(){
		$sql = "SELECT * FROM pago WHERE deudor = '1'";
		$socios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
			
			return self::get_template( 'socios/deudores', null, [
				'socios' => $socios
			]);
	}


	public function showEmployee(){
		

		if ( $this->user->tipo === 'E' ) {

			$sql = "SELECT * FROM usuario WHERE tipo='E'";

			if ( isset( $_REQUEST['dni'] ) ) $sql .= " WHERE DNI LIKE '".$_REQUEST['dni']."'";
		
			$sql .=" ORDER by Nombre";
			$empleados = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
			
			return self::get_template( 'empleados/empleados', null, [
				'empleados' => $empleados
			]);

		} else {
			echo"Usuario NO Autorizado";
				return self::get_template( 'dashboard' );
	        }		
		
	}


	public function searchEmployee(){
		return self::get_template( 'empleados/pidempleado' , null, []);
	}

	public function editEmployee($id){
		$sql = "SELECT * FROM usuario WHERE IdUser = {$id} AND tipo = 'E';";
		$empleados = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		return self::get_template( 'empleados/editaempleado', null, [
			'empleados' => $empleados		
		]);
	}

	public function updateEmployee(){
		extract( $_REQUEST );
		$empleado = [
			'IdUser' => $id,
			'Nombre' => $name,
			'DNI' => $dni,
			'Sueldo' => $salary
		];

		$sql = "UPDATE usuario SET IdUser=:IdUser, DNI=:DNI, Nombre=:Nombre, Sueldo=:Sueldo WHERE IdUser=:IdUser";
		
		if( $this->db->prepare( $sql )->execute( $empleado ) === TRUE ) {
			return self::get_template( 'empleados/editaempleado', null, [
				'empleados' => $empleado,
				'alert' => [
					'type' => 'success',
					'msg' => 'Empleado actualizado con exito'
				] 
			]);
		} else {
			return 'error';
		}
	}

	public function deleteEmployee($id){
		$sql = "DELETE FROM usuario WHERE IdUser = {$id}";
		$empleados = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		return $this->showEmployee();
	}


	public function showReserve(){
		$sql= "SELECT instalaciones.Nombre_Instalacion, usuario.Nombre, reservas.start FROM reservas INNER JOIN usuario ON usuario.IdUser=reservas.IdUser inner JOIN instalaciones ON instalaciones.Id_Instalacion=reservas.Id_Instalacion ";
		$reservas = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		return self::get_template( 'reservas/tabla' , null, [
			'reservas' => $reservas
		]);
	}	

	public function insertReserve( $instalacion, $start ){
		if ( $instalacion && $start && $this->user ){
			$sql = "INSERT INTO `reservas`(`Id_Instalacion`, `start`, `IdUser`) VALUES ('{$instalacion}','{$start}', '{ $this->user['IdUser'] })')";
			$reservas = $this->db->prepare( $sql );
			execute($reservas);
			
			return self::get_template( 'reservas/calendario' , null, [
				'reservas' => $reservas
			]);

		} else {
			//TODO!
			return 'error';
		}
	}

//	public function calendario($date ){
	public function calendario( ){
			$sql = "SELECT Id_Instalacion, Nombre_Instalacion FROM instalaciones";
			$instalaciones = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
			return self::get_template( 'reservas/calendario' , null, [
				'instalaciones' => $instalaciones
			]);
/*
			if ($instalaciones === true ){
				$sql1 = "SELECT Id_Reservas, HOUR(start) FROM reservas WHERE DATE(start) = {$date}";
				$horas = $this->db->query( $sql1 )->fetchAll(PDO::FETCH_ASSOC);
				return self::get_template( 'reservas/calendario' , null, [
					'reservas' => $horas
				]);
			}
*/			
	}

	public function login( $user, $pass) {
		$sql = "SELECT usuario.usuario, usuario.tipo, usuario.DNI, usuario.Nombre, usuario.caso, usuario.cuota, usuario.promo, usuario.sueldo FROM usuario WHERE usuario LIKE '{$user}' AND password LIKE '{$pass}';";
		$query = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
       	
       	if ( is_array( $query ) && !empty( $query ) ) return $query;        
        return false;
	}

	public function getBookings( $date=null, $instalacion=null ){
		$sql = "SELECT reservas.Id_Reservas as 'id', instalaciones.Nombre_Instalacion as 'instalacion', usuario.Nombre as 'usuario', reservas.start as 'init' FROM reservas INNER JOIN usuario ON usuario.IdUser=reservas.IdUser inner JOIN instalaciones ON instalaciones.Id_Instalacion=reservas.Id_Instalacion ";
        
        if ( $date ) $sql .= 'WHERE init = {$date}';
        if ( $date ) $sql .= 'WHERE instalacion = {$instalacion}';

        //if ( $date ) $sql .= 'WHERE init = {$date} AND instalacion = {$instalacion}';

 		$bookings = $this->db->query( $sql )->fetchAll( PDO::FETCH_ASSOC );
 		
 		foreach( $bookings as $booking ){
 			switch( $booking['instalacion'] ){
 				case 'Fisio': 
 					$letter = '#000000';
 					$background = '#FFF000';
 				break;
 				case 'Gym': 
 					$letter = '#000000';
 					$background = '#F3DAAE';
 				break;      
 				case 'Pisci': 
 					$letter = '#000000';
 					$background = '#AEEEF3';
 				break;  
 				case 'Sala': 
 					$letter = '#000000';
 					$background = '#E7CEF2';
 				break;             	 				           	 				      	 				
 				default:
 					$letter = '#000000';
 					$background = '#FFFFFF';
 				break;
 			}

          	$bookingsList[] = [
				'id' => $booking['id'],
				'title' => 'Reservado',
				'className' => $booking['instalacion'],
				'start'=> $booking['init'],
				'end' => date( 'Y-m-d H:i', strtotime( '+1hour', strtotime( $booking['init'] ) ) ),
				'allDay' => false,
				'color' => $background,
				'textColor' => $letter,
			];
		}
		return json_encode( $bookingsList );
	}

	public static function print($content) {
		ob_start();
		
		echo $content;

		return ob_get_clean();

	}
}