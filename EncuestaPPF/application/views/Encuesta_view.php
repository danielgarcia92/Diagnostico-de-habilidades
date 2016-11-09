<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" type="text/css" href="varios/css/Encuesta.css">
		<link rel="shortcut icon" type="image/x-icon" href="varios/imagenes/udem.ico" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="varios/js/Encuesta.js"></script>

		<title>Diagnóstico</title>

	</head>

	<body>

		<div class="pagina">
		<p class="cerrar"><a href="Encuesta/cerrarSesion"><img src='varios/imagenes/cerrar.png' alt="Cerrar Sesión" onmouseover="this.src='varios/imagenes/cerrar2.png'" onmouseout="this.src='varios/imagenes/cerrar.png'"/></a></p>
			<table>
				<tr><th><p style="text-align: center">Diagnóstico sobre conocimientos y actitudes de los temas del Modelo Formativo UDEM</p></th></tr>
			</table>
			<br>
			<p style='padding-left:2%; padding-right: 2%'>
				<B>Introducción</B>
				<br><br>
				El Modelo Formativo de la UDEM busca formar al estudiante en todas sus dimensiones para que encuentre la trascendencia en el servicio a los demás. En función de esto está enfocado en temáticas relevantes en la actualidad, entre las que están: el liderazgo, la participación ciudadana, la interculturalidad y la sostenibilidad.
				<br><br>
				El presente instrumento tiene la intención de medir el nivel de conocimientos y adopción de conductas con los que cuentan nuestros alumnos sobre estas cuatro temáticas y evaluar cómo se modifican estos conocimientos y conductas a lo largo de su vida universitaria.
				<br><br>
				Una vez que respondas el instrumento y puedas revisar tus resultados, te proporcionaremos información valiosa sobre los diferentes recursos con los que cuentas en la UDEM para impulsar tu desarrollo en estos temas.
				<br><br>
				Más adelante,  en el transcurso de tu carrera tendrás oportunidad de responder nuevamente este instrumento y evaluar tu propio avance.
				<br><br>
				Te agradecemos mucho tus respuestas las cuales colaboran a que podamos seguir mejorando la calidad de los programas, cursos y actividades que ofrecemos para nuestros estudiantes.
				<br><br>
				Saludos,
				<br><br>
				Dirección de Comunidad Universitaria
				<br><br>
			</p>

			<div>

				<form action="Encuesta/insertar" method="post">

					<div class="form-group">
						<div id="preguntas"></div>
					</div>

					<input type="submit" value="Enviar" id="enviarBoton">

				</form>

			</div>
			
		</div>
    
	</body>

</html>
