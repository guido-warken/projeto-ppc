<?php
require_once 'c:\wamp64\www\projetoppc\dao\indicadorDao.php';
?>
<script src="js/validaformindicador.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de indicadores</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="inddesc">Digite o indicador: <span>*</span></label>
			<textarea rows="3" cols="3" id="inddesc" name="inddesc"
				class="form-control" required></textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" class="btn btn-default"
				name="bt-form-salvar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $inddesc = isset($_POST["inddesc"]) ? $_POST["inddesc"] : "";
    $indicadorDesc = ! empty($inddesc) ? buscarIndicadorPorDescricao($inddesc) : [];
    if (empty($inddesc)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Preencha o campo de Indicador, e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    if (preg_match("/[0-9+]/", $inddesc) == 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "O campo de Indicador não pode conter números.<br>";
        echo "Preencha novamente o campo Indicador, e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    if (! empty($indicadorDesc)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe um indicador cadastrado com esta descrição.<br>";
        echo "Por favor, informe outra descrição para o novo indicador.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirIndicador($inddesc)) {
            echo "<h1 class= 'text-center text-success'>Indicador cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=indicador&opcao=consultar'>Clique aqui para consultar os indicadores</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $indicadores = buscarIndicadores();
    $totalindicadores = count($indicadores);
    ?>
	<h2 class="text-center text-primary bg-primary">Consulta de indicadores</h2>
	<br> <a href="?pagina=indicador&opcao=cadastrar">Novo indicador</a><br>
	<?php
    if ($totalindicadores > 0) :
        ?>
	<h2 class="text-center">Número de indicadores encontrados: <?=$totalindicadores; ?></h2>
	<br>
	<table class="table table-bordered">
		<caption>Indicadores</caption>
		<thead>
			<tr>
				<th>indicador</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
	<?php
        foreach ($indicadores as $indicador) :
            ?>
	<tr>
				<td><?=$indicador["inddesc"]; ?></td>
				<td><a
					href="?pagina=indicador&opcao=alterar&indcod=<?=$indicador['indcod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=indicador&opcao=excluir&indcod=<?=$indicador['indcod']; ?>">Excluir
						indicador</a></td>
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
		<h1 class="text-center">Nenhum indicador cadastrado no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo indicador</p>
	</div>
	<br>
		<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $indicador = buscarIndicadorPorId($_GET["indcod"]);
    ?>
	<h2 class="text-center text-primary bg-primary">Alteração do indicador
		selecionado</h2>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="inddesc">Digite o indicador: </label>
			<textarea rows="3" cols="3" id="inddesc" name="inddesc"
				class="form-control" onfocus="formatarCampo()" required>
					<?= $indicador["inddesc"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" class="btn btn-default"
				name="bt-form-alterar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $inddesc = isset($_POST["inddesc"]) ? $_POST["inddesc"] : "";
    $indicadorDesc = ! empty($inddesc) ? buscarIndicadorPorDescricao($inddesc) : [];
    
    if (empty($inddesc)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Preencha o campo de Indicador, e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    if (preg_match("/[0-9+]/", $inddesc) == 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "O campo de Indicador não pode conter números.<br>";
        echo "Preencha novamente o campo Indicador, e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    if (! empty($indicadorDesc)) :
        if ($indicadorDesc["inddesc"] != $indicador["inddesc"]) :
            echo "<div class='text-danger'>";
            echo "<p>";
            echo "Já existe um indicador cadastrado com esta descrição.<br>";
            echo "Por favor, informe outra descrição para o indicador a ser alterado.";
            echo "</p>";
            echo "</div>";
            echo "<br>";
            return;
        endif;
        endif;
        
    
    try {
        if (atualizarIndicador($indicador["indcod"], $inddesc)) {
            echo "<h1 class= 'text-center text-success'>Indicador atualizado com êxito!</h1><br>";
            echo "<a href= '?pagina=indicador&opcao=consultar'>Clique aqui para consultar novamente os indicadores cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $indicador = buscarIndicadorPorId($_GET["indcod"]);
    ?>
	<h2 class="text-center">Exclusão do indicador selecionado</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir o indicador <?=$indicador["inddesc"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, a operação não poderá ser desfeita.
			</p>
		</div>
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
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirIndicador($indicador["indcod"])) {
                echo "<h1 class= 'text-center text-success'>Indicador excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=indicador&opcao=consultar'>Clique aqui para consultar novamente os indicadores</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o indicador não será excluído</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de indicadores</button><br>";
    }
endif;
?>
	</div>
