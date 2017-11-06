<?php
require_once 'c:\wamp64\www\projetoppc\dao\avaliaDao.php';
$discod = isset($_GET["discod"]) ? $_GET["discod"] : "";
$indicadoresvinculados = ! empty($discod) ? buscarVinculoPorDisciplina($discod) : [];
if (! empty($indicadoresvinculados)) :
    ?>
<h2 class="text-center">Indicadores vinculados a esta disciplina:</h2>
<table class="table table-bordered">
	<caption>Indicadores vinculados</caption>
	<thead>
		<tr>
			<th>Indicador vinculado</th>
			<th>Ação</th>
		</tr>
	</thead>
	<tbody>
<?php
    foreach ($indicadoresvinculados as $vinculo) :
        ?>
<tr>
			<td><?=$vinculo["inddesc"]; ?></td>
			<td><a href="?pagina=vinculo&opcao=excluir">Desvincular</a></td>
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
	<p>Nenhum indicador vinculado a disciplina selecionada.</p>
</div>
<?php
endif;
?>