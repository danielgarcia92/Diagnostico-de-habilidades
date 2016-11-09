$(document).on('ready', preguntasSel);

function preguntasSel() {
	$.ajax({
        type        : 'post',
        url         : 'Encuesta/preguntasSel',
        dataType    : 'json',
        encode      : true
    })
    .error(function(){
        alert('Problemas de conexión, por favor intentelo más tarde');
        setTimeout(function(){ window.location.href = 'Encuesta' }, 2000);
    })
    .done(function (datos) {
    	var tag = '';
    	var cont = 0;
		for(var i=0; i < datos.preguntas.longitud; i++) {
			if (datos.preguntas.resultados[i].preguntaTipo == 1) {
				if (cont == 0) {
					tag += "<table>";
					tag += "<tr><td><p style='background: url(varios/imagenes/td.png); min-height: 40px; padding-left:2%; padding-right: 2%'><B>Instrucciones: </B>"+datos.preguntas.resultados[i].titulo+"</p></td></tr>";
					tag += "</table><br>";
				}
				cont = 1;
		     	tag += "<label style='padding-left:2%; padding-right: 2%'>* "+datos.preguntas.resultados[i].preguntaId+". "+datos.preguntas.resultados[i].pregunta+"</label><br>";
		     	for (var j=0; j < datos.respuestas[i].longitud; j++) {
		     		tag += "<div class='radio' style='padding-left:2%; padding-right: 2%'><label><input type='radio' name=R"+datos.preguntas.resultados[i].preguntaId+" value="+parseInt(j+1)+" required>"+datos.respuestas[i].resultados[j].respuesta+"</label></div>";
		     	}
		     	tag += "<br>";
		    }else if (datos.preguntas.resultados[i].preguntaTipo == 2) {
		    	if (cont == 1) {
					tag += "<table>";
					tag += "<tr><td><p style='background: url(varios/imagenes/td.png); min-height: 40px; padding-left:2%'><B>Instrucciones: </B>"+datos.preguntas.resultados[i].titulo+"</p></td></tr>";
					tag += "</table><br>";
				}
				cont = 2;
		    	tag += "<table>";
		    	tag += "<tr><td style='width: 70%; padding-left:2%'><label>* "+datos.preguntas.resultados[i].preguntaId+". "+datos.preguntas.resultados[i].pregunta+"</label></td>";
		    	tag += "<td style='width: 10%; padding-left: 5%; font-size: 1vw'><center><div class='radio'><label><input type='radio' name=R"+datos.preguntas.resultados[i].preguntaId+" value="+parseInt(1)+" required>"+datos.respuestas[i].resultados[0].respuesta+"</label></div></center></td>";
		    	tag += "<td style='width: 10%; padding-left: 5%; font-size: 1vw'><center><div class='radio'><label><input type='radio' name=R"+datos.preguntas.resultados[i].preguntaId+" value="+parseInt(2)+" required>"+datos.respuestas[i].resultados[1].respuesta+"</label></div></center></td>";
		    	tag += "</tr></table><hr><br>";
		    }else if (datos.preguntas.resultados[i].preguntaTipo == 3) {
		    	if (cont == 2) {
					tag += "<table>";
					tag += "<tr><td><p style='background: url(varios/imagenes/td.png); min-height: 40px; padding-left:2%'><B>Instrucciones: </B>"+datos.preguntas.resultados[i].titulo+"</p></td></tr>";
					tag += "</table><br>";
				}
				cont = 3;
		     	tag += "<label style='padding-left:2%; padding-right: 2%'>* "+datos.preguntas.resultados[i].preguntaId+". "+datos.preguntas.resultados[i].pregunta+"</label><br>";
		     	for (var j=0; j < datos.respuestas[i].longitud; j++) {
		     		tag += "<div class='radio' style='padding-left:2%; padding-right: 2%'><label><input type='radio' name=R"+datos.preguntas.resultados[i].preguntaId+" value="+parseInt(j+1)+" required>"+datos.respuestas[i].resultados[j].respuesta+"</label></div>";
		     	}
		     	tag += "<br>";
		    }
		}
	    $("#preguntas").html("");
		$("#preguntas").append(tag);
	});
}
