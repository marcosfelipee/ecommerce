<link href="botao.css" rel="stylesheet">
<?php
include '../admin/conexao.php';
include 'topo.php';

$sql = "select * from categorias";
$query = $mysqli->query ($sql);
$produtos = $query->fetch_all (MYSQLI_ASSOC);
?>
<title>Categorias</title>
<p><h2>CATEGORIAS</h2></p>

<?php
include 'tabelacat.php';
?>
<?php
include 'rodape.php';
?>

