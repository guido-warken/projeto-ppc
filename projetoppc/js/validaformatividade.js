/**
 * 
 */

function validarFormulario() {
	var atcdesc = document.getElementById("atcdesc");
	var atcch = document.getElementById("atcch");
	if (atcdesc.value.length == 0) {
		alert("O campo descrição da atividade complementar deve ser preenchido corretamente.");
		atcdesc.focus();
		return false;
	}
	if (isNaN(atcch.value)) {
		alert("Preencha o campo carga horária da atividade complementar com apenas números");
		atcch.focus();
		return false;
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
		success: function(result, status, xhr) {
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
	location.href = "?pagina=atividade&opcao=consultar";
}