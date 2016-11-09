<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="../varios/css/Captura.css">
		<link rel="shortcut icon" type="image/x-icon" href="../varios/imagenes/udem.ico" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/highcharts-more.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script type='text/javascript' src='../varios/js/Captura.js'></script>

		<title>Diagnóstico | Captura</title>

	</head>

	<body>
		<div class="pagina">
			<input type="hidden" id="exito" value="<?=$exito;?>">
			<input type="hidden" id="idResul" value="<?=$idResul;?>">
			
			<p class="cerrar"><a href="cerrarSesion"><img src='../varios/imagenes/cerrar.png' alt="Cerrar Sesión" onmouseover="this.src='../varios/imagenes/cerrar2.png'" onmouseout="this.src='../varios/imagenes/cerrar.png'"/></a></p>

			<header>
				<img src="../varios/imagenes/udem.png" alt="Logo UDEM" />
	        	<br/>
	        	<img src="../varios/imagenes/banner.png" alt="banner" />
			</header><br>

			<div id="mensaje" style="font-size: 2vw"><p></p></div>
			<div id="grafica"></div>

    		<img src="../varios/imagenes/banner.png" alt="banner" />
    		<footer  style="font-size:0.8vw">Universidad de Monterrey © UDEM </footer>

    	</div>

	</body>

</html>
