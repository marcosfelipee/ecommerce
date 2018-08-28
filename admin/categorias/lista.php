<head>
    <title>Categorias</title>
    <meta charset="utf-8">
</head>
<?php
include '../layout/topo.php';
$sql = "select * from categorias";
$query = $mysqli->query ($sql);
$categorias = $query->fetch_all (MYSQLI_ASSOC);
?>
<body>
<br>
    <h2>LISTA DE CATEGORIAS</h2>
    <hr/>
    <div style="text-align: right">
        <a href="../categorias/salvar.php" class="btn btn-success"><h6>ADICIONAR CATEGORIA</h6></a>
    </div>
    <br>
<table width="1000px" style="text-align: center" class="table table-bordered">
    <tr>
        <th>CÓDIGO</th>
        <th>TÍTULO</th>
        <th>CATEGORIA PAI</th>
        <th>OPÇÕES</th>
    </tr>
	<?php
	foreach ($categorias as $categoria):
		?>
        <tr>
            <td><?php echo $categoria['id'] ?></td>
            <td><?php echo $categoria['titulo'] ?></td>
            <td><?php echo $categoria['categoriaPai'] ?></td>
            <td><a href="salvar.php?id=<?php echo $categoria['id'] ?> ">
                    <i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
                <a href="excluir.php?id=<?php echo $categoria['id'] ?>"
                   onclick=" return confirm('Você deseja excluir essa categoria?')"><i class="fa fa-trash"
                                                                                       aria-hidden="true"></i></a></td>
        </tr>
		<?php
	endforeach;
	?>
</table>
</body>

