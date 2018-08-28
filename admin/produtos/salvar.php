<?php
include '../layout/topo.php';
if (!empty($_GET['id'])) {
	$stmt = $mysqli->stmt_init ();
	$stmt->prepare ("select * from produtos where id = ?");
	$stmt->bind_param ("i", $_GET['id']);
	$stmt->execute ();
	$result = $stmt->get_result ();
	$produtos = $result->fetch_array (MYSQLI_ASSOC);
}
if (!empty($_POST)) {
	$titulo = $_POST['titulo'];
	$preco = $_POST['preco'];
	$estoque = $_POST['estoque'];
	$descricao = $_POST['descricao'];
	$desconto = $_POST['desconto'];
	$categoria = $_POST['categoria'];
	if (!empty($produtos)) {
		$stmt = $mysqli->stmt_init ();
		$stmt->prepare ("update produtos set titulo = ?,preco = ?,estoque = ?,descricao = ?,desconto = ? where id = ?");
		$stmt->bind_param ("sdisii", $titulo, $preco, $estoque, $descricao, $desconto, $produtos['id']);
		$stmt->execute ();
		$error = $stmt->error;
		$action = 'update';
		$id_produto = $produtos['id'];
	}
	else {
		$stmt = $mysqli->stmt_init ();
		$stmt->prepare ("INSERT INTO produtos (titulo,preco,estoque,descricao,desconto) VALUES (?,?,?,?,?)");
		$stmt->bind_param ("sdisi", $titulo, $preco, $estoque, $descricao, $desconto);
		$stmt->execute ();
		$error = $stmt->error;
		$action = 'insert';
		$id_produto = $stmt->insert_id;

	}
	if (empty($error)) {
		$stmt = $mysqli->stmt_init ();
		$stmt->prepare ("DELETE FROM produtos_categorias WHERE produtos_id = $id_produto");
		$stmt->execute ();
		if (!empty($_POST['categoria'])) {
			foreach ($_POST['categoria'] as $id_categoria) {
				$stmt = $mysqli->stmt_init ();
				$stmt->prepare ("INSERT INTO produtos_categorias (produtos_id,categorias_id) VALUES (?,?)");
				$stmt->bind_param ("ii", $id_produto, $id_categoria);
				$stmt->execute ();
				$error = $stmt->error;
			}
		}
	}
	if (empty($error) && isset($_FILES['foto'])) {
		if ($_FILES['foto']["size"] > 250000000000) {
			$error = "ARQUIVO MUITO GRANDE";
		}
		$imageFileType = $_FILES['foto']['type'];
		if ($imageFileType != "image/jpg" && $imageFileType != "image/png" && $imageFileType != "image/jpeg") {
			$error = '<br>Apenas JPG,PNG E JPEG são aceitos.';
		}
		if (empty($error)) {
			$extenso = explode ('.', $_FILES["foto"]["name"]);
			$extensao = '.'.end ($extenso);
			move_uploaded_file ($_FILES["foto"]["tmp_name"], "uploads/".$id_produto.$extensao);
		}
	}
	if (empty($error)) {
		header ("Location: lista.php?action=$action");
		exit();
	}
	else {
		header ("Location: lista.php?action=$action");
		exit();
	}
}
?>
<title>Novo produto</title>
<html>
<body>
<div class="inserir">
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
        <br>
        <input type="text" name="titulo" placeholder="Título do produto"
               value="<?php echo !empty($produtos['titulo']) ? ($produtos['titulo']) : '' ?>">
        <input type="number" name="preco" step="0.01" placeholder="Insira o preço do produto"
               value="<?php echo !empty($produtos['preco']) ? ($produtos['preco']) : '' ?>">
        <input type="number" name="estoque" placeholder="Quantidade em estoque"
               value="<?php echo !empty($produtos['estoque']) ? ($produtos['estoque']) : '' ?>">
        <input type="text" name="descricao" placeholder="Descrição do produto"
               value="<?php echo !empty($produtos['descricao']) ? ($produtos['descricao']) : '' ?>">
        <input type="number" name="desconto" placeholder="Insira um valor de desconto"
               value="<?php echo !empty($produtos['desconto']) ? ($produtos['desconto']) : '' ?>">
        <input type="file" name="foto" id="foto"
               value="<?php echo !empty($produtos['foto']) ? ($produtos['foto']) : '' ?>">
        <br>
        <input type="text" title="categoria" name="categoria" hidden="hidden">
        <br>

		<?php
		$stmt = $mysqli->stmt_init ();
		$stmt->prepare ("select categorias_id from produtos_categorias where produtos_id = ?");
		$stmt->bind_param ("i", $_GET['id']);
		$stmt->execute ();
		$result = $stmt->get_result ();
		$produtos_categorias = $result->fetch_all (MYSQLI_ASSOC);
		$new_produtos_categorias = [];
		foreach ($produtos_categorias as $value):
			$new_produtos_categorias [] = $value['categorias_id'];
		endforeach;
		$categorias_recursiva = include '../getCategoria_recursive.php';
		function listCategorias ($categorias, $new_produtos_categorias) {
			foreach ($categorias as $categoria) {
				?>

                <div>
                    <input title="categoria" type="checkbox" name="categoria[]"
                           value="<?php echo $categoria['id'] ?> " <?php echo in_array ($categoria['id'], $new_produtos_categorias) ? 'checked' : '' ?>>
					<?php echo $categoria['titulo'] ?>
                </div>

				<?php
				if (!empty($categoria['filhas'])) {
					listCategorias ($categoria['filhas'], $new_produtos_categorias);
				}
			}
		}

		listCategorias ($categorias_recursiva, $new_produtos_categorias);
		?>
        <br>
        <a href="lista.php"><input class="enviar" type="submit" value="ENVIAR"></a>
    </form>
</div>
</body>
</html>


