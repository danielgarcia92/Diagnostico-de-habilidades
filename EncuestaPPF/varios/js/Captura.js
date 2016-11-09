$(document).on('ready', funPrincipal);

function funPrincipal() {
	if ($("#exito").val() == true) {
		var tag = "<div id='container'></div>";
		$("#grafica").html("");
		$("#grafica").append(tag);

		$(function () {
			var intentoPorcen = 0;
			var intentoWS = 0;
			$.ajaxSetup({ retryAfter: 1});
			setTimeout('funcionPorcen("")', $.ajaxSetup().retryAfter);

			funcionPorcen = function(paramPorcen) {
				intentoPorcen++;
				$.ajax({
			        type 	 : 'post',
			        url		 : '../Encuesta/porcentajes',
			        data 	 : {'idResul' : $("#idResul").val()},
			        dataType : 'json',
			        encode 	 : true
			    }).error(function() {
			    	if (intentoPorcen < 20) {
						var tag = '<h3>Problemas de conexión.</h3><h5>Estamos experimentando errores al mostrar los resultados de la encuesta. Intento # ' + intentoPorcen + '</h5>';
						$("#mensaje").empty();
						$("#mensaje").append(tag);
						setTimeout('funcionPorcen("' + paramPorcen + '")', $.ajaxSetup().retryAfter);
					} else {
						var tag = '<h3>Problemas de Conexión.</h3><h4>Sus datos fueron almacenados exitosamente pero no fue posible mostrar los resultados. Disculpe los inconvenientes, muchas gracias.</h4>';
						$("#mensaje").empty();
						$("#mensaje").append(tag);
						setTimeout(function(){ window.location.href = 'cerrarSesion' }, 6000);
					}
			    }).done(function (datos) {
			    	$("#mensaje").empty();
			    	$('#container').highcharts({

				        chart: {
				            polar: true,
				            type: 'line'
				        },

				        title: {
				            text: '<b>Modelo Formativo UDEM</b><br/><span style="font-size: 90%">Grado de conocimiento y actitud en temas clave</span><br/><span style="font-size: 70%">' + datos.nombre + '. Matrícula: ' + datos.matricula + '</span>'
				        },

				        pane: {
				            size: '80%',
				            center: ['40%', '50%']
				        },

				        xAxis: {
				            categories: ['Interculturalidad <br/> <B>Nivel: ' + datos.porcInterculturalidad + "</B>", 
				            'Liderazgo <br/> <B>Nivel: ' + datos.porcLiderazgo + "</B>", 
				            'Participación Cívica. Nivel: ' + datos.porcCivica,
				            'Participación Política Nivel: ' + datos.porcPolitica,
				            'Sostenibilidad <br/> <B>Nivel: ' + datos.porcSostenibilidad + "</B>"],
				            tickmarkPlacement: 'on',
				            lineWidth: 0
				        },

				        yAxis: {
				            gridLineInterpolation: 'polygon',
				            lineWidth: 0,
				            min: 0,
				            max:100,
				  			tickInterval: 10,
				  			labels: { enabled: true }
				        },

				        tooltip: {
				            shared: true,
				            headerFormat: '<span>Grado de dominio del tema: </span>',
				            pointFormat: '<span><b>{point.y:,.0f}%</b>'
				        },

				        legend: {
				            align: 'left',
				            verticalAlign: 'bottom',
				            layout: 'vertical'
				        },

				        series: [{
				            name: '<span style="font-size: 65%">' + datos.fecha + '</span>',
				            color: '#ff6600',
				            data: [datos.Interculturalidad, datos.Liderazgo, datos.Civica, datos.Politica, datos.Sostenibilidad],
				            pointPlacement: 'off'
				        }]

				    });

			    	setTimeout('funcionWS("")', $.ajaxSetup().retryAfter);
				    funcionWS = function(paramWS) {
						intentoWS++;
				    	$.ajax({
					        type        : 'get',
					        url         : 'https://ppf.udem.edu/UDEM_PPF/rest/encuesta_dh?token='+datos.token,
					        dataType    : 'json',
					        encode      : true,
					        crossDomain : true,
					        xhrFields: { withCredentials: true }
					    }).error(function() {
					    	if (intentoWS < 20) {
								//var tag = '<h3>Problemas de conexión.</h3><h5>Estamos experimentando errores al enviar el token. Intento # ' + intentoWS + '</h5>';
								//$("#mensaje").empty();
								//$("#mensaje").append(tag);
								setTimeout('funcionWS("' + paramWS + '")', $.ajaxSetup().retryAfter);
							} /*else {
								//var tag = '<h3>Problemas de Conexión.</h3><h4>Sus datos fueron almacenados exitosamente pero no fue posible enviar el token. Disculpe los inconvenientes, muchas gracias.</h4>';
								//$("#mensaje").empty();
								//$("#mensaje").append(tag);
								//setTimeout(function(){ window.location.href = 'cerrarSesion' }, 6000);
							}*/
					    }).done(function(webService) {
					    	if (webService.response == true) {
					    		$.ajax({
							        type 	 : 'post',
							        url 	 : '../Encuesta/actualizarACK',
							        data 	 : {'idResul' : $("#idResul").val()},
							        dataType : 'json',
							        encode 	 : true
							    });
					    	}
					    });
					}
				});
			}

		});
	} else {
		var tag = '<h2>Su encuesta ya se había registrado con anterioridad.</h2>';
		$("#mensaje").empty();
		$("#mensaje").append(tag);
		setTimeout(function(){ window.location.href = 'cerrarSesion' }, 3000);
	}
}
