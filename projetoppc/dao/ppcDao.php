<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirPpc($ppcmodal, $ppcobj, $ppcdesc, $ppcestagio, $curcod, $ppcanoini, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoppc = $conn->prepare("insert into ppc (curcod, ppcmodal, ppcobj, ppcdesc, ppcestagio, ppcanoini) values (:curcod, :ppcmodal, :ppcobj, :ppcdesc, :ppcestagio, :ppcanoini)");
    $insercaoppc->bindParam(":curcod", $curcod);
    $insercaoppc->bindParam(":ppcmodal", $ppcmodal);
    $insercaoppc->bindParam(":ppcobj", $ppcobj);
    $insercaoppc->bindParam(":ppcdesc", $ppcdesc);
    $insercaoppc->bindParam(":ppcestagio", $ppcestagio);
    $insercaoppc->bindParam(":ppcanoini", $ppcanoini);
    $resultado = $insercaoppc->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarPpcsPorCurso($curcod, &$conn = null)
{
    $informacoesppc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultappc = $conn->prepare("select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod where curso.curcod = :curcod");
    $consultappc->bindParam(":curcod", $curcod);
    if ($consultappc->execute()) {
        $numregistros = $consultappc->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesppc[$i] = $consultappc->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesppc;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesppc;
}

function buscarPpcPorId($ppccod, &$conn = null)
{
    $informacoesppc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultappc = $conn->prepare("select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod where ppc.ppccod = :ppccod");
    $consultappc->bindParam(":ppccod", $ppccod);
    if ($consultappc->execute()) {
        $numregistros = $consultappc->rowCount();
        if ($numregistros > 0) {
            $informacoesppc = $consultappc->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesppc;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesppc;
}

function atualizarPpc($curcod, $ppcmodal, $ppcobj, $ppcdesc, $ppcestagio, $ppccod, $ppcanoini, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaoppc = $conn->prepare("update ppc set curcod = :curcod, ppcmodal = :ppcmodal, ppcobj = :ppcobj, ppcdesc = :ppcdesc, ppcestagio = :ppcestagio, ppcanoini = :ppcanoini where ppccod = :ppccod");
    $atualizacaoppc->bindParam(":curcod", $curcod);
    $atualizacaoppc->bindParam(":ppcmodal", $ppcmodal);
    $atualizacaoppc->bindParam(":ppcobj", $ppcobj);
    $atualizacaoppc->bindParam(":ppcdesc", $ppcdesc);
    $atualizacaoppc->bindParam(":ppcestagio", $ppcestagio);
    $atualizacaoppc->bindParam(":ppcanoini", $ppcanoini);
    $atualizacaoppc->bindParam(":ppccod", $ppccod);
    $resultado = $atualizacaoppc->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirPpc($ppccod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delppc = $conn->prepare("delete from ppc where ppccod = :ppccod");
    $delppc->bindParam(":ppccod", $ppccod);
    $resultado = $delppc->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarPpcs(&$conn = null)
{
    $informacoesppc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultappc = $conn->query("select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod order by ppc.ppcanoini");
    if ($consultappc->execute()) {
        $numregistros = $consultappc->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesppc[$i] = $consultappc->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesppc;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesppc;
}

function buscarPpcsExceto($ppccod, &$conn = null)
{
    $informacoesppc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultappc = $conn->prepare("select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod where ppc.ppccod <> :ppccod");
    $consultappc->bindParam(":ppccod", $ppccod);
    if ($consultappc->execute()) {
        $numregistros = $consultappc->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesppc[$i] = $consultappc->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesppc;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesppc;
}

?>