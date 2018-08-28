<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet"
      xmlns="http://www.w3.org/1999/html">
<link rel="stylesheet" href="estilo.css">

<?php
	$stmt = $mysqli->stmt_init ();
	$sql = "SELECT DISTINCT produtos.* FROM ecommerce.produtos AS produtos
            LEFT JOIN ecommerce.produtos_categorias
            ON id = produtos_categorias.produtos_id
           ";
if (!empty($_GET['id_categoria'])) {
	$id_cat = $_GET['id_categoria'];
	$sql .= "WHERE categorias_id = $id_cat";
}
	$stmt->prepare ($sql);
	$stmt->execute ();
	$result = $stmt->get_result ();
	$produtos = $result->fetch_all (MYSQLI_ASSOC);

foreach ($produtos as $produto):
	?>
    <div class="etcetc" style="width: 100%" >
        <div class="right">

            <div class="bords">

                <div class="foto" align="center" >
                    <a href="telaProduto.php?produto=<?php echo $produto['id']?>"> <img src="../admin/produtos/uploads/<?php echo $produto['id']?>.jpg" </a>
                </div>
                <div class="intern">
                <div class="nome" align="center" >
					<?php echo $produto['titulo'] ?>
                </div>
                <div class="preco" align="center" >
					 <h3> R$ <?php echo number_format ($produto['preco'], 2, ',', '.') ?></h3>
                </div class="descricao" align="center">
            </div>
                <br>
            </div>
        </div>
    </div>
	<?php
endforeach;
?>
