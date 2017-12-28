<?php
require_once 'c:\wamp64\www\projetoppc\dao\disciplinasatcdao.php';
require_once 'c:\wamp64\www\projetoppc\dao\atividadeComplementarDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\disciplinaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
?>
<script src="js/vinculaatividade.js"></script>
<div class="container">
<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $disciplinas = buscarDisciplinas();
    $atividades = buscarAtividadesComplementares();
    ?>
<h2 class="text-center text-primary bg-primary">Vinculação de atividade
		complementar em um conteúdo curricular</h2>
	<br>
	<p>
		Para vincular uma atividade complementar a um conteúdo curricular,
		selecione um <abbr class="text-uppercase">ppc</abbr>, uma disciplina e
		uma atividade complementar.<br> Ao selecionar o <abbr
			class="text-uppercase">ppc</abbr> e a disciplina, aparecerão
		automaticamente as atividades complementares vinculadas.
	</p>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
				<span>*</span></label> <select class="form-control" id="ppccod"
				name="ppccod" tabindex="1">
				<option value="-1">Selecione:</option>
<?php
    foreach ($ppcs as $ppc) :
        ?>
<option value="<?=$ppc["ppccod"]; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></option>
<?php
    endforeach
    ;
    ?>
</select>
		</div>
		<br>
		<div class="form-group">
			<label for="discod">Selecione a disciplina: <span>*</span></label> <select
				class="form-control" id="discod" name="discod" tabindex="2"
				onchange="exibirVinculo()">
				<option value="-1">Selecione:</option>
<?php
    foreach ($disciplinas as $disciplina) :
        ?>
<option value="<?=$disciplina["discod"]; ?>"><?=$disciplina["disnome"]; ?></option>
<?php
    endforeach
    ;
    ?>
</select>
		</div>
		<br>
		<div class="form-group" id="atc-vinc"></div>
		<br>
		<div class="form-group">
			<label for="atccod">Selecione a atividade complementar: <span>*</span></label>
			<select class="form-control" id="atccod" name="atccod" tabindex="3">
				<option value="-1">Selecione:</option>
<?php
    foreach ($atividades as $atividade) :
        ?>
<option value="<?=$atividade["atccod"]; ?>"><?=$atividade["atcdesc"]; ?></option>
<?php
    endforeach
    ;
    ?>
</select>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar"
				name="bt-form-salvar" tabindex="4">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $ppccod = isset($_POST["ppccod"]) ? $_POST["ppccod"] : "";
    $discod = isset($_POST["discod"]) ? $_POST["discod"] : "";
    $atccod = isset($_POST["atccod"]) ? $_POST["atccod"] : "";
    if ($ppccod == - 1) :
        ?>
	<div class="text-danger">
		<p>
			Por favor, selecione um <abbr class="text-uppercase">ppc</abbr>.
		</p>
	</div>
	<br>
	<?php
        return;
	endif;
    
    if ($discod == - 1) :
        ?>
	<div class="text-danger">
		<p>Por favor, selecione uma disciplina.</p>
	</div>
	<br>
	<?php
        return;
	endif;
    
    if ($atccod == - 1) :
        ?>
	<div class="text-danger">
		<p>Por favor, selecione uma atividade complementar.</p>
	</div>
	<br>
	<?php
        return;
	endif;
    
    $vinculo = buscarVinculoPorId($ppccod, $discod, $atccod);
    if (! empty($vinculo)) :
        ?>
	<div class="text-danger">
		<p>
			Já existe uma atividade complementar vinculada com este conteúdo
			curricular.<br> Por favor, selecione outro vínculo.
		</p>
	</div>
	<br>
	<?php
        return;
	endif;
    
    try {
        if (vincularAtividadeComplementarAUmConteudoCurricular($ppccod, $discod, $atccod)) {
            echo "<h1 class='text-center text-success'>Atividade complementar vinculada com êxito!</h1><br>";
            echo "<a href='index.php'>Voltar à tela inicial</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $vinculo = buscarVinculoPorId($_GET["ppccod"], $_GET["discod"], $_GET["atccod"]);
    $ppc = buscarPpcPorId($vinculo["ppccod"]);
    $disciplina = buscarDisciplinaPorId($vinculo["discod"]);
    $atividade = buscarAtividadeComplementarPorId($vinculo["atccod"]);
    ?>
<h2>Desvincular atividade complementar do conteúdo curricular</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p>
Você está prestes a excluir o vínculo entre a atividade complementar <?=$atividade["atcdesc"]; ?>, com a disciplina <?=$disciplina["disnome"]; ?> no curso <?=$ppc["curnome"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, a operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="sim" onclick="submeterExclusao()">
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="não" onclick="negarExclusao()">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $escolha = $_POST["escolha"];
    if ($escolha == "sim") {
        try {
            if (desvincularAtividadeComplementarDeUmConteudoCurricular($vinculo["ppccod"], $vinculo["discod"], $vinculo["atccod"])) {
                echo "<h1 class='text-center text-success'>Vínculo excluído com êxito!</h1><br>";
                echo "<a href='index.php'>Voltar à tela inicial </a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
</div>