<?php
require_once 'c:\wamp64\www\projetoppc\dao\unidadeDao.php';
?>
<script src="js/redirectunidade.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de unidades
		SENAC</h2>
	<br>
	<p class="text-info">
		Para cadastrar uma nova unidade do <abbr class="text-uppercase">senac</abbr>,
		preencha os campos pintados de vermelhos, e marcados com um asterisco.
	</p>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="uninome">Nome da unidade <abbr class="text-uppercase">senac</abbr>:
				<span>*</span></label> <input type="text" name="uninome"
				id="uninome" class="form-control"
				placeholder="nome da unidade SENAC" style="color: red;" required>
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
    $uninome = isset($_POST["uninome"]) ? $_POST["uninome"] : "";
    $unidade = ! empty($uninome) ? buscarUnidadePorNome($uninome) : [];
    
    if (empty($uninome)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, preencha o nome da unidade <abbr class='text-uppercase'>senac</abbr> no campo acima.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if (! empty($unidade)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe uma unidade <abbr class='text-uppercase'>senac</abbr> cadastrada com este nome.<br>";
        echo "Por favor, preencha o nome da nova unidade com outro nome.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirUnidade($uninome)) {
            echo "<h1 class='text-success'>Unidade <abbr class='text-uppercase'>senac</abbr> cadastrada com êxito!</h1><br>";
            echo "<a href= '?pagina=unidade&opcao=consultar'>Clique aqui para ver as unidades cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    ?>
		<h2 class="text-center text-primary bg-primary">
		Consultando as unidades <abbr class="text-uppercase">senac</abbr>
		cadastradas
	</h2>
	<br> <a href="?pagina=unidade&opcao=cadastrar">Nova unidade SENAC</a><br>
							<?php
    $unidades = buscarUnidades();
    $totalunidades = count($unidades);
    if ($totalunidades > 0) :
        ?>
				<h2 class="text-center text-info">Número de unidades SENAC encontradas: <?=$totalunidades; ?></h2>
	<br>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>unidade</th>
				<th colspan="2">ação</th>
			</tr>
		</thead>
		<tbody>
				<?php
        foreach ($unidades as $unidade) :
            ?>
				<tr>
				<td><?=$unidade["uninome"]; ?></td>
				<td><a
					href="?pagina=unidade&opcao=alterar&unicod=<?=$unidade['unicod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=unidade&opcao=excluir&unicod=<?=$unidade['unicod']; ?>">excluir
						unidade SENAC</a></td>
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
        <div class="text-warning bg-info">
		<h2 class="text-center">
			Não há unidades <abbr class="text-uppercase">senac</abbr> cadastradas
			no momento
		</h2>
		<br>
		<p>Clique no link acima para cadastrar uma nova unidade do SENAC no
			sistema.</p>
	</div>
	<br>
				<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    ?>
	<h2 class="text-center">Alteração da unidade selecionada</h2>
	<br>
	<?php
    $unidade = buscarUnidadePorId($_GET["unicod"]);
    ?>
	<form action="" method="post">
		<div class="form-group">
			<label for="uninome">Nome da unidade <abbr class="text-uppercase">senac</abbr>:
				<span>*</span></label> <input type="text" name="uninome"
				id="uninome" class="form-control" value="<?=$unidade["uninome"]; ?>"
				placeholder="Nome da unidade SENAC" style="color: red;" required>
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
    $uninome = isset($_POST["uninome"]) ? $_POST["uninome"] : "";
    
    if (empty($uninome)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, preencha o nome da unidade <abbr class='text-uppercase'>senac</abbr> no campo acima.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    try {
        if (atualizarUnidade($unidade["unicod"], $_POST["uninome"])) {
            echo "<h1 class= 'text-success'>Unidade SENAC atualizada com êxito!</h1><br>";
            echo "<a href= '?pagina=unidade&opcao=consultar'>Clique aqui para consultar novamente as unidades SENAC </a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    ?>
		<h2 class="text-center text-primary bg-primary">
		Exclusão da unidade <abbr class="text-uppercase">senac 
	
	</h2>
	<br>
		<?php
    $unidade = buscarUnidadePorId($_GET["unicod"]);
    ?>
		<form action="" method="post">
		<div class="form-group">
			<p class="text-warning">
				Você está prestes a excluir uma unidade do <abbr
					class="text-uppercase">senac</abbr>.<br>Você tem certeza de que deseja excluir a unidade <?=$unidade["uninome"]; ?>?<br>
				Após a confirmação, esta operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" name="escolha" class="btn btn-default"
				value="sim">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" name="escolha" class="btn btn-default"
				value="não">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirUnidade($unidade["unicod"])) {
                echo "<h1 class= 'text-success'>Unidade SENAC excluída com êxito!</h1><br>";
                echo "<a href= '?pagina=unidade&opcao=consultar'>Voltar à tela de consulta de unidades SENAC</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, a unidade SENAC não será excluída.</p>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de unidades SENAC</button><br>";
    }
endif;
?>
	</div>
