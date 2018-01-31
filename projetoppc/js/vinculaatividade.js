/**
 * 
 */
$("#frm-vincular").on("change", exibirVinculo);

function exibirVinculo() {
	var ppccod = $("#ppccod").val();
	var discod = $("#discod").val();
	if (ppccod != "-1" && discod != "-1") {
		$.get("http://localhost/projetoppc/forms/vinculo/atcvinc.php", {
			ppccod: ppccod,
			discod: discod
		}, function (result, status, xhr) {
			if (status == "success") {
				$("#atc-vinc").html(result);
			}
		});
	} else if (ppccod == "-1" && discod != "-1") {
		$("#atc-vinc").html("<span>Selecione um PPC</span>");
	} else if (ppccod != "-1" && discod == "-1") {
		$("#atc-vinc").html("<span>Selecione uma disciplina</span>");
	} else {
		$("#atc-vinc")
			.html(
			"<span>Selecione um PPC e uma disciplina</span>");
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
			alert("Não foi possível executar a requisição." + error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=vinculo3&opcao=cadastrar";
}