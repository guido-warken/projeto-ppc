<div class="container">
<?php
require_once 'c:\wamp64\www\projetoppc\dao\figuradao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcdao.php';
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $figuras = buscarFiguras();
    $totalppcs = count($ppcs);
    $totalfiguras = count($figuras);
    ?>
<h2 class="text-center text-primary bg-primary">
		Inserir uma figura a um <abbr class="text-uppercase">ppc</abbr>
	</h2>
	<br>
	<p>
		Para inserir uma figura, escolha um <abbr class="text-uppercase">ppc</abbr>
		e uma figura, digite a ordem da figura e clique no botão salvar.
	</p>
	<br>
	<form action="" method="post">
		<div class="form-group">
<?php
    if ($totalppcs > 0) :
        ?>
<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr></label>
			<select class="form-control" id="ppccod" name="ppccod">
				<option value="-1">Selecione</option>
<?php
        foreach ($ppcs as $ppc) :
            ?>
<option value="<?=$ppc["ppccod"]; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></option>
<?php
        endforeach
        ;
        ?>
</select>
<?php
    else :
        ?>
<div class="text-warning">
				<h1 class="text-center">
					Nenhum <abbr class="text-uppercase">ppc</abbr> cadastrado no
					sistema
				</h1>
				<br> <a href="?pagina=ppc&opcao=cadastrar">Clique aqui para
					cadastrar um novo <abbr class="text-uppercase">ppc</abbr>
				</a><br>
			</div>
<?php
    endif;
    ?>
</div>
		<br>
		<div class="form-group" id="fig-vinc"></div>
		<br>
		<div class="form-group">
<?php
    if ($totalfiguras > 0) :
        ?>
<label for="figcod">Selecione a figura:</label> <select
				class="form-control" id="figcod" name="figcod">
				<option value="-1">Selecione</option>
<?php
        foreach ($figuras as $figura) :
            ?>
<option value="<?=$figura["figcod"]; ?>"><?=$figura["figdesc"]; ?></option>
<?php
        endforeach
        ;
        ?>
</select>
<?php
    else :
        ?>
<div class="text-warning">
				<h1 class="text-center">Nenhuma figura cadastrada no sistema</h1>
				<br> <a href="?pagina=figura&opcao=cadastrar">Clique aqui para
					cadastrar uma nova figura</a>
			</div>
<?php
endif;
?>
</div>
		<br>
	</form>
<?php
endif;
?>
</div>
