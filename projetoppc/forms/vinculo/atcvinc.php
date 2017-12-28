<?php
require_once 'c:\wamp64\www\projetoppc\dao\disciplinasatcdao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcdao.php';
require_once 'c:\wamp64\www\projetoppc\dao\disciplinadao.php';
require_once 'c:\wamp64\www\projetoppc\dao\atividadecomplementardao.php';
$ppccod = isset($_GET["ppccod"]) ? $_GET["ppccod"] : "";
$discod = isset($_GET["discod"]) ? $_GET["discod"] : "";
if (empty($ppccod) && empty($discod)) :
    ?>
<div class="text-danger">
	<p>
		Por favor, selecione um <abbr class="text-uppercase">ppc</abbr> e uma
		disciplina.
	</p>
</div>
<br>
<?php
    return;
endif;

$vinculos = buscarVinculosPorPpcEDisciplina($ppccod, $discod);
if (! empty($vinculos)) :
    ?>
<h1 class="text-center">Atividades complementares vinculadas por
	conteúdo curricular</h1>
<br>
<table class="table table-bordered">
	<caption>Atividades complementares vinculadas por conteúdo curricular</caption>
	<thead>
		<tr>
			<th>Atividade complementar</th>
			<th>Disciplina</th>
			<th>Curso</th>
			<th>Ação</th>
		</tr>
	</thead>
	<tbody>
<?php
    foreach ($vinculos as $vinculo) :
        $ppc = buscarPpcPorId($vinculo["ppccod"]);
        $disciplina = buscarDisciplinaPorId($vinculo["discod"]);
        ?>
<tr>
			<td><?=$vinculo["atcdesc"]; ?></td>
			<td><?=$disciplina["disnome"]; ?></td>
			<td><?=$ppc["curnome"]; ?></td>
			<td><a
				href="?pagina=vinculo3&opcao=excluir&ppccod=<?=$vinculo["ppccod"]; ?>&discod=<?=$vinculo["discod"]; ?>&atccod=<?=$vinculo["atccod"]; ?>">Desvincular
					atividade complementar</a></td>
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
	<p>Nenhuma atividade complementar vinculada com este PPC e com esta
		disciplina.</p>
</div>
<br>
<?php
    return;
endif;
?>