/**
 * 
 */
function validarFormulario() {
	var eixtdes = document.getElementById("eixtdes");
	if (eixtdes.value.length == 0) {
		alert("O campo eixo temático deve ser preenchido corretamente.");
		eixtdes.focus();
		return false;
	}
	if (eixtdes.value.search(/[0-9]/g, 0) != -1) {
		alert("O campo eixo temático não pode conter números.");
		eixtdes.focus();
		return false;
	}
}

function formatarValor() {
	var eixtdes = document.getElementById("eixtdes");
	var contenteixtdes = eixtdes.value;
	for (var i = 0; i < contenteixtdes.length; i++) {
		if (i == 0) {
			contenteixtdes = contenteixtdes.replace(contenteixtdes.charAt(i),
					contenteixtdes.charAt(i).toUpperCase());
			continue;
		}
		contenteixtdes = contenteixtdes.replace(contenteixtdes.charAt(i),
				contenteixtdes.charAt(i).toLowerCase());
	}
	eixtdes.value = contenteixtdes;
}
