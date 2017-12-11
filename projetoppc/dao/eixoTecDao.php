<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirEixoTec($eixdesc, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoeixotec = $conn->prepare("insert into eixotec (eixdesc) values (:eixdesc)");
    $insercaoeixotec->bindParam(":eixdesc", $eixdesc);
    $resultado = $insercaoeixotec->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarEixoTec($eixcod, $eixdesc, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaoeixotec = $conn->prepare("update eixotec set eixdesc = :eixdesc where eixcod = :eixcod");
    $atualizacaoeixotec->bindParam(":eixdesc", $eixdesc);
    $atualizacaoeixotec->bindParam(":eixcod", $eixcod);
    $resultado = $atualizacaoeixotec->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirEixoTec($eixcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $deleixotec = $conn->prepare("delete from eixotec where eixcod = :eixcod");
    $deleixotec->bindParam(":eixcod", $eixcod);
    $resultado = $deleixotec->execute();
    ajustarChavesPrimariasEixotec();
    ajustarAutoIncrementoEixotec();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarEixosTec(&$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->query("select * from eixotec");
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoeseixotec[$i] = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function buscarEixosTecOrdenadosPorDescricao(&$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->query("select * from eixotec order by eixdesc");
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoeseixotec[$i] = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function buscarEixoTecPorId($eixcod, &$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->prepare("select * from eixotec where eixcod = :eixcod");
    $consultaeixotec->bindParam(":eixcod", $eixcod);
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros == 1) {
            $informacoeseixotec = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function buscarEixosTecExceto($eixcod, &$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->prepare("select * from eixotec where eixcod <> :eixcod");
    $consultaeixotec->bindParam(":eixcod", $eixcod);
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoeseixotec[$i] = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function buscarEixoTecPorDescricao($eixdesc, &$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->prepare("select * from eixotec where eixdesc = :eixdesc");
    $consultaeixotec->bindParam(":eixdesc", $eixdesc);
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros == 1) {
            $informacoeseixotec = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function ajustarChavesPrimariasEixotec(&$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $eixostec = buscarEixosTec();
    $query = $conn->prepare("update eixotec set eixcod = :eixcod where eixcod = :eixcod2");
    $chave = 0;
    $numregistros = 0;
    foreach ($eixostec as $eixotec) {
        $chave ++;
        $query->bindParam(":eixcod", $chave);
        $query->bindParam(":eixcod2", $eixotec["eixcod"]);
        if ($query->execute())
            $numregistros ++;
    }
    desconectarDoBanco($conn);
    return $numregistros;
}

function ajustarAutoIncrementoEixotec(&$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $eixostec = buscarEixosTec();
    $autoincrement = count($eixostec) + 1;
    $query = $conn->query("alter table eixotec auto_increment = " . $autoincrement);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}
?>