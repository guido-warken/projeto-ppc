<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function vincularOfertaComNivelamento($ppccod, $unicod, $nivcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("insert into ofertanivelamento (ppccod, unicod, nivcod) values (:ppccod, :unicod, :nivcod)");
    $query->bindParam(":ppccod", $ppccod);
    $query->bindParam(":unicod", $unicod);
    $query->bindParam(":nivcod", $nivcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function desvincularOfertaDeNivelamento($ppccod, $unicod, $nivcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("delete from ofertanivelamento where ppccod = :ppccod and unicod = :unicod and nivcod = :nivcod");
    $query->bindParam(":ppccod", $ppccod);
    $query->bindParam(":unicod", $unicod);
    $query->bindParam(":nivcod", $nivcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarVinculosPorOferta($ppccod, $unicod, &$conn = null)
{
    $vinculos = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("
SELECT p.ppccod,
p.ppcanoini,
c.curnome,
u.unicod,
u.uninome,
n.nivcod,
n.nivdes
from ppc p
INNER JOIN curso c 
ON p.curcod = c.curcod
INNER JOIN oferta o
on p.ppccod = o.ppccod
INNER JOIN ofertanivelamento o2 
on p.ppccod = o2.ppccod
INNER JOIN unidadesenac u
ON o2.unicod = u.unicod
 INNER join nivelamento n 
ON o2.nivcod = n.nivcod
WHERE p.ppccod = :ppccod and u.unicod = :unicod");
    $consulta->bindParam(":ppccod", $ppccod);
    $consulta->bindParam(":unicod", $unicod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($contador = 0; $contador < $numregistros; $contador ++) {
                $vinculos[$contador] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $vinculos;
        }
    }
    desconectarDoBanco($conn);
    return $vinculos;
}

function buscarNivelamentosDesvinculados($ppccod, $unicod, &$conn = null)
{
    $nivelamentos = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("
SELECT n.* FROM nivelamento n where NOT EXISTS(
    SELECT o.* from ofertanivelamento o WHERE o.nivcod = n.nivcod and o.ppccod = :ppccod and o.unicod = :unicod
)");
    $consulta->bindParam(":ppccod", $ppccod);
    $consulta->bindParam(":unicod", $unicod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($contador = 0; $contador < $numregistros; $contador ++) {
                $vinculos[$contador] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $vinculos;
        }
    }
    desconectarDoBanco($conn);
    return $vinculos;
}

function buscarVinculoPorId($ppccod, $unicod, $nivcod, &$conn = null)
{
    $vinculo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("
SELECT p.ppccod,
p.ppcanoini,
c.curnome,
u.unicod,
u.uninome,
n.nivcod,
n.nivdes
from ppc p
INNER JOIN curso c
ON p.curcod = c.curcod
INNER JOIN ofertanivelamento o
on p.ppccod = o.ppccod
INNER JOIN unidadesenac u
on o.unicod = u.unicod
INNER join nivelamento n
ON n.nivcod = o.nivcod
where o.ppccod = :ppccod and o.unicod = :unicod and o.nivcod = :nivcod");
    $consulta->bindParam(":ppccod", $ppccod);
    $consulta->bindParam(":unicod", $unicod);
    $consulta->bindParam(":nivcod", $nivcod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $vinculo = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $vinculo;
        }
    }
    desconectarDoBanco($conn);
    return $vinculo;
}

?>