<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- estilos -->
  <?php include("estilos.php"); ?>
  <title>ITCA-FEPADA salón inteligente - Base</title>
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
          <h4>Control A/C</h4>
        </div>
      </div>
      
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
              <button class="control-button control-button-on-off w-100 py-2 rounded" id="power">Encender/Apagar</button>
            </div>
            <div class="col-6">
              <button class="control-button w-100 py-2 rounded" id="mode">Modo</button>
            </div>
            <div class="col-6">
              <button class="control-button w-100 py-2 rounded" onclick="adjustTemp(-1)">-</button>
            </div>
            <div class="col-6">
              <button class="control-button w-100 py-2 rounded" onclick="adjustTemp(1)">+</button>
            </div>
            <div class="col-6">
              <button class="control-button w-100 py-2 rounded">Ventilador</button>
            </div>
            <div class="col-6">
              <button class="control-button w-100 py-2 rounded">Ángulo</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Contenido principal -->

    </div>
  </main>

  <!-- script personalizado, sustituir con el script principal de la pantalla -->
  <script type="text/javascript" src="resources/inputs_temperatura.js?v=24043001"></script>

  <!-- css para inputs de temperatura y calidad aire -->
  <link rel="stylesheet" href="css/controlac.css" />
  <!-- scripts -->
  <?php include("scripts.php"); ?>
</body>

</html>