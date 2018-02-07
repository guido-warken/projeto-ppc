<?php
require_once 'c:\wamp64\www\projetoppc\dao\atividadecomplementardao.php';
?>
<div class="container">
<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
<h2 class="text-center text-primary bg-primary">Cadastro de atividade
		complementar</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" id="frm-salvar">
		<div class="form-group">
			<label for="atcdesc">Descrição da atividade complementar: <span>*</span></label>
			<input type="text" id="atcdesc" name="atcdesc" class="form-control"
				tabindex="1" required>
		</div>
		<br>
		<div class="form-group">
			<label for="atcch">Carga horária da atividade complementar: <span>*</span></label>
			<input type="number" id="atcch" name="atcch" class="form-control"
				tabindex="2" required>
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-default" tabindex="3">salvar</button>

		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt_form_salvar", $_POST))
        return;
    $atcdesc = isset($_POST["atcdesc"]) ? $_POST["atcdesc"] : "";
    $atcch = isset($_POST["atcch"]) ? $_POST["atcch"] : "";
    if (empty($atcdesc)) :
        ?>
<div class="text-danger">
		<p>
			Dados incorretos.<br> Preencha corretamente o campo da descrição da
			atividade complementar.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if (! is_numeric($atcch)) :
        ?>
<div class="text-danger">
		<p>
			Dados incorretos.<br> Preencha corretamente a carga horária da
			atividade complementar com números.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $atividade = buscarAtividadeComplementarPorDescricao($atcdesc);
    if (! empty($atividade)) :
        ?>
<div class="text-danger">
		<p>
			Já existe uma atividade complementar cadastrada com esta descrição.<br>
			Por favor, preencha uma nova descrição.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    try {
        if (inserirAtividadeComplementar($atcdesc, $atcch)) {
            echo "<h1 class='text-center text-success'>Atividade complementar Cadastrada com êxito!</h1><br>";
            echo "<a href='?pagina=atividade&opcao=consultar'>Clique aqui para consultar as atividades complementares cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $atividades = buscarAtividadesComplementares();
    $totalatividades = count($atividades);
    ?>
<h2 class="text-center text-primary bg-primary">Consulta de atividades
		complementares</h2>
	<br> <a href="?pagina=atividade&opcao=cadastrar">Nova atividade
		complementar</a><br>
<?php
    if ($totalatividades > 0) :
        ?>
<table class="table table-bordered">
		<caption>Atividades complementares</caption>
		<thead>
			<tr>
				<td>Descrição da atividade complementar</td>
				<td>Carga horária</td>
				<td colspan="2">Ação</td>
			</tr>
		</thead>
		<tbody>
<?php
        foreach ($atividades as $atividade) :
            ?>
<tr>
				<td><?=$atividade["atcdesc"]; ?></td>
				<td><?=$atividade["atcch"]; ?></td>
				<td><a
					href="?pagina=atividade&opcao=alterar&atccod=<?=$atividade["atccod"]; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=atividade&opcao=excluir&atccod=<?=$atividade["atccod"]; ?>">Excluir
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
		<h1 class="text-center">Não há atividades complementares cadastradas
			no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova atividade
			complementar.</p>
	</div>
	<br>
<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $atividade = buscarAtividadeComplementarPorId($_GET["atccod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Alteração da atividade
		complementar</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" id="frm-alterar">
		<div class="form-group">
			<label for="atcdesc">Descrição da atividade complementar: <span>*</span></label>
			<input type="text" id="atcdesc" name="atcdesc" class="form-control"
				tabindex="1" value="<?=$atividade["atcdesc"]; ?>" required>
		</div>
		<br>
		<div class="form-group">
			<label for="atcch">Carga horária da atividade complementar: <span>*</span></label>
			<input type="number" id="atcch" name="atcch" class="form-control"
				tabindex="2" value="<?=$atividade["atcch"]; ?>">
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-default" tabindex="3">alterar</button>

		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt_form_alterar", $_POST))
        return;
    $atcdesc = isset($_POST["atcdesc"]) ? $_POST["atcdesc"] : "";
    $atcch = isset($_POST["atcch"]) ? $_POST["atcch"] : "";
    $atccod = $_GET["atccod"];
    if (empty($atcdesc)) :
        ?>
<div class="text-danger">
		<p>
			Dados incorretos.<br> Preencha corretamente o campo da descrição da
			atividade complementar.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if (! is_numeric($atcch)) :
        ?>
<div class="text-danger">
		<p>
			Dados incorretos.<br> Preencha corretamente a carga horária da
			atividade complementar com números.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $atividadepordesc = buscarAtividadeComplementarPorDescricao($atcdesc);
    if (! empty($atividadepordesc)) :
        if ($atividadepordesc["atcdesc"] != $atividade["atcdesc"]) :
            ?>
<div class="text-danger">
		<p>
			Já existe uma atividade complementar cadastrada com esta descrição.<br>
			Por favor, preencha uma nova descrição.
		</p>
	</div>
	<br>
<?php
            return;
endif;
endif;
        
    
    try {
        if (atualizarAtividadeComplementar($atccod, $atcdesc, $atcch)) {
            echo "<h1 class='text-center text-success'>Atividade complementar atualizada com êxito!</h1><br>";
            echo "<a href='?pagina=atividade&opcao=consultar'>Clique aqui para consultar as atividades complementares cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $atividade = buscarAtividadeComplementarPorId($_GET["atccod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Exclusão de atividade
		complementar</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p>Você está prestes a excluir a atividade complementar com a descrição <?=$atividade["atcdesc"]; ?>, com <?=$atividade["atcch"]; ?> horas.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, a operação não poderá ser desfeita.
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
            if (excluirAtividadeComplementar($atividade["atccod"])) {
                echo "<h1 class='text-center text-success'>Atividade complementar excluída com êxito!</h1><br>";
                echo "<a href='?pagina=atividade&opcao=consultar'>Clique aqui para consultar as atividades complementares cadastradas</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
</div>