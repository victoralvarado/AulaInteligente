<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- estilos -->
    <?php include("estilos.php"); ?>
    <title>ITCA-FEPADE salón inteligente - Inicio</title>
</head>

<body>

    <!-- top bar -->
    <?php include("top-bar.php"); ?>

    <!-- side menu -->
    <?php include("side-menu.php"); ?>

    <main class="mt-5 pt-3">
        <div class="container-fluid">

            <!-- Contenido principal -->
            <div class="row">
                <div class="col-md-12">
                    <h4>Dashboard</h4>
                </div>
            </div>
            <div class="row d-flex">
                <div class="col-12 col-md-4 mb-4">
                    <!-- Air Conditioning Panel -->
                    <div class="card text-center h-100" style="border-radius: 15px; background: #2b54a0; color: white">
                        <div class="card-body">
                            <div class="row" id="detActualTemp" name="detActualTemp">
                                <h5 class="card-title">Temperatura Aire</h5>
                                <p class="display-1 fw-bold" id="temperature">N/A</p>
                                <h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <!-- Air Conditioning Panel -->
                    <div class="card text-center h-100" style="border-radius: 15px; background: #2b54a0; color: white">

                        <div class="card text-center h-100"
                            style="border-radius: 15px; background: #2b54a0; color: white">
                            <div class="card-body" id="detActualHume" name="detActualHume">
                                <h5 class="card-title">Humedad del Aire Actual</h5>
                                <p class="display-1 fw-bold">N/A</p>
                                <h4>
                                    <span class="badge rounded-pill bg-secondary">N/A</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <!-- Attendance Panel -->
                    <div class="card text-center h-100" style="border-radius: 15px; background: #2b54a0; color: white">
                        <div class="card-body">
                            <h5 class="card-title">Cantidad de Personas en el Aula</h5>
                            <b class="card-text" id="time">--:-- --</b>
                            <div style="display: flex; height: 80%; align-items: center;">
                                <p class="display-1 fw-bold m-0 w-100">19</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Contenido principal -->

        </div>
    </main>

    <!-- css para inputs de temperatura y calidad aire -->
    <link rel="stylesheet" href="css/temperatura.css" />
    <!-- scripts -->
    <?php include("scripts.php"); ?>

    <!-- script personalizado, sustituir con el script principal de la pantalla -->
    <script type="text/javascript" src="resources/gestion_ac.js?v=24043001"></script>

</body>

</html>