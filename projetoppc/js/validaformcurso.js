/**
 * 
 */
function validarFormulario() {
	var curnome = document.getElementById("curnome");
	var curtit = document.getElementById("curtit");
	var eixcod = document.getElementById("eixcod");
	if (curnome.value.length == 0) {
		alert("O campo nome do curso deve ser preenchido corretamente.");
		curnome.focus();
		return false;
	}
	if (curtit.value.length == 0) {
		alert("O campo titulação do curso deve ser preenchido corretamente.");
		curtit.focus();
		return false;
	}
	if (eixcod.value == "-1") {
		alert("Por favor, selecione um eixo tecnológico.");
		eixcod.focus();
		return false;
	}
}

function formatarCampo() {
	var curtit = document.getElementById("curtit");
	var content = curtit.innerHTML;
	if (content.search(/\t+/g, 0) != -1) {
		content = content.replace(/\t+/g, "");
		curtit.innerHTML = content;
	}
}

function submeterExclusao() {
$.ajax({
	async: true,
	type: "POST",
	url: document.URL,
	data: {
		escolha: "sim"
	},
	success: function(result, status) {
		if (status == "success") {
			$(".container").html(result);
			$("#frm-escolha").hide();
		}
	},
	error: function(xhr, status, error) {
		alert("Erro ao processar a requisição.\n Causa do erro: " + error);
	}
});
}

function negarExclusao() {
	location.href = "?pagina=curso&opcao=consultar";
}