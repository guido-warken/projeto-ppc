/**
 * 
 */

$("#frm-salvar").on("submit", validarFormulario);
$("#frm-alterar").on("submit", validarFormulario);

function validarFormulario() {
	var atcdesc = $("#atcdesc").val();
	var atcch = $("#atcch").val();
	if (atcdesc.length == 0) {
		alert("O campo descrição da atividade complementar deve ser preenchido corretamente.");
		$("#atcdesc").focus();
		return false;
	}
	if (isNaN(atcch) || atcch.length == 0) {
		alert("Preencha o campo carga horária da atividade complementar com apenas números");
		$("#atcch").focus();
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
		success: function (result, status, xhr) {
			if (status == "success") {
				$(".container").html(result);
				$("#frm-escolha").hide();
			}
		},
		error: function (xhr, status, error) {
			alert("Erro ao processar a requisição.\n Causa do erro: " + error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=atividade&opcao=consultar";
}
