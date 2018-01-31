<?php
require_once 'c:\wamp64\www\projetoppc\dao\eixoTematicoDao.php';
?>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de eixos
		temáticos</h2>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="eixtdes">Eixo temático: <span>*</span></label> <input
				type="text" name="eixtdes" id="eixtdes" class="form-control"
				placeholder="Eixo Temático" tabindex="1" oninput="formatarValor()"
				required>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar"
				name="bt-form-salvar" tabindex="2">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $eixtdes = isset($_POST["eixtdes"]) ? $_POST["eixtdes"] : "";
    $eixotem = ! empty($eixtdes) ? buscarEixoTemPorDescricao($eixtdes) : [];
    if (empty($eixtdes)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Preencha o campo do eixo temático.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if (! empty($eixotem)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe um eixo temático cadastrado com esta descrição.<br>";
        echo "Por favor, informe outro eixo temático.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if (preg_match("/[0-9]/", $eixtdes) == 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "O eixo temático não pode conter números.<br>";
        echo "Preencha novamente o formulário.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirEixoTem($_POST["eixtdes"])) {
            echo "<h1 class='textt-success'>Eixo Temático cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotem&opcao=consultar'>Clique aqui para consultar os eixos temáticos cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $eixostematicos = buscarEixosTem();
    $totaleixostem = count($eixostematicos);
    ?>
	<h2 class="text-center text-primary bg-primary">Consultando os eixos
		temáticos</h2>
	<br> <a href="?pagina=eixotem&opcao=cadastrar">Novo eixo temático</a><br>
	<?php
    if ($totaleixostem > 0) :
        ?>
	<h2 class="text-center text-info">Número de eixos temáticos encontrados: <?=$totaleixostem; ?></h2>
	<br>
	<table class="table table-bordered">
		<caption>Eixos Temáticos</caption>
		<thead>
			<tr>
				<th>Eixo Temático</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
	<?php
        foreach ($eixostematicos as $eixo) :
            ?>
	<tr>
				<td><?=$eixo["eixtdes"]; ?></td>
				<td><a
					href="?pagina=eixotem&opcao=alterar&eixtcod=<?=$eixo['eixtcod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=eixotem&opcao=excluir&eixtcod=<?=$eixo['eixtcod']; ?>">Excluir
						eixo temático</a></td>
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
		<h1 class="text-center">Nenhum eixo temático cadastrado no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo eixo temático</p>
	</div>
	<br>
	<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $eixotematico = buscarEixoTemPorId($_GET["eixtcod"]);
    ?>
	<h2>Alteração do eixo temático selecionado</h2>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="eixtdes">Eixo temático: <span>*</span></label> <input
				type="text" name="eixtdes" id="eixtdes" class="form-control"
				value="<?=$eixotematico['eixtdes'] ?>" tabindex="1"
				oninput="formatarValor()" required>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="alterar"
				name="bt-form-alterar" tabindex="2">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $eixtdes = isset($_POST["eixtdes"]) ? $_POST["eixtdes"] : "";
    if (empty($eixtdes)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Preencha o campo do eixo temático.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    if (preg_match("/[0-9]/", $eixtdes) == 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "O eixo temático não pode conter números.<br>";
        echo "Preencha novamente o formulário.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    try {
        if (atualizarEixoTem($eixotematico["eixtcod"], $_POST["eixtdes"])) {
            echo "<h1 class= 'text-success'>Eixo temático atualizado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotem&opcao=consultar'>Clique aqui para consultar novamente os eixos temáticos</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $eixotematico = buscarEixoTemPorId($_GET["eixtcod"]);
    ?>
	<h2>Exclusão de eixo temático</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir o eixo temático <?=$eixotematico["eixtdes"]; ?>.<br>
				Você realmente deseja executar esta operação?<br> Após a
				confirmação, esta operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="sim" class="btn btn-default" tabindex="1"
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
            if (excluirEixoTem($eixotematico["eixtcod"])) {
                echo "<h1 class= 'text-success'>Eixo temático excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=eixotem&opcao=consultar'>Clique aqui para consultar novamente os eixos temáticos</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
	</div>
