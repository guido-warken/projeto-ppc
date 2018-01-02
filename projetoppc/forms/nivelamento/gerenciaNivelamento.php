<?php
require_once 'c:\wamp64\www\projetoppc\dao\nivelamentoDao.php';
?>
<script src="js/validaformnivelamento.js"></script>
<div class="container">
<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
<h2 class="text-center text-primary bg-primary">Cadastro de atividades
		de nivelamento</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="nivdes">Atividade de nivelamento: <span>*</span></label>
			<input type="text" id="nivdes" name="nivdes" class="form-control"
				tabindex="1" required>
		</div>
		<br>
		<div class="form-group">
			<label for="nivch">Carga horária: <span>*</span></label> <input
				type="number" id="nivch" name="nivch" class="form-control"
				tabindex="2" required>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar"
				name="bt-form-salvar" tabindex="3">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $nivdes = isset($_POST["nivdes"]) ? $_POST["nivdes"] : "";
    $nivch = isset($_POST["nivch"]) ? $_POST["nivch"] : "";
    if (empty($nivdes)) :
        ?>
<div class="text-danger">
		<p>Preencha corretamente o campo da atividade de nivelamento,
			colocando seu nome / descrição.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if (! is_numeric($nivch)) :
        ?>
<div class="text-danger">
		<p>Preencha corretamente o campo da carga horária da atividade de
			nivelamento com apenas números.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    ?>
<?php
    $nivelamento = buscarNivelamentoPorDescricao($nivdes);
    if (! empty($nivelamento)) :
        ?>
<div class="text-danger">
		<p>
			Já existe uma atividade de nivelamento cadastrada com esta descrição.<br>
			Por favor, preencha outra descrição.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    try {
        if (inserirNivelamento($nivdes, $nivch)) {
            echo "<h1 class='text-center text-success'>Atividade de nivelamento cadastrada com êxito!</h1><br>";
            echo "<a href='?pagina=nivelamento&opcao=consultar'>Clique aqui para ir à tela de consulta das atividades de nivelamento cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $nivelamentos = buscarNivelamentos();
    $totalnivelamentos = count($nivelamentos);
    ?>
<h2 class="text-center text-primary bg-primary">Consulta de atividades
		de nivelamento</h2>
	<br> <a href="?pagina=nivelamento&opcao=cadastrar">Nova atividade de
		nivelamento</a><br>
<?php
    if ($totalnivelamentos > 0) :
        ?>
<h2 class="text-center">Número de atividades de nivelamento encontradas: <?=$totalnivelamentos; ?></h2>
	<br>
	<table class="table table-bordered">
		<caption>Atividades de nivelamento</caption>
		<thead>
			<tr>
				<th>Atividade de nivelamento</th>
				<th>Carga horária</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
<?php
        foreach ($nivelamentos as $nivelamento) :
            ?>
<tr>
				<td><?=$nivelamento["nivdes"]; ?></td>
				<td><?=$nivelamento["nivch"]; ?>h</td>
				<td><a
					href="?pagina=nivelamento&opcao=alterar&nivcod=<?=$nivelamento['nivcod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=nivelamento&opcao=excluir&nivcod=<?=$nivelamento['nivcod']; ?>">Excluir
						atividade de nivelamento</a></td>
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
		<h1 class="text-center">Nenhuma atividade de nivelamento cadastrada no
			sistema.</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova atividade de
			nivelamento.</p>
	</div>
	<br>
<?php
        return;
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $nivelamento = buscarNivelamentoPorId($_GET["nivcod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Alteração da atividade
		de nivelamento selecionada</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="nivdes">Atividade de nivelamento: <span>*</span></label>
			<input type="text" id="nivdes" name="nivdes" class="form-control"
				tabindex="1" value="<?=$nivelamento["nivdes"]; ?>" required>
		</div>
		<br>
		<div class="form-group">
			<label for="nivch">Carga horária: <span>*</span></label> <input
				type="number" id="nivch" name="nivch" class="form-control"
				tabindex="2" value="<?=$nivelamento["nivch"]; ?>" required>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="alterar"
				name="bt-form-alterar" tabindex="3">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $nivdes = isset($_POST["nivdes"]) ? $_POST["nivdes"] : "";
    $nivch = isset($_POST["nivch"]) ? $_POST["nivch"] : "";
    if (empty($nivdes)) :
        ?>
<div class="text-danger">
		<p>Preencha corretamente o campo da atividade de nivelamento,
			colocando seu nome / descrição.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if (! is_numeric($nivch)) :
        ?>
<div class="text-danger">
		<p>Preencha corretamente o campo da carga horária da atividade de
			nivelamento com apenas números.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    ?>
<?php
    $nivpordesc = buscarNivelamentoPorDescricao($nivdes);
    if (! empty($nivpordesc)) :
        if ($nivpordesc["nivdes"] != $nivelamento["nivdes"]) :
            ?>
<div class="text-danger">
		<p>
			Já existe uma atividade de nivelamento cadastrada com esta descrição.<br>
			Por favor, preencha outra descrição.
		</p>
	</div>
	<br>
<?php
            return;
endif;
endif;
        
    
    try {
        if (atualizarNivelamento($nivelamento["nivcod"], $nivdes, $nivch)) {
            echo "<h1 class='text-center text-success'>Atividade de nivelamento atualizada com êxito!</h1><br>";
            echo "<a href='?pagina=nivelamento&opcao=consultar'>Clique aqui para voltar à tela de consulta de atividades de nivelamento</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $nivelamento = buscarNivelamentoPorId($_GET["nivcod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Exclusão de atividade de
		nivelamento</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p>
Você está prestes a excluir a atividade de nivelamento <?=$nivelamento["nivdes"]; ?>.<br>
				Tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, esta operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="button" class="btn btn-default" value="sim"
				onclick="submeterExclusao()">
		</div>
		<br>
		<div class="form-group">
			<input type="button" class="btn btn-default" value="não"
				onclick="negarExclusao()">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $escolha = $_POST["escolha"];
    if ($escolha == "sim") {
        try {
            if (excluirNivelamento($_GET["nivcod"])) {
                echo "<h1 class='text-center text-success'>Atividade de nivelamento excluída com êxito!</h1><br>";
                echo "<a href='?pagina=nivelamento&opcao=consultar'>Clique aqui para voltar à tela de consulta de atividades de nivelamento</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
</div>