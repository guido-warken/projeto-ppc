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

function buscarVinculos($ppccod, &$conn = null)
{
    $vinculos = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("
SELECT p.ppcanoini,
c.curnome,
u.uninome,
n.nivdes
from ppc p
INNER JOIN curso c 
ON p.curcod = c.curcod
INNER JOIN oferta o
on p.ppccod = o.ppccod
INNER JOIN ofertanivelamento o2 
on p.ppccod = o2.ppccod
INNER JOIN unidadesenac u
ON o.unicod = u.unicod and o2.unicod = u.unicod
INNER join nivelamento n 
ON o2.nivcod = n.nivcod
WHERE p.ppccod = :ppccod");
    $consulta->bindParam(":ppccod", $ppccod);
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

?>