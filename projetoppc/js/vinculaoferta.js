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
