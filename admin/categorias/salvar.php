<?php
include '../layout/topo.php';
$sql = "select * from categorias";
$query = $mysqli->query ($sql);
$categorias = $query->fetch_all (MYSQLI_ASSOC);

if (!empty($_GET['id'])) {
	$stmt = $mysqli->stmt_init ();
	$stmt->prepare ("SELECT * FROM categorias WHERE id = ?");
	$stmt->bind_param ("i", $_GET['id']);
	$stmt->execute ();
	$result = $stmt->get_result ();
	$categoria = $result->fetch_array (MYSQLI_ASSOC);
	if (empty($categorias)) {
		header ("Location: lista.php");
	}
}
if (!empty($_POST)) {
	$titulo = $_POST['titulo'];
	$categoriapai = (!empty($_POST['categoriaPai'])) ? ($_POST['categoriaPai']) : null;

	if (!empty($categoria)) {
		$stmt = $mysqli->stmt_init ();
		$stmt->prepare ("UPDATE categorias SET titulo = ?,categoriaPai = ? WHERE id = ?");
		$stmt->bind_param ("sii", $titulo, $categoriapai, $categoria['id']);
		$stmt->execute ();
		echo $stmt->error;
		$mensagem = "<h3>CATEGORIA EDITADA COM SUCESSO</h3>";
		echo $mensagem;
	}

	else {
		$stmt = $mysqli->stmt_init ();
		$stmt->prepare ("INSERT INTO categorias (titulo,categoriaPai) VALUES (?,?)");
		$stmt->bind_param ("si", $titulo, $categoriapai);
		$stmt->execute ();
		echo $stmt->error;
		$mensagemi = "<h3>CATEGORIA INSERIDA COM SUCESSO</h3>";
		echo $mensagemi;
		mysqli_close ($mysqli);
	}
}
?>
<html>
<div class="inserir">
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
            <label for="titulo">TÍTULO</label><br>
            <input type="text" name="titulo" title="titulo"
                   value="<?php echo !empty($categorias['titulo']) ? $categorias['titulo'] : '' ?>">
            <label for="categorias_id">CATEGORIA PAI</label><br>
            <select name="categoriaPai" style="min-width: 100px" title="categoriaPai">
                <option value="vazia"></option>

				<?php
				foreach ($categorias as $categoria):
					?>
                    <option value="<?php echo !empty($categoria['id']) ? $categoria['id'] : '' ?>">
						<?php echo !empty($categoria['titulo']) ? $categoria['titulo'] : '' ?>
                    </option>

					<?php
				endforeach;
				?>
        <input class="enviar-cat" type="submit" name="submit" value="INSERIR CATEGORIA">
    </form>
</div>
</html>
