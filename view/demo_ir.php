<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- estilos -->
  <?php include("estilos.php"); ?>
  <title>ITCA-FEPADE salón inteligente - Enviar señales infrarrojas</title>
</head>

<body>
  
  <!-- top bar -->
  <?php include("top-bar.php"); ?>

  <!-- side menu -->
  <?php include("side-menu.php"); ?>
  
  <main class="mt-5 pt-3">
    <div class="container-fluid">

      <!-- Contenido principal -->
        <center><h1>Demo envío señales IR</h1></center>
        <br>
        <div class="row mt-3">
          <div class="d-flex justify-content-center col-12 col-md-12 mb-12">
            <button id="bajarVol" name="bajarVol" class="btn-lg bg-danger comandoIR">Bajar</button>&nbsp;
            <button id="subirVol" name="subirVol" class="btn-lg bg-success comandoIR">Subir</button>
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
  <script type="text/javascript" src="resources/demo_ir.js?v=24043001"></script>

</body>

</html>