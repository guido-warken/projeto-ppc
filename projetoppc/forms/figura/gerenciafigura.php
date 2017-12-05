
<div class="container">
<?php
require_once 'c:\wamp64\www\projetoppc\dao\figuraDao.php';
if ($_GET["opcao"] == "cadastrar") :
    ?>
<h2 class="text-center text-primary bg-primary">Cadastro de figuras</h2>
	<br>
	<p>Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="figdesc">Descrição da figura: <span>*</span></label> <input
				type="text" id="figdesc" name="figdesc" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label for="figcont">Selecione o arquivo de imagem a ser inserido: <span>*</span></label>
			<input type="hidden" name="max_file_size" value="30000"> <input
				type="file" id="figcont" name="figcont" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" name="bt-form-salvar">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $figdesc = isset($_POST["figdesc"]) ? $_POST["figdesc"] : "";
    $max_file_size = $_POST["max_file_size"];
    $imagem = $_FILES["figcont"];
    if (empty($figdesc)) :
        ?>
<div class="text-danger">
		<p>Por favor Preencha uma descricao para a figura.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $figura = buscarFiguraPorDescricao($figdesc);
    if (! empty($figura)) :
        ?>
<div class="text-danger">
		<p>
			Já existe uma figura cadastrada com esta descrição.<br> Por favor,
			digite outra descrição para a figura.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if (empty($imagem["tmp_name"])) :
        ?>
<div class="text-danger">
		<p>
			Nenhum arquivo selecionado.<br> Por favor, selecione uma imagem do
			seu computador para ser cadastrada.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if ($imagem["size"] > $max_file_size) :
        ?>
<div class="text-danger">
		<p>
			Arquivo maior do que o permitido.<br> Comprima o arquivo e tente
			novamente.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $ext = pathinfo($imagem["name"], PATHINFO_EXTENSION);
    
    if ($ext != "jpg" && $ext != "png") :
        ?>
<div class="text-danger">
		<p>Por favor, selecione imagens do tipo JPG ou PNG.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $arquivo = fopen($imagem["tmp_name"], "rb");
    $figcont = fread($arquivo, filesize($imagem["tmp_name"]));
    fclose($arquivo);
    
    try {
        if (inserirFigura($figdesc, $figcont)) {
            echo "<h1 class='text-success text-center'>Figura inserida com êxito!</h1><br>";
            echo "<a href='?pagina=figura&opcao=consultar'>Clique aqui para consultar as figuras cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 
elseif ($_GET["opcao"] == "consultar") :
    $imagens = buscarFiguras();
    $totalimagens = count($imagens);
    ?>
<h2 class="text-center text-primary bg-primary">Consulta de figuras</h2>
	<br> <a href="?pagina=figura&opcao=cadastrar">Nova figura</a><br>
<?php
    if ($totalimagens > 0) :
        ?>
<h2 class="text-center text-info">Total de figuras cadastradas: <?=$totalimagens; ?></h2>
	<br>
	<table class="table table-bordered" style="resize: both;">
		<caption>Figuras</caption>
		<thead>
			<tr>
				<th>Descrição da figura</th>
				<th>figura</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
<?php
        foreach ($imagens as $imagem) :
            ?>
<tr>
				<td><?=$imagem["figdesc"]; ?></td>
				<td><a
					href="http://localhost/projetoppc/forms/figura/verfigura.php?figcod=<?=$imagem["figcod"]; ?>">Ver
						imagem</a></td>
				<td><a
					href="?pagina=figura&opcao=alterar&figcod=<?=$imagem["figcod"]; ?>">alterar
						dados</a></td>
				<td><a
					href="?pagina=figura&opcao=excluir&figcod=<?=$imagem["figcod"]; ?>">excluir
						figura</a></td>
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
		<h1 class="text-center">Nenhuma figura cadastrada no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova figura.</p>
	</div>
	<br>
<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $imagem = buscarFiguraPorId($_GET["figcod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Alteração de figura</h2>
	<br>
	<p>Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="figdesc">Descrição da figura: <span>*</span></label> <input
				type="text" id="figdesc" name="figdesc" class="form-control"
				value="<?=$imagem["figdesc"]; ?>">
		</div>
		<br>
		<div class="form-group">
			<label for="figcont">Selecione o arquivo de imagem a ser inserido: <span>*</span></label>
			<input type="hidden" name="max_file_size" value="30000"> <input
				type="file" id="figcont" name="figcont" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" name="bt-form-alterar">
		</div>
		<br>
	</form>
<?php
endif;
?>
</div>