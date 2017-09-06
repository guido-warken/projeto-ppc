/**
 * 
 */
function validarFormulario() {
	var eixdesc = document.getElementById("eixdesc");
	if (eixdesc.value.length == 0) {
		alert("O campo eixo tecnológico deve ser preenchido corretamente.");
		eixdesc.focus();
		return false;
	}
	if (eixdesc.value.search(/[0-9]/g, 0) != -1) {
		alert("O campo eixo tecnológico não pode conter números.");
		eixdesc.focus();
		return false;
	}
}

function formatarValor() {
	var eixdesc = document.getElementById("eixdesc");
	var contentEixdesc = eixdesc.value;
	for (var i = 0; i < contentEixdesc.length; i++) {
		if (i == 0) {
			contentEixdesc = contentEixdesc.replace(contentEixdesc.charAt(i),
					contentEixdesc.charAt(i).toUpperCase());
			continue;
		}
		contentEixdesc = contentEixdesc.replace(contentEixdesc.charAt(i),
				contentEixdesc.charAt(i).toLowerCase());
	}
	eixdesc.value = contentEixdesc;
}
