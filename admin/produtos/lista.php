<?php
include '../layout/topo.php';
?>
<html lang="en">
<head>
    <title>Produtos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php
$sql = "select * from produtos";
$query = $mysqli->query ($sql);
$produtos = $query->fetch_all (MYSQLI_ASSOC);
if (@$_GET['action'] == 'insert') {
	echo "<h3>PRODUTO INSERIDO COM SUCESSO</h3>";
}
elseif (@$_GET['action'] == 'update') {
	echo "<h3> PRODUTO EDITADO COM SUCESSO</h3>";
}
?>

<body>
<br>
<h2>LISTA DE PRODUTOS</h2>
<hr/>

<div style="text-align: right">
    <a href="../produtos/salvar.php" class="btn btn-success"><h6>ADICIONAR PRODUTO</h6></a>
</div>
<br>

<table width="1000px" style="text-align: center" class="table table-bordered">
    <tr>
        <th>CÓDIGO</th>
        <th>NOME</th>
        <th>PREÇO</th>
        <th>QUANTIDADE EM ESTOQUE</th>
        <th>DESCONTO</th>
        <th>OPÇÕES</th>


	<?php
	foreach ($produtos as $produto):
		?>
        <tr>
            <td><?php echo $produto['id'] ?></td>
            <td><?php echo $produto['titulo'] ?></td>
            <td><?php echo $produto['preco'] ?></td>
            <td><?php echo $produto['estoque'] ?></td>
            <td><?php echo $produto['desconto'] ?></td>
            <td><a href="salvar.php?id=<?php echo $produto['id'] ?>"><i class="fa fa-pencil-square-o"
                                                                        aria-hidden="true"></i></a>
                <a href="excluir.php?id=<?php echo $produto['id'] ?>"
                   onclick=" return confirm('Você deseja excluir esse produto?')"><i class="fa fa-trash"
                                                                                     aria-hidden="true"></i></a></td>
        </tr>

	<?php endforeach;
	?>

</table>
</body>
