<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- estilos -->
  <?php include("estilos.php"); ?>
  <title>ITCA-FEPADE salón inteligente - Base</title>
</head>

<body>
  
  <!-- top bar -->
  <?php include("top-bar.php"); ?>

  <!-- side menu -->
  <?php include("side-menu.php"); ?>
  
  <main class="mt-5 pt-3">
    <div class="container-fluid">

      <!-- Contenido principal -->
        <input type="hidden" id="AC" name="AC" value="1" />
        <div class="row">
          <div class="col-12 col-md-6 mb-6">

            <div class="container py-5">
              <div class="control-container mx-auto p-4 border border-2 rounded-3 shadow">
                <div class="control-header p-4 d-flex justify-content-between align-items-center">
                  <div>
                    <p class="control-big-text fw-bold mb-0" id="temperature">22 °C</p>
                    <p class="control-small-text" id="time">--:-- --</p>
                  </div>
                  <div class="d-flex align-items-center">
                    <!-- Iconos de Bootstrap -->
                    <i class="bi bi-flower1 control-icon me-2"></i>
                    <span class="control-big-text fw-bold">&gt;</span>
                  </div>
                </div>
                <div class="mt-4 row g-2">
                  <div class="col-6">
                    <button class="control-button control-button-on-off w-100 py-2 rounded" id="powerAC" name="powerAC">Encender/Apagar</button>
                  </div>
                  <div class="col-6">
                    <button class="control-button w-100 py-2 rounded" id="modoAC" name="modoAC">Modo</button>
                  </div>
                  <div class="col-6">
                    <button class="control-button w-100 py-2 rounded" id="bajarAC" name="bajarAC">Bajar</button>
                  </div>
                  <div class="col-6">
                    <button class="control-button w-100 py-2 rounded" id="subirAC" name="subirAC">Subir</button>
                  </div>
                  <div class="col-6">
                    <button class="control-button w-100 py-2 rounded" id="ventiladorAC" name="ventiladorAC">Ventilador</button>
                  </div>
                  <div class="col-6">
                    <button class="control-button w-100 py-2 rounded" id="anguloAC" name="anguloAC">Ángulo</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="col-12 col-md-6 mb-6">
            
            <div class="row mt-3">
              <div class="col-12 col-md-12 mb-12">
                <div class="card text-center h-100" style="border-radius: 15px; background: #2B54A0; color: white;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-6 mb-6" id="detActualTemp" name="detActualTemp">
                        <h5 class="card-title">Temperatura del Aire Actual</h5>
                        <p class="display-1 fw-bold" id="temperature">N/A</p>
                        <h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>
                      </div>
                      <div class="col-12 col-md-6 mb-6" id="detActualHume" name="detActualHume">
                        <h5 class="card-title">Humedad del Aire Actual</h5>
                        <p class="display-1 fw-bold">N/A</p>
                        <h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-12 col-md-12 mb-12">
                <div class="card text-center h-100" style="border-radius: 15px; background: #2B54A0; color: white;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-6 mb-6" id="detPromTemp" name="detPromTemp">
                        <h5 class="card-title">Temperatura del Aire Promedio</h5>
                        <p class="display-1 fw-bold" id="temperature">N/A</p>
                        <h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>
                      </div>
                      <div class="col-12 col-md-6 mb-6" id="detPromHume" name="detPromHume">
                        <h5 class="card-title">Humedad del Aire Promedio</h5>
                        <p class="display-1 fw-bold">N/A</p>
                        <h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      <!-- Contenido principal -->

    </div>
  </main>

  <!-- css para inputs de temperatura y calidad aire -->
  <link rel="stylesheet" href="css/gestion_ac.css" />
  <!-- scripts -->
  <?php include("scripts.php"); ?>

  <!-- script personalizado, sustituir con el script principal de la pantalla -->
  <script type="text/javascript" src="resources/gestion_ac.js?v=24043001"></script>
  
</body>

</html>