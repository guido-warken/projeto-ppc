var formulario = $("#frm-salvar");
formulario.on("change", function (event) {
    if (event.target.id == "nivcod") {
        return;
    }
    var ppccod = $("#ppccod").val();
    var unicod = $("#unicod").val();
    var divNivelamentosVinculados = $("#nivelamentos-vinculados");
    var divNivelamentosNaoVinculados = $("#nivelamentos-nao-vinculados");
    if (ppccod == "-1" && unicod == "-1") {
        divNivelamentosVinculados.html("<span>Selecione um PPC e uma unidade do SENAC</span>");
    } else if (ppccod != "-1" && unicod == "-1") {
        divNivelamentosVinculados.html("<span>Selecione uma unidade do SENAC</span>");
    } else if (ppccod == "-1" && unicod != "-1") {
        divNivelamentosVinculados.html("<span>Selecione um PPC</span>");
    } else {
        listarNivelamentosVinculados(ppccod, unicod, divNivelamentosVinculados);
        listarNivelamentosNaoVinculados(ppccod, unicod, divNivelamentosNaoVinculados);
    }
});
$("button").on("click", function (event) {
    event.preventDefault();
    if (event.target.id == "btn-sim") {
        submeterExclusao();
    } else if (event.target.id == "btn-nao") {
        negarExclusao();
    }
});

function listarNivelamentosVinculados(ppccod = 0, unicod = 0, element) {
    $.get("http://localhost/projetoppc/forms/vinculo/ofevinc.php", {
        ppccod: ppccod,
        unicod: unicod
    },
        function (resultado, textStatus, jqXHR) {
            if (textStatus == "success") {
                element.html(resultado);
            }
        });
}

function listarNivelamentosNaoVinculados(ppccod = 0, unicod = 0, element) {
    $.get("http://localhost/projetoppc/forms/vinculo/ofenvinc.php", {
        ppccod: ppccod,
        unicod: unicod
    },
        function (resultado, textStatus, jqXHR) {
            if (textStatus == "success") {
                element.html(resultado);
            }
        });
}

function submeterExclusao() {
    $.ajax({
        type: "POST",
        url: document.URL,
        data: {
            escolha: "sim"
        },
        success: function (resultado, statusTxt, jqxhr) {
            if (statusTxt == "success") {
                $(".container").html(resultado);
                $("#frm-escolha").hide();
            }
        },
        error: function (xhr, status, error) {
            alert("Erro ao processar a requisição. Causa: " + error);
        }
    });
}

function negarExclusao() {
    location.href = "?pagina=vinculo4&opcao=cadastrar";
}
