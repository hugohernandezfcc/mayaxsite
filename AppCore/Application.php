<?php

	/**
	* Clase encargada de la configuración y herarquias de ejecucón.
	*/
	class Application {
		
		public $router = array(

			/**
			 * IMPORTANTE
			 * 
			 * Arreglo encargado de definir las rutas de vistas y controladores.
			 */

			'templates'       => 'src/templates/',
			'controllers'     => 'src/controllers/'
		

		); 

		public $uri;
		public $ctrl;
		public $username;
		public $password;
		const PERSISTENT_FILES = 'src/persistentfiles/';


		function __construct(){
			/**
			 * Valido que la URL finalice con un "/" para mantener correcta la ejecucón de los
			 * métodos.
			 */
			//echo substr($_SERVER['REQUEST_URI'], -1);
			if(substr($_SERVER['REQUEST_URI'], -1) != '/')
				header ( 'Location: ' . $_SERVER['REQUEST_URI'] . '/' );
			

			$this->uri = explode('/', substr($_SERVER['REQUEST_URI'], 1));
			$this->ctrl = new StdClass();


		}

		/**
		 * Método para cachar la URL y rutear correctamente las clases y métodos a ejecutar.
		 * 
		 */
		public function execute(){
			
			$this->ctrl->controller = (!empty( $this->uri[ $this->setEnv(1) ] ) ) ? $this->uri[ $this->setEnv(1) ] : 'home';
			$this->ctrl->method     = (!empty( $this->uri[ $this->setEnv(2) ] ) ) ? $this->uri[ $this->setEnv(2) ] : 'index';
			$this->ctrl->params     = (!empty( $this->uri[ $this->setEnv(3) ] ) ) ? $this->uri[ $this->setEnv(3) ] : '';


		}

		/**
		 * Método responsable de recibir los datos enviados por método POST
		 * @param  [String] $arg [Nombre de la variable POST]
		 * @return [String]      [Valor  de la variable POST]
		 */
		public static function post($arg){
			
			if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST[$arg]))
				return $_POST[$arg];
			else
				return core\codes::errors('ERR006');
				//return $_POST[$arg];
		}

		/**
		 * Método responsable de recibir los datos enviados por método GET
		 * @param  [String] $arg [Nombre de la variable GET]
		 * @return [String]      [Valor  de la variable GET]
		 */
		public static function get($arg){
			
			if($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET[$arg]))
				return $_GET[$arg];
			else
				return core\codes::errors('ERR006');
		}


		/**
		 * Método responsable de identificar si el desarrollo esta corriendo sobre un servidor local.
		 * @param [Integer] $position [Posisción de los Controladores / Métodos a ejecutar]
		 */
		private function setEnv($position){
			if($_SERVER["HTTP_HOST"] == 'localhost')
				return $position;
			else 
				return $position - 1;			
		}

		/**
		 * Redirecciona la solicitud dependiendo de si esta en desarrollo (En local host) o en producción (En el servidor remoto)
		 * @param  [String] $to [Controlador / Método]
		 */
		public static function redirect($to){
			$uriStr = $_SERVER["HTTP_HOST"] . '/' . ( ($_SERVER["HTTP_HOST"] == 'localhost') ? 'abilia/' : '/' ) . $to;

			$uriStr = str_replace('//', '/', $uriStr);

			header ( 'Location:' . 'http://' . $uriStr );
		}


		/**
		 * Método responsable de correr las clases y métodos cachados desde la URL.
		 * 
		 */
		public function run(){
			$action = $this->ctrl->method;

			if (strpos($action, 'formStep') !== false) 
				$action = 'workForms';

				if($this->existController($this->ctrl->controller)){
					
					$controller = new $this->ctrl->controller();

					if(method_exists($controller, $action))
						$controller->$action();
					else
						$controller->index();

				}else{
					$this->ctrl->controller = 'ExeptionClass';
					$controller = new ExeptionClass();
					$controller->e404();
				}


				
		}
		
		public function existController($controllerName){

			$content = scandir($this->router['controllers'], 1);
			$toReturn = false;

			// echo "<pre>";
			// 	print_r($content);

			for ($i=0; $i < count($content); $i++)  {
				// echo strpos($content[$i], $controllerName);
				// echo strpos($content[$i], $controllerName) . " - " . $content[$i] . ' - ' . $controllerName . '<br/>';
				if(strpos($content[$i], $controllerName) !== false)
					return true;
			}

			return $toReturn;
			
		}


		public static function param(){
			$param = new StdClass();

			$serverRequest = $_SERVER['REQUEST_URI'];
			//(strpos($_SERVER['REQUEST_URI'], 'abilia/') !== false) ? str_replace('abilia/', '', $_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI'];
			//echo $serverRequest;
			$param->uri = explode('/', substr($serverRequest, 1));
			unset($param->uri[count($param->uri)-1]);
			if(strpos($param->uri[count($param->uri)-1], '?') !== false)
				$param->pieces = explode('&', substr($param->uri[count($param->uri)-1], 1));
			else
				$param->id = $param->uri[ count($param->uri)-1 ];


			if(isset($param->pieces)){

				$stdObject = new StdClass();

				for ($i=0; $i < count($param->pieces); $i++) { 
					$obj = explode('=', $param->pieces[$i]);
					$obj0 = $obj[0];

					$stdObject->$obj0 = $obj[1];
				}

				$param->objeto = $stdObject;
			}

			return $param;
		}

		/**
		 * Método principal encargado de mandar los parametros del controlador a la vista.
		 * @param  [Array] $toPush [Valores enviados a la vista]
		 * @return [Array]         [Valores con formato para ser recibidos por el método $twig->render()]
		 */
		public static function view($toPush){
			
			if(!isset($toReturn))
				static $toReturn = NULL;

			if($toReturn == NULL)
				$toReturn = array(
					'dom' => "http://" . $_SERVER["HTTP_HOST"] . '/' . ( ($_SERVER["HTTP_HOST"] == 'localhost') ? 'mayaxsite/' : '' )	
				);
				
			if (count($toPush) > 0) 
				foreach ($toPush as $key => $value) 
					$toReturn[ $key ] = $value;
				
			return $toReturn;
		}	

	}
?>