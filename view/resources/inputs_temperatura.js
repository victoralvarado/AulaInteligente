// Este script manejará la actualización de la temperatura y el botón de encendido/apagado
    const temperatureDisplay = document.getElementById('temperature');
    const temperatureSlider = document.getElementById('temperature-slider');
    const powerButton = document.getElementById('power-button');

    temperatureSlider.oninput = function () {
      temperatureDisplay.textContent = `${this.value}°C`;
    };

    powerButton.onclick = function () {
      // Aquí puedes agregar la lógica para encender/apagar el aire acondicionado
      alert('El aire acondicionado se ha apagado/encendido.');
    };