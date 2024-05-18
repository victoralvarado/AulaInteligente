<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- estilos -->
  <?php include("estilos.php"); ?>
  <title>ITCA-FEPADA salón inteligente - Base</title>
  <script>
        function fetchAttendance() {
            fetch('testgetasistencia.php')
                .then(response => response.json())
                .then(data => {
                    let table = document.getElementById('attendance-table');
                    table.innerHTML = '';
                    data.forEach(record => {
                        let row = table.insertRow();
                        let cell1 = row.insertCell(0);
                        let cell2 = row.insertCell(1);
                        let cell3 = row.insertCell(2);
                        let cell4 = row.insertCell(3);
                        cell1.innerHTML = record.nombres;
                        cell2.innerHTML = record.apellidos;
                        cell3.innerHTML = record.carnet;
                        cell4.innerHTML = record.estado;
                        cell4.classList.add('text-center');
                    });
                });
        }

        setInterval(fetchAttendance, 5000); // Actualizar cada 5 segundos

        window.onload = fetchAttendance; // Cargar al inicio
    </script>
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
            <h4>Monitorear Asistencia</h4>
          </div>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
          Imprimir Asistencia
        </button>
        <div class="print-container">
          <div class="container-fluid">
            <div class="text-center mb-4">
            <img src="images/logo.png" class="logo" height="42"/>
              <p class="fs-4 fw-bold">Listado de asistencia</p>
              <p class="fs-5">Regional: SANTA TECLA</p>
            </div>
            <div class="row header-info">
              <div class="col-6">
                <p>
                  <strong>Departamento:</strong> ESCUELA DE INGENIERÍA DE
                  COMPUTACIÓN
                </p>
                <p>
                  <strong>Carrera:</strong> INGENIERÍA DE DESARROLLO DE SOFTWARE
                </p>
                <p><strong>Ciclo:</strong> CICLO I - 2024</p>
                <p><strong>Docente:</strong> [Nombre del docente]</p>
              </div>
              <div class="col-6 text-end">
                <p id="currentDate">[Fecha Actual]</p>
                <p id="currentTime">[Hora Actual]</p>
              </div>
            </div>

            <div class="mb-3">
              <p><strong>Materia:</strong> [Nombre de la materia]</p>
              <p><strong>Grupo:</strong> 42109 DS21 - GRP A - PRÁCTICA</p>
              <p>
                <strong>Del:</strong> 19/02/2024 al 24/06/2024 / LUN 7:00AM -
                10:40AM (N/A)
              </p>
              <p class="mt-4">
                Simbología: Punto(•)= Asistencia, (T)= Llegadas tardes, (I)=
                Inasistencia, (*)= Segunda matrícula, (**) = tercera matrícula
              </p>
            </div>

            <div class="table-responsive">
              <table
                id="attendanceTable"
                class="table table-striped table-bordered"
              >
                <thead>
                <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Carnet</th>
                <th>Estado</th>
                  </tr>
                </thead>
                <tbody id="attendance-table">
                <!-- Asistencia se mostrará aquí -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Contenido principal -->

    </div>
  </main>

  <!-- script personalizado, sustituir con el script principal de la pantalla -->
  <script type="text/javascript" src="resources/moniasistencia.js?v=24043001"></script>

  <!-- css para inputs de temperatura y calidad aire -->
  <link rel="stylesheet" href="css/moniasistencia.css" />
  <!-- scripts -->
  <?php include("scripts.php"); ?>
</body>

</html>