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
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost/projetoppc/forms/vinculo/ofevinc.php?ppccod=" + ppccod + "&unicod=" + unicod);
    xhr.addEventListener("load", function () {
        if (this.status == 200) {
            element.innerHTML = this.responseText;
        } else {
            element.innerHTML = "<span>Falha na requisição</span>";
            console.log(this.responseText);
        }
    });
    xhr.send();
}

function listarNivelamentosNaoVinculados(ppccod = 0, unicod = 0, element) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost/projetoppc/forms/vinculo/ofenvinc.php?ppccod=" + ppccod + "&unicod=" + unicod);
    xhr.addEventListener("load", function () {
        if (this.status == 200) {
            element.innerHTML = this.responseText;
        } else {
            element.innerHTML = "<span>Falha na requisição</span>";
            console.log(this.responseText);
        }
    });
    xhr.send();
}