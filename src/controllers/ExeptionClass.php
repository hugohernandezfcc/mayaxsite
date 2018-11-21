<?php

	/**
	 * class with exeptions in the routes
	 */
	class ExeptionClass 
	{
		
		function __construct()
		{
			
		}

		public function e404()
		{
			Application::view(
			array(
				'variable' => 'No tenemos nada aquí'
			)
		);
		}
	}
?>