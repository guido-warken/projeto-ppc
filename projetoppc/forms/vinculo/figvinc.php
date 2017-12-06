<?php
require_once 'c:\wamp64\www\projetoppc\dao\figurappcDao.php';
$ppccod = isset($_GET["ppccod"]) ? $_GET["ppccod"] : "";
if (empty($ppccod)) :
    ?>
<div class="text-danger">
	<p>Por favor, selecione um ppc.</p>
</div>
<br>
<?php
    return;
endif;

$figurasvinculadas = buscarVinculosPorPpc($ppccod);
if (! empty($figurasvinculadas)) :
    ?>
<h2 class="text-center">
	Figuras vinculadas a este <abbr class="text-uppercase">ppc</abbr>
</h2>
<br>
<table class="table table-bordered">
	<caption>Figuras vinculadas</caption>
	<thead>
		<tr>
			<th>Figura</th>
			<th>Ação</th>
		</tr>
	</thead>
	<tbody>
<?php
    foreach ($figurasvinculadas as $figura) :
        ?>
<tr>
			<td><img alt="<?=$figura["figdesc"]; ?>"
				src="http://localhost/projetoppc/forms/figura/verfigura.php?figcod=<?=$figura["figcod"]; ?>"
				class="img-responsive"></td>
			<td><a
				href="?pagina=vinculo2&opcao=excluir&ppccod=<?=$figura["ppccod"]; ?>&figcod=<?=$figura["figcod"]; ?>">Desvincular</a></td>
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
	<h1 class="text-center">
		Nenhuma figura vinculada com este <abbr class="text-uppercase">ppc</abbr>
	</h1>
	<br> <a href="?pagina=vinculo2&opcao=cadastrar">Clique aqui para
		vincular uma figura a um <abbr class="text-uppercase">ppc</abbr>
	</a><br>
</div>
<?php
endif;
?>