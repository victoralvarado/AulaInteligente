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
      
      <!-- Contenido principal -->

    </div>
  </main>

  <!-- css para inputs de temperatura y calidad aire -->
  <link rel="stylesheet" href="css/temperatura.css" />
  
  <!-- scripts -->
  <?php include("scripts.php"); ?>

  <!-- script personalizado, sustituir con el script principal de la pantalla -->
  <script type="text/javascript" src="resources/inputs_temperatura.js?v=24043001"></script>

</body>

</html>