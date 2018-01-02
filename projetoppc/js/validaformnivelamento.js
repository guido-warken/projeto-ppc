/**
 * 
 */

function validarFormulario() {
	var nivdes = document.getElementById("nivdes");
	var nivch = document.getElementById("nivch");
	if (nivdes.value.length == 0) {
		alert("O campo atividade complementar deve ser preenchido corretamente");
		nivdes.focus();
		return false;
	}
	if (isNaN(nivch.value) || nivch.value.length == 0) {
		alert("O campo carga horária da atividade complementar deve ser preenchido corretamente");
		nivch.focus();
		return false;
	}
}

function submeterExclusao() {
	$.ajax({
		async : true,
		type : "POST",
		url : document.URL,
		data : {
			escolha : "sim"
		},
		success : function(result, status, xhr) {
			if (status == "success") {
				$(".container").html(result);
				$("#frm-escolha").hide();
			}
		},
		error : function(xhr, status, error) {
			alert("Não foi possível executar a requisição." + error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=figura&opcao=consultar";
}
