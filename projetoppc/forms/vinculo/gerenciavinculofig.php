<div class="container">
<?php
require_once 'c:\wamp64\www\projetoppc\dao\figuradao.php';
require_once 'c:\wamp64\www\projetoppc\dao\figurappcdao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcdao.php';
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $figuras = buscarFiguras();
    $totalppcs = count($ppcs);
    $totalfiguras = count($figuras);
    ?>
<h2 class="text-center text-primary bg-primary">
		Inserir uma figura em um <abbr class="text-uppercase">ppc</abbr>
	</h2>
	<br>
	<p class="text-info">
		Para inserir uma figura, escolha um <abbr class="text-uppercase">ppc</abbr>
		e uma figura, digite a ordem da figura e clique no botão salvar.<br>
		Ao selecionar um <abbr class="text-uppercase">ppc</abbr>, o sistema
		mostrará automaticamente as figuras vinculadas ao mesmo.
	</p>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" id="frm-vincular">
		<div class="form-group">
<?php
    if ($totalppcs > 0) :
        ?>
<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
				<span>*</span></label> <select class="form-control" id="ppccod"
				name="ppccod">
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
				</a>
			</div>
			<br>
<?php
        return;
    endif;
    ?>
</div>
		<br>
		<div class="form-group" id="fig-vinc">
			<span> Selecione um <abbr class="text-uppercase">ppc</abbr> para ver
				as figuras vinculadas
			</span>
		</div>
		<br>
		<div class="form-group">
<?php
    if ($totalfiguras > 0) :
        ?>
<label for="figcod">Selecione a figura: <span>*</span></label> <select
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
			<br>
<?php
        return;
    endif;
    ?>
</div>
		<br>
		<div class="form-group">
			<label for="figordem">Ordem da figura: <span>*</span></label> <input
				type="number" id="figordem" name="figordem" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar"
				name="bt-form-salvar">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $ppccod = isset($_POST["ppccod"]) ? $_POST["ppccod"] : "";
    $figcod = isset($_POST["figcod"]) ? $_POST["figcod"] : "";
    $figordem = isset($_POST["figordem"]) ? $_POST["figordem"] : "";
    if ($ppccod == - 1) :
        
        ?>
<div class="text-danger">
		<p>
			Selecione um <abbr class="text-uppercase">ppc</abbr>
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if ($figcod == - 1) :
        ?>
<div class="text-danger">
		<p>Selecione uma figura.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if (! is_numeric($figordem)) :
        ?>
<div class="text-danger">
		<p>
			Digite em número a ordem em que a figura deve aparecer no <abbr
				class="text-uppercase">ppc</abbr>
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $figurappc = buscarVinculoPorId($ppccod, $figcod);
    if (! empty($figurappc)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Figura já vinculada.<br>";
        echo "Favor, selecione outra.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
endif;
    
    $figurappc = buscarVinculoPorOrdem($figordem, $ppccod);
    if (! empty($figurappc)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Figura já vinculada com esta ordem.<br>";
        echo "Favor, selecione outra.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (vincularFiguraAPpc($figcod, $ppccod, $figordem)) {
            echo "<h1 class='text-success text-center'>Figura vinculada com êxito!</h1><br>";
            echo "<a href='index.php'>Voltar à tela inicial</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "atualizar") :
    $figurappc = buscarVinculoPorId($_GET["ppccod"], $_GET["figcod"]);
    ?>
<h2 class="text-center text-primary bg-primary">
		Atualização da ordem da figura no <abbr class="text-uppercase">ppc</abbr>
	</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="figordem">Altere a ordem da figura</label> <input
				type="number" id="figordem" name="figordem" class="form-control"
				value="<?=$figurappc["figordem"]; ?>">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="alterar"
				name="bt-form-alterar">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $figordem = isset($_POST["figordem"]) ? $_POST["figordem"] : "";
    if (! is_numeric($figordem)) :
        ?>
<div class="text-danger">
		<p>
			Digite em número a ordem em que a figura deve aparecer no <abbr
				class="text-uppercase">ppc</abbr>.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $vincporordem = buscarVinculoPorOrdem($figordem, $figurappc["ppccod"]);
    if (! empty($vincporordem)) :
        if ($vincporordem["figordem"] != $figurappc["figordem"]) :
            echo "<div class='text-danger'>";
            echo "<p>";
            echo "Figura já cadastrada com esta ordem.<br>";
            echo "Por favor, selecione outra.";
            echo "</p>";
            echo "</div>";
            echo "<br>";
            return;
    endif;
    endif;
        
    
    try {
        if (atualizarVinculo($figurappc["ppccod"], $figurappc["figcod"], $figordem)) {
            echo "<h1 class='text-center text-success'>Figura vinculada atualizada com êxito!</h1><br>";
            echo "<a href='index.php'>Voltar à tela inicial</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $figurappc = buscarVinculoPorId($_GET["ppccod"], $_GET["figcod"]);
    $figura = buscarFiguraPorId($figurappc["figcod"]);
    $ppc = buscarPpcPorId($figurappc["ppccod"]);
    ?>
<h2>
		Desvinculação da figura no <abbr class="text-uppercase">ppc</abbr>
	</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p>Você está prestes a desvincular a <?=$figurappc["figordem"]; ?>ª figura do <abbr
					class="text-uppercase">ppc</abbr> referente ao <?=$ppc["curnome"]; ?>, do ano de <?=$ppc["ppcanoini"]; ?>.<br>
				Veja a figura abaixo:<br> <br> <img alt="<?=$figura["figdesc"]; ?>"
					src="http://localhost/projetoppc/forms/figura/verfigura.php?figcod=<?=$figurappc["figcod"]; ?>"
					class="img-responsive"><br> Você tem certeza de que deseja executar
				esta operação?<br> Após a confirmação, esta operação não poderá ser
				desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-default" id="btn-sim">sim</button>
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-default" id="btn-nao">não</button>
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $escolha = $_POST["escolha"];
    if ($escolha == "sim") {
        try {
            if (desvincularFigura($figurappc["ppccod"], $figurappc["figcod"])) {
                echo "<h1 class='text-center text-success'>Figura desvinculada com êxito!</h1><br>";
                echo "<a href='index.php'>Voltar à tela inicial</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
</div>
