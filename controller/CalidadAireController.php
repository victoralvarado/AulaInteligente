<?php 

require_once '../model/CalidadAire.php';

if (isset($_POST['key'])) {
	$key = $_POST['key'];
	switch ($key) {
		case 'getLastCalidadAC':
			getLastCalidadAC();
			break;
		case 'getAverageCalidadAC':
			getAverageCalidadAC();
			break;
	}
}

function getLastCalidadAC()
{
		$objCA = new CalidadAire();
		$objCA->setIdAC($_POST['idAC']);
		$res=$objCA->getLastCalidadAC();
		echo json_encode($res);
}

function getAverageCalidadAC()
{
		$objCA = new CalidadAire();
		$objCA->setIdAC($_POST['idAC']);
		$res=$objCA->getAverageCalidadAC();
		echo json_encode($res);
}


?>