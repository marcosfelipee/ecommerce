<?php
include 'conexao.php';
function getCategorias ($id = null, $mysqli) {
	$sql = "select * from categorias ";
	if (empty($id)) {
		$sql .= "WHERE categoriaPai IS NULL";
	}
	else {
		$sql .= "WHERE categoriaPai = $id";
	}
	$categorias = [];
	$query = $mysqli->query ($sql);
	if (!empty($query)) {
		$categorias = $query->fetch_all (MYSQLI_ASSOC);
		foreach ($categorias as $k => $categoria) {
			$categorias[$k]['filhas'] = getCategorias ($categoria['id'], $mysqli);
		}
	}

	return $categorias;
}

;
return getCategorias (null, $mysqli);
?>

