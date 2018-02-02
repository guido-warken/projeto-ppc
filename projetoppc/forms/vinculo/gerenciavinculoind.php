<?php
require_once 'c:\wamp64\www\projetoppc\dao\disciplinaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\avaliaDao.php';
?>
<div class="container">
<?php
if ($_GET["opcao"] == "cadastrar") :
    $disciplinas = buscarDisciplinas();
    $indicadores = buscarIndicadores();
    ?>
<h2 class="text-center text-primary bg-primary">Vinculação de
		indicadores com as disciplinas</h2>
	<br>
	<p class="text-info">
		Para vincular uma disciplina com um indicador, selecione uma
		disciplina, e depois selecione um indicador.<br> Ao selecionar uma
		disciplina, aparecerá automaticamente os indicadores vinculados a ela,
		caso haja.
	</p>
	<br>
	<form action="" method="post" id="frm-vincular">
		<div class="form-group">
<?php
    $totaldisciplinas = count($disciplinas);
    if ($totaldisciplinas > 0) :
        ?>
<label for="discod">Selecione a disciplina a ser vinculada: </label> <select
				class="form-control" id="discod" name="discod">
				<option value="-1">Selecione</option>
<?php
        foreach ($disciplinas as $disciplina) :
            ?>
<option value="<?=$disciplina['discod']; ?>">
<?= $disciplina["disnome"];?>
</option>
<?php
        endforeach
        ;
        ?>
</select>
<?php
    else :
        ?>
<div class="text-warning">
				<h1 class="text-center">Não há disciplinas cadastradas no sistema</h1>
				<br> <a href="?pagina=disciplina&opcao=cadastrar">Clique aqui para
					cadastrar uma nova disciplina</a>
			</div>
			<br>
			<?php
        return;
    endif;
    ?>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-5" id="ind-vinc">
				<span>Selecione uma disciplina para ver os indicadores vinculados</span>
			</div>
		</div>
		<br>
		<div class="form-group">
		<?php
    $totalindicadores = count($indicadores);
    if ($totalindicadores == 0) :
        ?>
			<div class="text-warning">
				<h2 class="text-center">Nenhum indicador cadastrado no sistema</h2>
				<br> <a href="?pagina=indicador&opcao=cadastrar">Clique aqui para
					cadastrar um novo indicador</a>
			</div>
		<?php
        return;
    else :
        ?>
		<label for="indcod">Selecione o indicador a ser vinculado:</label> <select
				class="form-control" id="indcod" name="indcod">
				<option value="-1">Selecione:</option>
		<?php
        foreach ($indicadores as $indicador) :
            ?>
		<option value="<?= $indicador['indcod'];?>"><?= $indicador["inddesc"];?></option>
		<?php
        endforeach
        ;
        ?>
		</select>
										<?php
    endif;
    ?>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="vincular" name="bt-form-salvar"
				class="btn btn-default">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $discod = isset($_POST["discod"]) ? $_POST["discod"] : "";
    $indcod = isset($_POST["indcod"]) ? $_POST["indcod"] : "";
    if ($discod == - 1) :
        ?>
	<div class="text-danger">
		<p>Por favor, selecione uma disciplina.</p>
	</div>
	<br>
	<?php
        return;
	endif;
    
    ?>
	<?php
    if ($indcod == - 1) :
        ?>
	<div class="text-danger">
		<p>Por favor, selecione um indicador</p>
	</div>
	<br>
	<?php
        return;
	endif;
    
    $vinculo = buscarVinculoPorId($indcod, $discod);
    if (! empty($vinculo)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Este vínculo já existe. Por favor, altere uma das seleções.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
	endif;
    
    try {
        if (vincularIndicador($indcod, $discod)) {
            echo "<h1 class='text-center text-success'>Vinculação realizada com sucesso!</h1><br>";
            echo "<a href='?pagina=home'>Voltar à tela de início do sistema</a>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
	
    <?php
 elseif ($_GET["opcao"] == "excluir") :
    $vinculo = buscarVinculoPorId($_GET["indcod"], $_GET["discod"]);
    $indicador = buscarIndicadorPorId($vinculo["indcod"]);
    $disciplina = buscarDisciplinaPorId($vinculo["discod"]);
    ?>
<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
Você está prestes a desvincular o indicador <?=$indicador["inddesc"]; ?> da disciplina <?=$disciplina["disnome"]; ?>.<br>
				Tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, esta operação não poderá ser desfeita.
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
            if (desvincularIndicador($vinculo["indcod"], $vinculo["discod"])) {
                echo "<h1 class='text-center text-success'>Indicador desvinculado com sucesso!</h1><br>";
                echo "<a href='?pagina=home'>Voltar à tela inicial</a>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
</div>