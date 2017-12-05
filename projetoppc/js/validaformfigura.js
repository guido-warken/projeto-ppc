/**
 * 
 */
function validarFormulario() {
	var figdesc = document.getElementById("figdesc");
	var figcont = document.getElementById("figcont");
	if (figdesc.value.length == 0) {
		alert("O campo descrição da figura deve ser preenchido corretamente.");
		figdesc.focus();
		return false;
	}
	if (figcont.value.length == 0) {
		alert("Faça o upload de uma imagem do seu computador.");
		figcont.focus();
		return false;
	}
	if (figcont.value.search(/\.png/g) == -1
			&& figcont.value.search(/\.jpg/g) == -1) {
		alert("A extensão do arquivo de imagem deve ser png ou jpg.");
		figcont.focus();
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