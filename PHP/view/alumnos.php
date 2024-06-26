<?php require_once ('../model/Alumno.php');
session_start();
$estado = isset($_SESSION['estado']) ? $_SESSION['estado'] : '';
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
// Limpiar los mensajes después de mostrarlos
unset($_SESSION['estado']);
unset($_SESSION['mensaje']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- estilos -->
    <?php include ("estilos.php"); ?>
    <title>ITCA-FEPADE salón inteligente - Base</title>
</head>

<body>

    <!-- top bar -->
    <?php include ("top-bar.php"); ?>

    <!-- side menu -->
    <?php include ("side-menu.php"); ?>
    <?php
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
    ?>
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <?php if ($estado == 'success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($mensaje) ?>
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            <?php elseif ($estado == 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($mensaje) ?>
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            <?php endif; ?>
            <!-- Contenido principal -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="col-md-12 text-center">
                        <h1>Registro de Alumnos</h1>
                    </div>
                    <form id="alumnoForm" class="form-horizontal" method="POST"
                        action="../controller/AlumnoController.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="carnet" class="control-label">Carnet:</label>
                            <div class="col-md-12">
                                <input type="text" id="carnet" name="carnet" placeholder="Carnet" pattern="\d{6}"
                                    maxlength="6" minlength="6" class="form-control" required autocomplete="off">
                            </div>
                            <span id="existecodigo" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="nombres" class="control-label">Nombres:</label>
                            <div class="col-md-12">
                                <input type="text" id="nombres" name="nombres" placeholder="Nombres"
                                    class="form-control" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="apellidos" class="control-label">Apellidos:</label>
                            <div class="col-md-12">
                                <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos"
                                    class="form-control" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Activo" class="control-label">Activo:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="activo" id="1" value="1" checked>
                                <label class="form-check-label" for="1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="activo" id="0" value="0">
                                <label class="form-check-label" for="0">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="imagen" class="control-label">Fotografia:</label>
                            <div class="col-md-12">
                                <input id="imagen" name="imagen" class="form-control" accept="image/*" required
                                    type="file">
                            </div>
                        </div>
                        <div class="form-group mt-2 text-center">
                            <button type="submit" id="agregarAlumno" name="agregarAlumno" class="btn btn-primary"><em
                                    class="fa fa-plus"></em> Agregar</button>
                            <button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                title="Limpiar cajas de texto"><em class="fa fa-eraser"></em> Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Tabla de alumnos -->
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <h1>Registro de Alumnos</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <label>
                        <input type="checkbox" id="checkbox_activos" checked> Activos
                    </label>
                    <label>
                        <input type="checkbox" id="checkbox_inactivos"> Inactivos
                    </label>
                </div>
            </div>

            <!-- Tabla de alumnos -->
            <div class="table-responsive mt-5">
                <table class="table table-bordered table-condensed" id="tabla_alumnos">
                    <caption>Lista de Alumnos</caption>
                    <thead>
                        <tr>
                            <th scope="col">Carnet</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Fotografia</th>
                            <th scope="col">Activo</th>
                            <th scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contenido dinámico -->
                    </tbody>
                </table>
            </div>
            <!-- Contenido principal -->

        </div>
    </main>


    <!-- scripts -->
    <?php include ("scripts.php"); ?>
    <script src="js/alumnos.js"></script>
</body>

</html>