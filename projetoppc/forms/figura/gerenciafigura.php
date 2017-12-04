
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
    
    if ($imagem["type"] != "image/jpg" && $imagem["type"] != "image/png") :
        ?>
<div class="text-danger">
		<p>Por favor, selecione imagens do tipo JPG ou PNG.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $figpath = "C:\\wamp64\\bin\\apache\\apache2.4.23\\userimages\\" . basename($imagem["name"]);
    
    if (move_uploaded_file($imagem["tmp_name"], $figpath)) :
        try {
            if (inserirFigura($figdesc, $figpath)) {
                echo "<h1 class='text-success text-center'>Figura inserida com êxito!</h1><br>";
                echo "<a href='?pagina=figura&opcao=consultar'>Clique aqui para consultar as figuras cadastradas</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    else :
        
        ?>
<div class="text-danger">
		<p>Upload de figura não foi bem sucedido. Tente novamente.</p>
	</div>
	<br>
<?php
        return;
    endif;
endif;

?>
</div>