<?php
require_once 'c:\wamp64\www\projetoppc\dao\eixoTecDao.php';
?>
<script src="js/validaformeixotec.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de eixos
		tecnológicos</h2>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="eixdesc">eixo tecnológico: <span>*</span></label> <input
				type="text" id="eixdesc" name="eixdesc" class="form-control"
				placeholder="Nome do eixo tecnológico" tabindex="1"
				oninput="formatarValor()" required>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" class="btn btn-default"
				name="bt-form-salvar" tabindex="2">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $eixdesc = isset($_POST["eixdesc"]) ? $_POST["eixdesc"] : "";
    $eixotec = ! empty($eixdesc) ? buscarEixoTecPorDescricao($eixdesc) : [];
    if (empty($eixdesc)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Preencha o campo da descrição do eixo tecnológico.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if (! empty($eixotec)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe este eixo tecnológico com esta descrição.<br>";
        echo "Preencha novamente o formulário e clique no botâo salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if (preg_match("/[0-9]/", $eixdesc) == 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "O eixo tecnológico não pode conter números.<br>";
        echo "Preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirEixoTec($_POST["eixdesc"])) {
            echo "<h1 class= 'text-success'>Eixo tecnológico cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotec&opcao=consultar'>Clique aqui para consultar os eixos tecnológicos cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $eixostec = buscarEixosTecOrdenadosPorDescricao();
    $totaleixostec = count($eixostec);
    ?>
	<h2 class="text-center text-primary bg-primary">Consulta de eixos
		tecnológicos</h2>
	<br> <a href="?pagina=eixotec&opcao=cadastrar">Novo eixo tecnológico</a><br>
	<?php
    if ($totaleixostec > 0) :
        ?>
		<h2 class="text-center text-info">Número de eixos tecnológicos encontrados: <?=$totaleixostec; ?></h2>
	<br>
	<table class="table table-bordered">
		<caption>Eixos Tecnológicos</caption>
		<thead>
			<tr>
				<th>Eixo Tecnológico</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
		<?php
        foreach ($eixostec as $eixotec) :
            ?>
		<tr>
				<td><?=$eixotec["eixdesc"]; ?></td>
				<td><a
					href="?pagina=eixotec&opcao=alterar&eixcod=<?=$eixotec['eixcod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=eixotec&opcao=excluir&eixcod=<?=$eixotec['eixcod']; ?>">Excluir
						eixo tecnológico</a></td>
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
		<h1 class="text-center">Nenhum eixo tecnológico cadastrado no sistema.</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo eixo tecnológico.</p>
	</div>
	<br>
		<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $eixotec = buscarEixoTecPorId($_GET["eixcod"]);
    ?>
	<h2 class="text-center text-primary bg-primary">Alteração do eixo
		tecnológico selecionado</h2>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="eixdesc">eixo tecnológico</label> <input type="text"
				id="eixdesc" name="eixdesc" class="form-control"
				value="<?=$eixotec['eixdesc']; ?>" tabindex="1"
				oninput="formatarValor()" required>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" class="btn btn-default"
				name="bt-form-alterar" tabindex="2">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $eixdesc = isset($_POST["eixdesc"]) ? $_POST["eixdesc"] : "";
    if (empty($eixdesc)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Preencha o campo da descrição do eixo tecnológico.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    if (preg_match("/[0-9]/", $eixdesc) == 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "O eixo tecnológico não pode conter números.<br>";
        echo "Preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    try {
        if (atualizarEixoTec($eixotec["eixcod"], $_POST["eixdesc"])) {
            echo "<h1 class= 'text-success'>Eixo Tecnológico atualizado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotec&opcao=consultar'>Clique aqui para consultar novamente os eixos tecnológicos</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $eixotec = buscarEixoTecPorId($_GET["eixcod"]);
    ?>
	<h2 class="text-center text-primary bg-primary">Exclusão do eixo
		tecnológico selecionado</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir o eixo tecnológico <?=$eixotec["eixdesc"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, esta ação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="sim" class="btn btn-default"
				onclick="submeterExclusao()">
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="não" class="btn btn-default"
				onclick="negarExclusao()">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirEixoTec($eixotec["eixcod"])) {
                echo "<h1 class= 'text-success'>Eixo tecnológico excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=eixotec&opcao=consultar'>Clique aqui para consultar novamente os eixos tecnológicos</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
	</div>
