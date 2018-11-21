<?php

/**
 * 
 */
class Home
{
	
	function __construct()
	{
		//echo "ejecutado desde el inicio<br/>";
	}

	public function index(){
		Application::view(
			array(
				'variable' => 'hugo daniel hernández'
			)
		);
	}

}

?>