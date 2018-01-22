<?php
require_once 'c:\wamp64\www\projetoppc\dao\ofertanivelamentodao.php';
$ppccod = isset($_GET["ppccod"]) ? $_GET["ppccod"] : "";
$unicod = isset($_GET["unicod"]) ? $_GET["unicod"] : "";
if (empty($ppccod) || empty($unicod)) :
    ?>
<div class="text-danger">
	<p>Selecione um PPC e uma unidade do SENAC</p>
</div>
<?php
    return;
endif;

$vinculos = buscarVinculosPorOferta($ppccod, $unicod);
if (! empty($vinculos)) :
    ?>
<h2 class="text-center">Número de ofertas de curso vinculadas com atividades de nivelamento: <?=count($vinculos); ?></h2>
<br>
<table class="table table-bordered">
	<caption>Ofertas vinculadas com uma atividade de nivelamento</caption>
	<thead>
		<tr>
			<th>Ano de início de vigência do <abbr class="text-uppercase">ppc</abbr></th>
			<th>Curso</th>
			<th>Unidade <abbr class="text-uppercase">senac</abbr></th>
			<th>Atividade de nivelamento</th>
			<th>Ação</th>
		</tr>
	</thead>
	<tbody id="tabela-vinculos">
<?php
    foreach ($vinculos as $vinculo) :
        ?>
<tr>
			<td><?=$vinculo["ppcanoini"]; ?></td>
			<td><?=$vinculo["curnome"]; ?></td>
			<td><?=$vinculo["uninome"]; ?></td>
			<td><?=$vinculo["nivdes"]; ?></td>
			<td><a
				href="?pagina=vinculo4&opcao=excluir&ppccod=<?=$vinculo["ppccod"]; ?>&unicod=<?=$vinculo["unicod"]; ?>&nivcod=<?=$vinculo["nivcod"]; ?>">desvincular</a></td>
		</tr>
<?php
    endforeach
    ;
    ?>
</tbody>
</table>
<?php
else :
    ?>
<div class="text-warning">
	<p>Não há nenhuma oferta vinculada com esta atividade de nivelamento.</p>
</div>
<?php
endif;
?>