<?php
require_once 'c:\wamp64\www\projetoppc\dao\disciplinaDao.php';
?>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de disciplinas</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="disnome">Nome da disciplina: <span>*</span></label> <input
				type="text" class="form-control" id="disnome" name="disnome"
				required>
		</div>
		<br>
		<div class="form-group">
			<label for="disobj">Objetivos da disciplina: <span>*</span></label>
			<textarea rows="3" cols="3" id="disobj" name="disobj"
				class="form-control" required></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="disch">Carga horária da disciplina: <span>*</span></label>
			<input type="number" id="disch" name="disch" class="form-control"
				required>
		</div>
		<br>
		<div class="form-group">
			<label for="discementa">Ementa da disciplina: <span>*</span></label>
			<textarea rows="3" cols="3" id="discementa" name="discementa"
				class="form-control" required></textarea>
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
    $disnome = isset($_POST["disnome"]) ? $_POST["disnome"] : "";
    $disobj = isset($_POST["disobj"]) ? $_POST["disobj"] : "";
    $disch = isset($_POST["disch"]) ? $_POST["disch"] : "";
    $discementa = isset($_POST["discementa"]) ? $_POST["discementa"] : "";
    $disciplinapornome = ! empty($disnome) ? buscarDisciplinaPorNome($disnome) : [];
    if (empty($disnome) || empty($disobj) || ! is_numeric($disch) || empty($discementa)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de cadastro de disciplinas não estão preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário, e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        return;
        endif;
    
    if ($disch <= 0) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Não pode cadastrar uma disciplina com carga horária em 0 ou abaixo de 0 horas.<br>";
        echo "</p>";
        echo "</div>";
        return;
        endif;
    
    if (! empty($disciplinapornome)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe uma disciplina cadastrada com este nome.<br>";
        echo "Por favor, cadastre a disciplina com outro nome.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    try {
        if (inserirDisciplina($disnome, $disobj, $disch, $discementa)) {
            echo "<h1 class= 'text-success'>Disciplina cadastrada com êxito!</h1><br>";
            echo "<a href= '?pagina=disciplina&opcao=consultar'>Clique aqui para consultar as disciplinas cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $disciplinas = buscarDisciplinas();
    $totaldisciplinas = count($disciplinas);
    ?>
<h2 class="text-center text-primary bg-primary">Exibição das disciplinas
		cadastradas</h2>
	<br> <a href="?pagina=disciplina&opcao=cadastrar">Nova disciplina</a><br>
<?php
    if ($totaldisciplinas > 0) :
        ?>
        <h2 class="text-center text-info">Número de disciplinas encontradas: <?=$totaldisciplinas; ?></h2>
	<br>
	<table class="table table bordered">
		<caption>Disciplinas</caption>
		<thead>
			<tr>
				<th>Nome da disciplina</th>
				<th>Objetivo da disciplina</th>
				<th>Carga horária da disciplina</th>
				<th>Ementa da disciplina</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
<?php
        foreach ($disciplinas as $disciplina) :
            ?>
<tr>
				<td><?=$disciplina["disnome"]; ?></td>
				<td><?=$disciplina["disobj"]; ?></td>
				<td><?=$disciplina["disch"]; ?></td>
				<td><?=$disciplina["discementa"]; ?></td>
				<td><a
					href="?pagina=disciplina&opcao=alterar&discod=<?=$disciplina['discod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=disciplina&opcao=excluir&discod=<?=$disciplina['discod']; ?>">Excluir
						disciplina</a></td>
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
		<h2>Nenhuma disciplina cadastrada no momento</h2>
		<br>
		<p>Clique no link acima para cadastrar uma nova disciplina</p>
	</div>
	<br>
<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $disciplina = buscarDisciplinaPorId($_GET["discod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Alteração dos dados da
		disciplina selecionada</h2>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="disnome">Nome da disciplina: </label> <input type="text"
				class="form-control" id="disnome" name="disnome"
				value="<?=$disciplina['disnome']; ?>">
		</div>
		<br>
		<div class="form-group">
			<label for="disobj">Objetivos da disciplina: </label>
			<textarea rows="3" cols="3" id="disobj" name="disobj"
				class="form-control" onfocus="formatarCampo()">
					<?=$disciplina["disobj"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="disch">Carga horária da disciplina: </label> <input
				type="number" id="disch" name="disch" class="form-control"
				value="<?=$disciplina['disch']; ?>">
		</div>
		<br>
		<div class="form-group">
			<label for="discementa">Ementa da disciplina: </label>
			<textarea rows="3" cols="3" id="discementa" name="discementa"
				class="form-control">
					<?=$disciplina["discementa"]; ?>
					</textarea>
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
    $disnome = isset($_POST["disnome"]) ? $_POST["disnome"] : "";
    $disobj = isset($_POST["disobj"]) ? $_POST["disobj"] : "";
    $disch = isset($_POST["disch"]) ? $_POST["disch"] : "";
    $discementa = isset($_POST["discementa"]) ? $_POST["discementa"] : "";
    $disciplinapornome = ! empty($disnome) ? buscarDisciplinaPorNome($disnome) : [];
    if (empty($disnome) || empty($disobj) || ! is_numeric($disch) || empty($discementa)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de alteração de disciplinas não estão preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário, e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        return;
        endif;
    
    if ($disch <= 0) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Não pode alterarr uma disciplina para uma carga horária em 0 ou abaixo de 0 horas.<br>";
        echo "</p>";
        echo "</div>";
        return;
        endif;
    
    if (! empty($disciplinapornome)) :
        if ($disciplinapornome["disnome"] != $disciplina["disnome"]) :
            echo "<div class='text-danger'>";
            echo "<p>";
            echo "Já existe uma disciplina cadastrada com este nome.<br>";
            echo "Por favor, cadastre a disciplina com outro nome.";
            echo "</p>";
            echo "</div>";
            echo "<br>";
            return;
        endif;
        endif;
        
    
    try {
        if (atualizarDisciplina($disciplina["discod"], $disnome, $disobj, $disch, $discementa)) {
            echo "<h1 class= 'text-success'>Disciplina atualizada com êxito!</h1><br>";
            echo "<a href= '?pagina=disciplina&opcao=consultar'>Clique aqui para consultar novamente as disciplinas</a>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $disciplina = buscarDisciplinaPorId($_GET["discod"]);
    ?>
	<h2>Exclusão da disciplina selecionada</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir a disciplina <?=$disciplina["disnome"]; ?>.<br>
				Você gostaria de executar esta operação?<br> Após a confirmação, a
				operação não poderá ser desfeita.<br>
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
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirDisciplina($disciplina["discod"])) {
                echo "<h1 class= 'text-success'>Disciplina excluída com êxito!</h1><br>";
                echo "<a href= '?pagina=disciplina&opcao=consultar'>Clique aqui para voltar à tela de consulta de disciplinas</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, a disciplina não será excluída</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de disciplinas</button><br>";
    }
endif;
?>
	</div>
