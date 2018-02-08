$("#frm-salvar").submit(validarFormulario);
$("#frm-alterar").submit(validarFormulario);
$("#btn-sim").click(submeterExclusao);
$("#btn-nao").click(negarExclusao);

function validarFormulario(event) {
	event.preventDefault();
	var nivdes = $("#nivdes").val();
	var nivch = $("#nivch").val();
	if (nivdes.length == 0) {
		alert("O campo atividade de nivelamento deve ser preenchido corretamente");
		$("#nivdes").focus();
		return;
	}
	if (isNaN(nivch) || nivch.length == 0) {
		alert("O campo carga horária da atividade de nivelamento deve ser preenchido corretamente");
		$("#nivch").focus();
		return;
	}
	submeterFormulario(nivdes, nivch, event.target.id);
}

function submeterExclusao(event) {
	event.preventDefault();
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
			alert("Não foi possível executar a requisição." + error);
		}
	});
}

function negarExclusao(event) {
	event.preventDefault();
	location.href = "?pagina=nivelamento&opcao=consultar";
}

function submeterFormulario(nivdes = "", nivch = 0, idFormulario = "") {
	if (idFormulario == "frm-salvar") {
		$.post(document.URL, {
			nivdes: nivdes,
			nivch: nivch,
			bt_form_salvar: 1
		},
			function (resultado, status, xhr) {
				if (status == "success") {
					console.log("Deu certo!");
					$(".container").html(resultado);
				}
			});
	} else {
		$.post(document.URL, {
			nivdes: nivdes,
			nivch: nivch,
			bt_form_alterar: 1
		},
			function (resultado, status, xhr) {
				if (status == "success") {
					$(".container").html(resultado);
					$("#nivdes").val("");
					$("#nivch").val("");
				}
			});
	}
}

