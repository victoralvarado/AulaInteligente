// Este script manejará la actualización de la temperatura y el botón de encendido/apagado
   /* const temperatureDisplay = document.getElementById('temperature');
    const temperatureSlider = document.getElementById('temperature-slider');
    const powerButton = document.getElementById('power-button');

    temperatureSlider.oninput = function () {
      temperatureDisplay.textContent = `${this.value}°C`;
    };

    powerButton.onclick = function () {
      alert('El aire acondicionado se ha apagado/encendido.');
    };*/

     // Función que actualiza el reloj
     function updateClock() {
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes().toString().padStart(2, "0");
      var ampm = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours.toString().padStart(2, "0") : "12"; // La hora '0' debe ser '12'
      document.getElementById("time").textContent =
        hours + ":" + minutes + " " + ampm;
    }

    setInterval(updateClock, 1000); // Actualiza el reloj cada segundo
    updateClock(); // Inicializa el reloj inmediatamente