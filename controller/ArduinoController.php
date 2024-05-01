<?php 

require_once '../model/CalidadAire.php';
require_once '../model/ComandoAC.php';

if (isset($_GET['key'])) {
	$key = $_GET['key'];
	switch ($key) {
		case 'InsertCalidadAire':
			InsertCalidadAire();
			break;
		case 'ReadComandoAC':
			ReadComandoAC();
			break;
		case 'InsertComandoAC':
			InsertComandoAC();
			break;
		case 'DeleteComandoAC':
			DeleteComandoAC();
			break;
	}
}

function InsertCalidadAire()
{
		$objCA = new CalidadAire();
		$objCA->setTemperatura($_GET['tem']);
		$objCA->setHumedad($_GET['hum']);
		$objCA->setIdAula($_GET['idAula']);
		$objCA->setIdAC($_GET['idAC']);
		$res=$objCA->saveCalidadAire();
		echo json_encode($res);
}

function ReadComandoAC()
{
		$objCom = new ComandoAC();
		$res=$objCom->getLastCommand();
		echo $res;
}

function InsertComandoAC()
{
		$objCom = new ComandoAC();
		$objCom->setIdAC($_GET['idAC']);
		$objCom->setComando($_GET['command']);
		$res=$objCom->saveComando();
		echo json_encode($res);
}

function DeleteComandoAC()
{
		$objCom = new ComandoAC();
		$res=$objCom->deleteComando();
		echo $res;
}

?>