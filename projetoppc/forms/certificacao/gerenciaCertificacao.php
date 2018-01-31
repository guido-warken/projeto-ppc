<?php
require_once 'c:\wamp64\www\projetoppc\dao\certificacaoDao.php';
?>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de
		certificação</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="cerdes">Descritivo da certificação: <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="cerdes"
				name="cerdes" required></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="cerreq">Requisitos da certificação: <span>*</span></label>
			<textarea rows="3" cols="3" id="cerreq" name="cerreq"
				class="form-control" required></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="cerch">Carga horária da certificação: <span>*</span></label>
			<input type="number" id="cerch" name="cerch" class="form-control"
				required>
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
    $cerdes = isset($_POST["cerdes"]) ? $_POST["cerdes"] : "";
    $cerreq = isset($_POST["cerreq"]) ? $_POST["cerreq"] : "";
    $cerch = isset($_POST["cerch"]) ? $_POST["cerch"] : "";
    if (empty($cerdes) || empty($cerreq) || ! is_numeric($cerch)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de cadastro de certificações não foram preenchidos corretamente.<br>";
        echo "Preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    $certificacao = ! empty($cerdes) ? buscarCertPorDescricao($cerdes) : [];
    if (! empty($certificacao)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe uma certificação cadastrada com esta descrição.<br>";
        echo "Por favor, digite uma nova descrição.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirCertificacao($cerdes, $cerreq, $cerch)) {
            echo "<h1 class= 'text-center text-success'>Certificação cadastrada com êxito!</h1><br>";
            echo "<a href= '?pagina=certificacao&opcao=consultar'>Clique aqui para consultar as certificações cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $certificacoes = buscarCert();
    $totalcerts = count($certificacoes);
    ?>
	<h2 class="text-center text-primary bg-primary">Consulta de
		certificações</h2>
	<br> <a href="?pagina=certificacao&opcao=cadastrar">Nova certificação</a><br>
	<?php
    if ($totalcerts > 0) :
        ?>
	<h2>Número de certificações encontradas: <?=$totalcerts; ?></h2>
	<br>
	<table class="table table-bordered">
		<caption>Certificações</caption>
		<thead>
			<tr>
				<th>Descritivo da certificação</th>
				<th>Requisitos da certificação</th>
				<th>Carga horária da certificação</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
	<?php
        foreach ($certificacoes as $certificacao) :
            ?>
	<tr>
				<td><?=$certificacao["cerdes"]; ?></td>
				<td><?=$certificacao["cerreq"]; ?></td>
				<td><?=$certificacao["cerch"]; ?> horas </td>
				<td><a
					href="?pagina=certificacao&opcao=alterar&cercod=<?=$certificacao['cercod']; ?>">Alterar
						dados </a></td>
				<td><a
					href="?pagina=certificacao&opcao=excluir&cercod=<?=$certificacao['cercod']; ?>">Excluir
						certificação </a></td>
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
		<h1>Nenhuma certificação cadastrada no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova certificação</p>
	</div>
	<br>
	<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $certificacao = buscarCertPorId($_GET["cercod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Alteração de
		certificação</h2>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="cerdes">Descritivo da certificação: <span>*</span></label>
			<textarea rows="3" cols="3" id="cerdes" name="cerdes"
				class="form-control" onfocus="formatarCampo()" required>
			<?=$certificacao["cerdes"]; ?>
			</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="cerreq">Requisitos da certificação: <span>*</span></label>
			<textarea rows="3" cols="3" id="cerreq" name="cerreq"
				class="form-control" onfocus="formatarCampo()" required>
					<?=$certificacao["cerreq"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="cerch">Carga horária da certificação: <span>*</span></label>
			<input type="number" id="cerch" name="cerch" class="form-control"
				value="<?=$certificacao['cerch']; ?>" required>
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
    $cerdes = isset($_POST["cerdes"]) ? $_POST["cerdes"] : "";
    $cerreq = isset($_POST["cerreq"]) ? $_POST["cerreq"] : "";
    $cerch = isset($_POST["cerch"]) ? $_POST["cerch"] : "";
    if (empty($cerdes) || empty($cerreq) || ! is_numeric($cerch)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de alteração de certificações não foram preenchidos corretamente.<br>";
        echo "Preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        return;
        endif;
    
    $certpordesc = ! empty($cerdes) ? buscarCertPorDescricao($cerdes) : [];
    if (! empty($certpordesc)) :
        if ($certpordesc["cerdes"] != $certificacao["cerdes"]) :
            echo "<div class='text-danger'>";
            echo "<p>";
            echo "Já existe uma certificação cadastrada com esta descrição.<br>";
            echo "Por favor, digite uma nova descrição.";
            echo "</p>";
            echo "</div>";
            echo "<br>";
            return;
        endif;
        endif;
        
    
    try {
        if (atualizarCert($certificacao["cercod"], $cerdes, $cerreq, $cerch)) {
            echo "<h1 class= 'text-center text-success'>Certificação atualizada com êxito!</h1><br>";
            echo "<a href= '?pagina=certificacao&opcao=consultar'>Clique aqui para voltar à tela de consulta de certificações</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $certificacao = buscarCertPorId($_GET["cercod"]);
    ?>
    <h2 class="text-center text-primary bg-primary">Exclusão da
		certificação</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group" style="resize: both;">
			<p class="text-warning">
    Você está prestes a excluir a certificação com o descritivo: <?=$certificacao["cerdes"]; ?>, com <?=$certificacao["cerch"]; ?> horas.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
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
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirCert($certificacao["cercod"])) {
                echo "<h1 class= 'text-success'>Certificação excluída com êxito!</h1><br>";
                echo "<a href= '?pagina=certificacao&opcao=consultar'>Clique aqui para voltar à tela de consulta de certificações</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, a certificação não será excluída</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de certificações</button><br>";
    }
endif;
?>
	</div>
</body>
</html>