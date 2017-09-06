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
	eixdesc.value = contentEixdesc.toUpperCase();
}
