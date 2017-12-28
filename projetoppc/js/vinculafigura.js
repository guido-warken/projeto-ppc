/**
 * 
 */

function exibirFigurasVinculadas() {
	var ppccod = document.getElementById("ppccod");
	if (ppccod.value == "-1") {
		alert("Por favor, selecione um PPC.");
		$("#fig-vinc").html(null);
		return;
	}
	$.get("http://localhost/projetoppc/forms/vinculo/figvinc.php", {
		ppccod : $("#ppccod").val()
	}, function(result, status, xhr) {
		if (status == "success") {
			$("#fig-vinc").html(result);
		}
	});
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
			alert("Não foi possível processar a requisição. Causa do erro: "
					+ error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=vinculo2&opcao=cadastrar";
}