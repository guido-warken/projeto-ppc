<?php
require_once 'c:\wamp64\www\projetoppc\dao\disciplinaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\avaliaDao.php';
?>
<div class="container">
<?php
if ($_GET["opcao"] == "cadastrar") :
    $disciplinas = buscarDisciplinas();
    $indicadores = buscarIndicadores();
    $indnvinc = buscarIndicadoresDesvinculados();
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
	<form action="" method="post">
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
				<h1 class="text-center">Não há disciplinas cadastradas</h1>
				<a href="?pagina=disciplina&opcao=cadastrar">Clique aqui para
					cadastrar uma nova disciplina</a>
			</div>
			<br>
			<?php
        return;
    endif;
    ?>
		</div>
		<div class="col-sm-6" id="ind-vinc"></div>
		<br>
		<div class="form-group">
		<?php
    $totalindicadores = count($indicadores);
    $totalindnvinc = count($indnvinc);
    if ($totalindicadores == 0) :
        ?>
		<div class="text-warning">
				<h2 class="text-center">Nenhum indicador cadastrado no sistema</h2>
				<br> <a href="?pagina=indicador&opcao=cadastrar">Clique aqui para
					cadastrar um novo indicador</a>
			</div>
		<?php
        return;
		endif;
    
    if ($totalindnvinc == 0) :
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
     elseif ($totalindnvinc > 0) :
        ?>
				<select class="form-control" id="indcod" name="indcod">
				<option value="-1">Selecione</option>
				<?php
        foreach ($indnvinc as $indicador) :
            ?>
				<option value="<?=$indicador['indcod']; ?>"><?=$indicador["inddesc"]; ?></option>
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
			<input type="submit" value="vincular" name="bt-form-salvar">
		</div>
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
		endif;

?>
</div>