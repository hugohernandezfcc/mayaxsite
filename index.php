<?php
	

	
	# se cargan los recursos de terceros.
	require_once("vendor/autoload.php" );

	# Se carga la clase de toda la aplicación.
	require_once("AppCore/Application.php" );
	require_once("AppCore/codes.php" );
	

	# Se inicia la aplicación.
	$app = new Application();

	# Se cargan los controladores locales.
	spl_autoload_register(function ($class_name) {
		$app = new Application();


		if (file_exists($app->router['controllers'] . $class_name . '.php')) 
			include $app->router['controllers'] . $class_name . '.php';
		
	});

	# Se genera una instancia para Twig
	Twig_Autoloader::register();


	# Se cachan los parametros que se pasa por la URL Controller / Method / Params
	$app->execute();


	# Se cargan las plantillas que se encuentren dentro de la carpeta templates.
	$loader = new Twig_Loader_Filesystem( $app->router['templates'] );	
	$twig = new Twig_Environment($loader);


	# Se ejecuta la aplicación.
	$app->run();

	

	echo $twig->render($app->ctrl->controller . '.html', 
				Application::view(
					array(
						
					)
				)
			);


?>