<?php namespace core;
	
	/**
	* Clase de códigos
	*/
	class codes 
	{
		
		public static function errors($code)
		{
			$libraryCodes = array(

				'ERR001' => 'Credenciales incorrectas', // Credenciales de contacto
				'ERR002' => 'Credenciales incorrectas o no es usuarios Salesforce', // Credenciales de usuarios salesforce
				'ERR003' => 'Credenciales incorrectas', // Credenciales de web service
				'ERR404' => 'La página no se encontro',  // No se encontro la página / controlador
				'ERR005' => 'Usuario no definido', // Credenciales de web service


				'ERR006' => 'NOT_DELIVERED' // Credenciales de web service
			);


			return $libraryCodes[ $code ];
		}

		public static function messages($code)
		{
			$libraryCodes = array(

				'MESS001' => 'Credenciales correctas', // Credenciales de contacto
				'MESS002' => 'Credenciales correctas', // Credenciales de usuarios
				'MESS003' => 'Credenciales correctas', // Credenciales de usuarios
				'MESS004' => 'Verificando usuario Salesforce', // Credenciales de usuarios
				'MESS005' => 'Contraseña registrada' // Credenciales de usuarios

			);


			return $libraryCodes[ $code ];
		}
	}

?>