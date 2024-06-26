<?php
session_start();
require_once '../model/Alumno.php';

header('Content-Type: application/json');

function findImageExtension($filename)
{
    $extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    foreach ($extensions as $ext) {
        if (file_exists($filename . '.' . $ext)) {
            return $ext;
        }
    }
    return false;
}

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $activos = isset($input['activos']) ? $input['activos'] : false;
        $inactivos = isset($input['inactivos']) ? $input['inactivos'] : false;

        $obj = new Alumno();
        $result = [];

        if ($activos && $inactivos) {
            $result = $obj->getAllAlumnos();
        } elseif ($activos) {
            $obj->setActivo(1);
            $result = $obj->getAllAlumnosActivos();
        } elseif ($inactivos) {
            $obj->setActivo(0);
            $result = $obj->getAllAlumnosActivos();
        }

        $alumnos = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['extension'] = findImageExtension('../../Python/images/' . $row['carnet']);
                $alumnos[] = $row;
            }
        }

        echo json_encode($alumnos);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

if (isset($_POST['agregarAlumno'])) {
    insertAlumno();
}


function insertAlumno()
{
    if (validarCarnet($_POST['carnet']) == $_POST['carnet']) {
        $_SESSION['estado'] = 'error';
        $_SESSION['mensaje'] = 'El carnet ya se encuentra registrado';

        header("Location: ../view/alumnos.php");
    } else {
        $obj = new Alumno();
        $obj->setCarnet($_POST['carnet']);
        $obj->setNombres($_POST['nombres']);
        $obj->setApellidos($_POST['apellidos']);
        $obj->setActivo($_POST['activo']);


        #Extencion de la imagen
        $type = str_replace('image/', '', $_FILES['imagen']['type']);
        #Nombre original de la imagen
        $nombreDoc = $_FILES['imagen']['name'];
        #Nombre temporal de la imagen
        $archivoDoc = $_FILES['imagen']['tmp_name'];
        #Ruta donde se guardan las imagenes temporalmente
        $rutaDocServerTemp = '../temp/';
        #Ruta donde se guardan las imagenes
        $rutaDocServer = '../../Python/images/';
        #Ruta donde se guardan las images + el nombre original de la imagen
        $rutaDocServerImg = $rutaDocServerTemp . '' . $nombreDoc;
        #Mover la imagen al servidor temporalmente
        move_uploaded_file($archivoDoc, $rutaDocServerImg);
        #Asignar un nuevo nombre a la imagen
        $newName = $rutaDocServer . '' . $_POST['carnet'] . '.' . $type;
        #Reemplazar el nombre original de la imagen por el nuevo
        rename($rutaDocServerTemp . '' . $_FILES['imagen']['name'], $newName);

        $res = $obj->saveAlumno();
        $_SESSION['estado'] = $res['estado'] ? 'success' : 'error';
        $_SESSION['mensaje'] = $res['descripcion'];

        header("Location: ../view/alumnos.php");
    }
    exit;
}


if (isset($_POST['idEdit'])) {
    editAlumno();
}

function editAlumno()
{
    $ob = new Alumno();
    if (validarCarnet($_POST['carnet']) == $_POST['carnet'] && $ob->getCarnetById($_POST['idEdit']) != $_POST['carnet']) {
        $_SESSION['estado'] = 'error';
        $_SESSION['mensaje'] = 'El carnet ya se encuentra registrado';

        header("Location: ../view/alumnos.php");
    } else {
        $obj = new Alumno();
        $idEdit = $_POST['idEdit'];
        $obj->setId($_POST['idEdit']);
        $obj->setCarnet($_POST['carnet']);
        $obj->setNombres($_POST['nombres']);
        $obj->setApellidos($_POST['apellidos']);
        $activoKey = "activo" . $idEdit;
        $obj->setActivo($_POST[$activoKey]);
        $carnet = $obj->getCarnetById($idEdit);

        if ($_POST['carnet'] != $carnet && $_FILES['imagen']['name'] == null) {
            $extencion = obtenerTextoDespuesDelPunto($_POST['img']);

            renameImage($_POST['img'], $_POST['carnet'] . '.' . $extencion, "../../Python/images/");
        }

        if ($_FILES['imagen']['name'] != null) {
            unlink("../../Python/images/" . $_POST['img']);
            #Extencion de la imagen
            $type = str_replace('image/', '', $_FILES['imagen']['type']);
            #Nombre original de la imagen
            $nombreDoc = $_FILES['imagen']['name'];
            #Nombre temporal de la imagen
            $archivoDoc = $_FILES['imagen']['tmp_name'];
            #Ruta donde se guardan las imagenes temporalmente
            $rutaDocServerTemp = '../temp/';
            #Ruta donde se guardan las imagenes
            $rutaDocServer = '../../Python/images/';
            #Ruta donde se guardan las images + el nombre original de la imagen
            $rutaDocServerImg = $rutaDocServerTemp . '' . $nombreDoc;
            #Mover la imagen al servidor temporalmente
            move_uploaded_file($archivoDoc, $rutaDocServerImg);
            #Asignar un nuevo nombre a la imagen
            $newName = $rutaDocServer . '' . $_POST['carnet'] . '.' . $type;
            #Reemplazar el nombre original de la imagen por el nuevo
            rename($rutaDocServerTemp . '' . $_FILES['imagen']['name'], $newName);
            #Ruta de la imagen con el nuevo nombre
        }

        $res = $obj->updateAlumno();
        $_SESSION['estado'] = $res['estado'] ? 'success' : 'error';
        $_SESSION['mensaje'] = $res['descripcion'];

        header("Location: ../view/alumnos.php");
    }
    exit;
}

function renameImage($currentName, $newName, $directory)
{
    $currentPath = $directory . $currentName;
    $newPath = $directory . $newName;

    if (file_exists($currentPath)) {
        if (rename($currentPath, $newPath)) {
            echo "El archivo ha sido renombrado exitosamente a $newName.";
        } else {
            echo "Hubo un error al renombrar el archivo.";
        }
    } else {
        echo "El archivo $currentName no existe.";
    }
}

function obtenerTextoDespuesDelPunto($cadena)
{
    $partes = explode('.', $cadena);
    return end($partes);
}


function validarCarnet($carnet)
{
    $obj = new Alumno();
    $carnetConsultado = $obj->getOneAlumnoCarnet($carnet);
    return $carnetConsultado;
}