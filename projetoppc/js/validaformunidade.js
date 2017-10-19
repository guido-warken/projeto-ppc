/**
 * 
 */
function validarFormulario() {
	var uninome = document.getElementById("uninome");
	if (uninome.value.length == 0) {
		alert("O campo nome da unidade SENAC deve ser preenchido corretamente.");
		uninome.focus();
		return false;
	}
	if (uninome.value.search(/[0-9]/g, 0) != -1) {
		alert("O campo nome da unidade SENAC não aceita caracteres numéricos. Digite apenas o nome da unidade.");
		uninome.focus();
		return false;
	}
}

function formatarValor() {
	var uninome = document.getElementById("uninome");
	var contentUninome = uninome.value;
	if (contentUninome.length == 0)
		return;
	contentUninome = contentUninome.replace(contentUninome.charAt(0),
			contentUninome.charAt(0).toUpperCase());
	uninome.value = contentUninome;
	if (contentUninome.search(/senac/i, 0) != -1) {
		contentUninome = contentUninome.replace(/senac/i, "SENAC");
		uninome.value = contentUninome;
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
		success : function(result, status) {
			if (status == "success") {
				$(".container").html(result);
				$("#frm-escolha").hide();
			}
		},
		error : function(xhr, status, error) {
			alert("Erro ao processar a requisição.\n Causa do erro: " + error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=unidade&opcao=consultar";
}
