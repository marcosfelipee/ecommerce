<?php
include '../layout/topo.php';
if (!empty($_GET['id'])) {
	$stmt = $mysqli->stmt_init ();
	$stmt->prepare ("delete from categorias where id = ?");
	$stmt->bind_param ("i", $_GET['id']);
	$stmt->execute ();
	header ("Location: lista.php");
}
?>

