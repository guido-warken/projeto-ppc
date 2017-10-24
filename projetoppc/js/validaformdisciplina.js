/**
 * 
 */

function validarFormulario() {
	var disnome = document.getElementById("disnome");
	var disobj = document.getElementById("disobj");
	var disch = document.getElementById("disch");
	var discementa = document.getElementById("discementa");
	if (disnome.value.length == 0) {
		alert("O campo nome da disciplina deve ser preenchido corretamente.");
		disnome.focus();
		return false;
	}
	if (disobj.value.length == 0) {
		alert("O campo Objetivo da disciplina deve ser preenchido corretamente.");
		disobj.focus();
		return false;
	}
	if (isNaN(disch.value)) {
		alert("O campo carga horária da disciplina deve ser preenchido corretamente.");
		disch.focus();
		return false;
	}
	if (discementa.value.length == 0) {
		alert("O campo ementa da disciplina deve ser preenchido corretamente.");
		discementa.focus();
		return false;
	}
}

function formatarCampo() {
	var disobj = document.getElementById("disobj");
	var discementa = document.getElementById("discementa");
	var contentDisObj = disobj.value;
	var contentDiscementa = discementa.value;
	if (contentDisObj.search(/\t+/g, 0) != -1) {
		contentDisObj = contentDisObj.replace(/\t+/g, "");
		disobj.value = contentDisObj;
	}
	if (contentDiscementa.search(/\t+/g, 0) != -1) {
		contentDiscementa = contentDiscementa.replace(/\t+/g, "");
		discementa.value = contentDiscementa;
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
			alert("Erro ao processar a requisição. Causa do erro: " + error);
		}
	});
}

function negarExclusao() {
	location.href = "?pagina=disciplina&opcao=consultar";
}