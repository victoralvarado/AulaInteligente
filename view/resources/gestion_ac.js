$(document).ready(function(){

var powerOn = false;
var temperature = 22; // Temperatura inicial

valoresActuales();
valoresPromedios();

setInterval(updateClock, 1000); // Actualiza el reloj cada segundo
updateClock(); // Inicializa el reloj inmediatamente

});

function valoresActuales()
{
  let idAC = $("#AC").val();

  $.ajax({
      type: 'POST',
      async: false,
      dataType: 'json',
      data: { key:'getLastCalidadAC', idAC:idAC },
      url: '../controller/CalidadAireController.php',
      success: function(res)
      {
        let resTempAct = '';   
        let resHumeAct = '';    

        if(res != undefined && res != null && res != "" && res != false && res != 0 && res != "N/A")
        {
          ////////////////////TEMPERATURA////////////////////
          if(res.temperatura <= 22)
          {
            resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">'+ res.temperatura.toString() +' °C</p><h4><span class="badge rounded-pill bg-success">Frío</span></h4>';
          }
          else if (res.temperatura > 22 && res.temperatura < 30)
          {
            resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">'+ res.temperatura.toString() +' °C</p><h4><span class="badge rounded-pill bg-warning">Templado</span></h4>';
          }
          else if(res.temperatura >= 30)
          {
            resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">'+ res.temperatura.toString() +' °C</p><h4><span class="badge rounded-pill bg-danger">Caliente</span></h4>';
          }
        ////////////////////HUMEDAD////////////////////
          if(res.humedad < 30)
          {
            resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">' + res.humedad.toString() + ' %</p><h4><span class="badge rounded-pill bg-danger">Seco</span></h4>';
          }
          else if (res.humedad >= 30 && res.humedad <= 60)
          {
            resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">' + res.humedad.toString() + ' %</p><h4><span class="badge rounded-pill bg-success">Ideal</span></h4>';
          }
          else if(res.humedad > 60)
          {
            resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">' + res.humedad.toString() + ' %</p><h4><span class="badge rounded-pill bg-info">Húmedo</span></h4>';
          }
        }
        else
        {
          resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">N/A</p><h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>';
          resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">N/A</p><h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>';
        }

        $('#detActualTemp').empty().append(resTempAct);
        $('#detActualHume').empty().append(resHumeAct);

        setTimeout(function(){
              valoresActuales();
        },5000);
      },
      error: function(xhr, status)
      {
          console.log("xhr: " + xhr.responseText + "\nstatus: " + status);
      }

  });
}

function valoresPromedios()
{
  let idAC = $("#AC").val();

  $.ajax({
      type: 'POST',
      async: false,
      dataType: 'json',
      data: { key:'getAverageCalidadAC', idAC:idAC },
      url: '../controller/CalidadAireController.php',
      success: function(res)
      {
        let resTempAct = '';   
        let resHumeAct = '';    

        if(res != undefined && res != null && res != "" && res != false && res != 0 && res != "N/A")
        {
          ////////////////////TEMPERATURA////////////////////
          if(res.temperatura <= 22)
          {
            resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">'+ Math.round(res.temperatura).toString() +' °C</p><h4><span class="badge rounded-pill bg-success">Frío</span></h4>';
          }
          else if (res.temperatura > 22 && res.temperatura < 30)
          {
            resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">'+ Math.round(res.temperatura).toString() +' °C</p><h4><span class="badge rounded-pill bg-warning">Templado</span></h4>';
          }
          else if(res.temperatura >= 30)
          {
            resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">'+ Math.round(res.temperatura).toString() +' °C</p><h4><span class="badge rounded-pill bg-danger">Caliente</span></h4>';
          }
        ////////////////////HUMEDAD////////////////////
          if(res.humedad < 30)
          {
            resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">' + Math.round(res.humedad).toString() + ' %</p><h4><span class="badge rounded-pill bg-danger">Seco</span></h4>';
          }
          else if (res.humedad >= 30 && res.humedad <= 60)
          {
            resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">' + Math.round(res.humedad).toString() + ' %</p><h4><span class="badge rounded-pill bg-success">Ideal</span></h4>';
          }
          else if(res.humedad > 60)
          {
            resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">' + Math.round(res.humedad).toString() + ' %</p><h4><span class="badge rounded-pill bg-info">Húmedo</span></h4>';
          }
        }
        else
        {
          resTempAct = resTempAct + '<h5 class="card-title">Temperatura del Aire Actual</h5><p class="display-1 fw-bold" id="temperature">N/A</p><h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>';
          resHumeAct = resHumeAct + '<h5 class="card-title">Humedad del Aire Actual</h5><p class="display-1 fw-bold">N/A</p><h4><span class="badge rounded-pill bg-secondary">N/A</span></h4>';
        }

        $('#detPromTemp').empty().append(resTempAct);
        $('#detPromHume').empty().append(resHumeAct);

        setTimeout(function(){
              valoresPromedios();
        },5000);
      },
      error: function(xhr, status)
      {
          console.log("xhr: " + xhr.responseText + "\nstatus: " + status);
      }

  });
}

function adjustTemp(change) {
  if (powerOn) {
    temperature += change;
    updateDisplay();
  }
}

function updateDisplay() {
  if (powerOn) {
    document.getElementById('temperature').textContent = temperature + ' °C';
    // Aquí puedes actualizar otros elementos del display si es necesario
  } else {
    document.getElementById('temperature').textContent = '--';
  }
}

// Función que actualiza el reloj
function updateClock() {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes().toString().padStart(2, '0');
var ampm = hours >= 12 ? 'PM' : 'AM';
hours = hours % 12;
hours = hours ? hours.toString().padStart(2, '0') : '12'; // La hora '0' debe ser '12'
document.getElementById('time').textContent = hours + ":" + minutes + ' ' + ampm;
}
