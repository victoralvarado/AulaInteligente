$(document).ready(function(){

	valComandoAc();

	$(document).on("click",".comandoIR", function(){

		let idAC = "1";
		let command = $(this).text();

		$.ajax({
		      type: 'GET',
		      async: false,
		      dataType: 'json',
		      url: '../controller/ArduinoController.php?key=InsertComandoAC&idAC='+idAC+'&command='+command,
		      success: function(res)
		      {       
		          $(".comandoIR").attr("disabled", true);
		      },
		      error: function(xhr, status)
		      {
		          console.log("xhr: " + xhr.responseText + "\nstatus: " + status);
		      }

		  });

	});

});

function valComandoAc()
{
	$.ajax({
		  type: 'GET',
		  async: false,
		  dataType: 'text',
		  url: '../controller/ArduinoController.php?key=ReadComandoAC',
		  success: function(res)
		  {       
		  		//console.log("respuesta: "+res);
				if(res != undefined && res != null && res != "" && res != false && res != 0 && res != "N/A")
				{
					$(".comandoIR").attr("disabled", true);
				}
				else
				{
					$(".comandoIR").attr("disabled", false);
				}
			    setTimeout(function(){
	            	valComandoAc();
	            },500);
		  },
		  error: function(xhr, status)
		  {
		      console.log("xhr: " + xhr.responseText + "\nstatus: " + status);
		  }

	});
}