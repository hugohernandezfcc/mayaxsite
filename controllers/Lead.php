<?php
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$message = $_POST['message'];
	$subject = 'Solicito information sobre MAYAX';

	if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)){

		$headers= "MIME-Version: 1.0"."\r\n";
		$headers= "Content-type:text/html;charset=UTF-8"."\r\n";

		$body = '<html>
		 			<head>
		  				<style type="text/css">
			  				body{
			   					background-color: #f8f8f8;
			  				}
			  			</style>
		 			</head>

		 			<body> 
	  					<div class="col-sm-8">
	  						<p>
	  							Hola
	  						</p>	
	  						<p>
	  							Te notificamos que llegó un nuevo prospecto desde el sitio web de MAYAX. br><br>
	  							 - Nombre: <b>'.$name.'</b>. <br><br>
	  							 - Teléfono: <b>'.$phone.'</b>. <br><br>
	  							 - Email: <b>'.$email.'</b>.<br><br>
	  							 - Mensaje: <b>'.$message.'</b>.
	  						</p>
	  						<p>
	  							¡Saludos!.
	  						</p>
	  					</div>
	  					<footer>
  							<div style="margin-bottom: 40px;"></div>
  							<img src="http://mayax.doitcloud.mx/images/cube_.png" width="1200px">
	  					</footer>
		 			</body>
		  		</html>';

		mail('geovany.ruma@gmail.com',$subject,$body,$headers); 
		

		echo 1;
	}else{
		echo 2;
	}
?>