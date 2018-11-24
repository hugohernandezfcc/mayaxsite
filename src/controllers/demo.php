<?php
/**
 * class responsable of provide demo information.
 */

use Jenssegers\Agent\Agent;

class Demo 
{
	
	public $agent;

	function __construct(){
		$this->agent = new Agent();
	}


	public function index(){

		Application::view(
			array(
				'isMobile' => $this->agent->isMobile(),
				'isTablet' => $this->agent->isTablet()
			)
		);

	}
}
?>