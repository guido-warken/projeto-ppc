/**
 * 
 */

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
			alert("Erro ao processar a requisição. \n Causa do erro: " + erro);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=perfil&opcao=consultar";
}