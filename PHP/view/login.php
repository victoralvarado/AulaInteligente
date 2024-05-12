<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso - ITCA FEPADE</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/login.css" type="text/css"/>
</head>
<body>
<div class="container full-height">
    <div class="login-container">
        <div class="text-center mb-4">
            <img src="images/logo.png" alt="Logo ITCA FEPADE" style="width: 80%; max-width: 300px;">
        </div>
        <form action="process_login.php" method="post">
            <div class="form-group">
                <label for="username"><i class="bi bi-person-fill"></i> Usuario</label>
                <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Ingrese su usuario">
            </div>
            <div class="form-group my-2">
                <label for="password"><i class="bi bi-lock-fill"></i> Contraseña</label>
                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Ingrese su contraseña">
            </div>
            <button type="submit" class="btn btn-primary my-2">Ingresar</button>
        </form>
    </div>
</div>
<!-- scripts -->
<?php include("scripts.php"); ?>
</body>
</html>
