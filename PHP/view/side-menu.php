<?php
function active($current_page){
  $url_array = explode('/', $_SERVER['REQUEST_URI']);
  $url = end($url_array);
  if($current_page == $url){
      echo 'active'; // clase Bootstrap para indicar la página activa
  } 
}
?>
<!-- offcanvas -->
  <div class="offcanvas offcanvas-start sidebar-nav bg-light" tabindex="-1" id="sidebar">
    <div class="offcanvas-body p-0">
      <nav class="navbar navbar-light bg-light">
        <ul class="navbar-nav">

          <li>
            <a href="index.php" class="nav-link px-3 <?php active('index.php'); ?>">
              <span class="me-2"><i class="bi bi-speedometer2"></i></span>
              <span>Dashboard</span>
            </a>
          </li>
          <li>
            <a href="gestion_ac.php" class="nav-link px-3 <?php active('gestion_ac.php'); ?>">
              <span class="me-2"><i class="bi bi-fan"></i></span>
              <span>Gestión A/C</span>
            </a>
          </li>
          <li>
            <a href="moniasistencia.php" class="nav-link px-3 <?php active('moniasistencia.php'); ?>">
              <span class="me-2"><i class="bi bi-card-checklist"></i></span>
              <span>Monitorear Asistencia</span>
            </a>
          </li>

        </ul>
      </nav>
    </div>
  </div>
  <!-- offcanvas -->