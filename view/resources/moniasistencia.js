function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes().toString().padStart(2, "0");
    var seconds = now.getSeconds().toString().padStart(2, "0");
    var ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12;
    hours = hours ? hours.toString().padStart(2, "0") : "12"; // La hora '0' debe ser '12'
    return hours + ":" + minutes + ":" + seconds + " " + ampm;
  }

  document.addEventListener("DOMContentLoaded", function () {
    // Actualizar la hora una vez al cargar
    document.getElementById("currentTime").textContent = updateClock();
    // Actualizar la hora cada segundo
    setInterval(function () {
      document.getElementById("currentTime").textContent = updateClock();
    }, 1000);
  });

  function updateDate() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2); // Añade un cero al inicio si es necesario y toma los últimos 2 dígitos
    var month = ("0" + (now.getMonth() + 1)).slice(-2); // Los meses empiezan desde 0 en JavaScript
    var year = now.getFullYear();
    return day + "/" + month + "/" + year;
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("currentDate").textContent = updateDate();
  });
  $(document).ready(function () {
    $("#attendanceTable").DataTable({
      // Configuración de DataTables si es necesario
    });
  });