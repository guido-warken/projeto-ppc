/**
 * 
 */
$("#frm-vincular").change(exibirVinculo);

function exibirVinculo() {
	var discod = $("#discod").val();
	if (discod == "-1") {
		$("#ind-vinc").html("<span>Selecione uma disciplina para ver os indicadores vinculados</span>");
		return;
	}
	listarIndicadoresVinculados(discod);
}

$("button").click(function (event) {
	event.preventDefault();
	if (event.target.id == "btn-sim") {
		submeterExclusao();
	} else {
		negarExclusao();
	}
});

function submeterExclusao() {
	$
		.ajax({
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
				alert("Erro ao processar a requisição. \n Causa do erro: "
					+ error);
			}
		});
}

function negarExclusao() {
	location.href = "?pagina=vinculo&opcao=cadastrar";
}

function listarIndicadoresVinculados(discod = 0) {
	$.get("http://localhost/projetoppc/forms/vinculo/indvinc.php", {
		discod: discod
	}, function (result, status, xhr) {
		if (status == "success") {
			$("#ind-vinc").html(result);
		}
	});
}
