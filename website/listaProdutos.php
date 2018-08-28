<link href="botao.css" rel="stylesheet">

<?php
include '../admin/conexao.php';
include 'topo.php';
?>
<title>Produtos</title>

<div class="categories">

	<?php
	function showCategoria ($categorias, $espaco = '<br>') {
	foreach ($categorias

	as $categoria) :
	$espaco .= '&nbsp;';
	$id_cat = $categoria['id'];
	?>

    <a href="listaProdutos.php?id_categoria=<?php echo $id_cat ?>" style="text-decoration: none">

		<?php
		echo $categoria['titulo']."$espaco";
		showCategoria ($categoria['filhas']);
		endforeach;
		}
		$categorias = include '../admin/getCategoria_recursive.php';
		showCategoria ($categorias);
		?>
    </a>


</div>
<div style="float: right; width: 100%">
	<?php
	include 'tabelaprod.php';
	?>
</div>
<?php
include 'rodape.php';
?>





