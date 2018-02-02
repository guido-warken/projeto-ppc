/**
 * 
 */

$("#frm-vincular").change(exibirFigurasVinculadas);

function exibirFigurasVinculadas() {
	var ppccod = $("#ppccod").val();
	if (ppccod == "-1") {
		$("#fig-vinc").html("<span>Selecione um PPC para ver as figuras vinculadas</span>");
		return;
	}
	listarFigurasVinculadas(ppccod);
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
			alert("Não foi possível processar a requisição. Causa do erro: "
				+ error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=vinculo2&opcao=cadastrar";
}

function listarFigurasVinculadas(ppccod = 0) {
	$.get("http://localhost/projetoppc/forms/vinculo/figvinc.php", {
		ppccod: ppccod
	},
		function (resultado, status, xhr) {
			if (status == "success") {
				$("#fig-vinc").html(resultado);
			}
		});
}

