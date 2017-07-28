<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirOferta($ppccod, $unicod, $ofecont, $ofevagasmat, $ofevagasvesp, $ofevagasnot, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaooferta = $conn->prepare("insert into oferta (ppccod, unicod, ofecont, ofevagasmat, ofevagasvesp, ofevagasnot) values (:ppccod, :unicod, :ofecont, :ofevagasmat, :ofevagasvesp, :ofevagasnot)");
    $insercaooferta->bindParam(":ppccod", $ppccod);
    $insercaooferta->bindParam(":unicod", $unicod);
    $insercaooferta->bindParam(":ofecont", $ofecont);
    $insercaooferta->bindParam(":ofevagasmat", $ofevagasmat);
    $insercaooferta->bindParam(":ofevagasvesp", $ofevagasvesp);
    $insercaooferta->bindParam(":ofevagasnot", $ofevagasnot);
    $resultado = $insercaooferta->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarOferta($ppccod, $unicod, $ofecont, $ofevagasmat, $ofevagasvesp, $ofevagasnot, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaooferta = $conn->prepare("update oferta set ofecont = :ofecont, ofevagasmat = :ofevagasmat, ofevagasvesp = :ofevagasvesp, ofevagasnot = :ofevagasnot where ppccod = :ppccod and unicod = :unicod");
    $atualizacaooferta->bindParam(":ofecont", $ofecont);
    $atualizacaooferta->bindParam(":ofevagasmat", $ofevagasmat);
    $atualizacaooferta->bindParam(":ofevagasvesp", $ofevagasvesp);
    $atualizacaooferta->bindParam(":ofevagasnot", $ofevagasnot);
    $atualizacaooferta->bindParam(":ppccod", $ppccod);
    $atualizacaooferta->bindParam(":unicod", $unicod);
    $resultado = $atualizacaooferta->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirOferta($ppccod, $unicod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $deloferta = $conn->prepare("delete from oferta where ppccod = :ppccod and unicod = :unicod");
    $deloferta->bindParam(":ppccod", $ppccod);
    $deloferta->bindParam(":unicod", $unicod);
    $resultado = $deloferta->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarOfertasPorPpc($ppccod, &$conn = null)
{
    $informacoesoferta = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaoferta = $conn->prepare("select * from oferta where ppccod = :ppccod");
    $consultaoferta->bindParam(":ppccod", $ppccod);
    if ($consultaoferta->execute()) {
        $numregistros = $consultaoferta->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesoferta[$i] = $consultaoferta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesoferta;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesoferta;
}

function buscarOfertasPorUnidade($unicod, &$conn = null)
{
    $informacoesoferta = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaoferta = $conn->prepare("select * from oferta where unicod = :unicod");
    $consultaoferta->bindParam(":unicod", $unicod);
    if ($consultaoferta->execute()) {
        $numregistros = $consultaoferta->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesoferta[$i] = $consultaoferta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesoferta;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesoferta;
}

function buscarOfertaPorId($ppccod, $unicod, &$conn = null)
{
    $informacoesoferta = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaoferta = $conn->prepare("select * from oferta where ppccod = :ppccod and unicod = :unicod");
    $consultaoferta->bindParam(":ppccod", $ppccod);
    $consultaoferta->bindParam(":unicod", $unicod);
    if ($consultaoferta->execute()) {
        $numregistros = $consultaoferta->rowCount();
        if ($numregistros == 1) {
            $informacoesoferta = $consultaoferta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesoferta;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesoferta;
}

?>