<?php
require_once 'c:\wamp64\www\projetoppc\dao\certificacaoDao.php';
?>
<script src="js/redirectcertificacao.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center">Cadastro de certificação</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="cerdes">Descritivo da certificação: </label> <input
				type="text" id="cerdes" name="cerdes" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label for="cerreq">Requisitos da certificação: </label>
			<textarea rows="3" cols="3" id="cerreq" name="cerreq"
				class="form-control"></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="cerch">Carga horária da certificação: </label> <input
				type="number" id="cerch" name="cerch" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("cerdes", $_POST) && ! array_key_exists("cerreq", $_POST) && ! array_key_exists("cerch", $_POST))
        return;
    try {
        if (inserirCertificacao($_POST["cerdes"], $_POST["cerreq"], $_POST["cerch"])) {
            echo "<h1 class= 'text-success'>Certificação cadastrada com êxito!</h1><br>";
            echo "<a href= '?pagina=certificacao&opcao=consultar'>Clique aqui para consultar as certificações cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $certificacoes = buscarCert();
    $totalcerts = count($certificacoes);
    ?>
	<h2 class="text-center">Consulta de certificações</h2>
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
<h2 class="text-center">Alteração de certificação</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="cerdes">Descritivo da certificação: </label> <input
				type="text" id="cerdes" name="cerdes" class="form-control"
				value="<?=$certificacao['cerdes']; ?>">
		</div>
		<br>
		<div class="form-group">
			<label for="cerreq">Requisitos da certificação: </label>
			<textarea rows="3" cols="3" id="cerreq" name="cerreq"
				class="form-control">
					<?=$certificacao["cerreq"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="cerch">Carga horária da certificação: </label> <input
				type="number" id="cerch" name="cerch" class="form-control"
				value="<?=$certificacao['cerch']; ?>">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="alterar">
		</div>
		<br>
	</form>
			<?php
    if (! array_key_exists("cerdes", $_POST) && ! array_key_exists("cerreq", $_POST) && ! array_key_exists("cerch", $_POST))
        return;
    try {
        if (atualizarCert($certificacao["cercod"], $_POST["cerdes"], $_POST["cerreq"], $_POST["cerch"])) {
            echo "<h1 class= 'text-success'>Certificação atualizada com êxito!</h1><br>";
            echo "<a href= '?pagina=certificacao&opcao=consultar'>Clique aqui para voltar à tela de consulta de certificações</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $certificacao = buscarCertPorId($_GET["cercod"]);
    ?>
    <h2 class="text-center">Exclusão da certificação</h2>
	<br>
	<form action="" method="post">
		<div class="form-group" style="resize: both;">
			<p class="text-warning">
    Você está prestes a excluir a certificação com o descritivo: <?=$certificacao["cerdes"]; ?>, com <?=$certificacao["cerch"]; ?> horas.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, esta operação não poderá ser desfeita.
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