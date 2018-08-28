<div class="cat-left">
	<?php

	$sql = "select * from categorias";
	$query = $mysqli->query ($sql);
	$categorias = $query->fetch_all (MYSQLI_ASSOC);
	foreach ($categorias as $categoria):
		$id_cat = $categoria['id'];
		?>
        <a href="listaProdutos.php?id_categoria=<?php echo $id_cat ?>" "><h4><?php echo $categoria['titulo'] ?></h4></a>
		<?php
	endforeach;
	?>

</div>

