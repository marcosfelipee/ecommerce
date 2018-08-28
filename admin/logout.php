<?php
session_start();
if (!empty($_SESSION['Logado'])) {
	session_destroy ();
}
header ("Location: /admin/login.php");

?>