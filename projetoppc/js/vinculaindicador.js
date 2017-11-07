/**
 * 
 */

function exibirVinculo() {
	var discod = document.getElementById("discod");
	if (discod.value == "-1") {
		alert("Por favor, selecione uma disciplina.");
		$("#ind-vinc").html(null);
		return;
	}
	$.get("http://localhost/projetoppc/forms/vinculo/indvinc.php", {
		discod : $("#discod").val()
	}, function(result, status, xhr) {
		if (status == "success") {
			$("#ind-vinc").html(result);
		}
	});
}

function submeterExclusao() {
	$
			.ajax({
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
					alert("Erro ao processar a requisição. \n Causa do erro: "
							+ error);
				}
			});
}

function negarExclusao() {
	location.href = "?pagina=vinculo&opcao=cadastrar";
}