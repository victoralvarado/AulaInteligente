<?php 
define('HOST', "localhost");
define('USER', "root");
define('PASS', "");
define('BD', "saloninteligente");

function conectar()
{
	$con = new mysqli(HOST, USER, PASS, BD);
	$con->set_charset('utf8mb4');
	if ($con->connect_errno){
		echo "<h1><b><center>ERROR EN LA CONEXIÓN</center></b></h1>";
		die();
	}
	else
	{

	}

	return $con;
}
?>