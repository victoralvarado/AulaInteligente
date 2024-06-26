document.addEventListener('DOMContentLoaded', function () {
    const checkboxActivos = document.getElementById('checkbox_activos');
    const checkboxInactivos = document.getElementById('checkbox_inactivos');
    
    function fetchAndDisplayAlumnos() {
        const activos = checkboxActivos.checked;
        const inactivos = checkboxInactivos.checked;

        const data = { activos: activos, inactivos: inactivos };
        
        fetch('../controller/AlumnoController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#tabla_alumnos tbody');
            tbody.innerHTML = '';
            data.forEach(alumno => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${alumno.carnet}</td>
                    <td>${alumno.nombres}</td>
                    <td>${alumno.apellidos}</td>
                    <td><img src="../../Python/images/${alumno.carnet}.${alumno.extension}" width="100"></td>
                    <td>${alumno.activo ? 'Si' : 'No'}</td>
                    <td>
                        
                        <a class="btn btn-primary" data-toggle="modal" href="#edit_${alumno.id}">
                            <em class="fa fa-pencil"></em> Editar
                        </a>
                    </td>
                `;
                tbody.appendChild(tr);

                // Create and append the modal
                const modalDiv = document.createElement('div');
                modalDiv.className = 'modal fade';
                modalDiv.id = `edit_${alumno.id}`;
                modalDiv.tabIndex = -1;
                modalDiv.setAttribute('role', 'dialog');
                modalDiv.setAttribute('aria-hidden', 'true');
                modalDiv.innerHTML = `
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title"><strong>Editar Alumno</strong></h6>
                                <button type="button" class="close" data-dismiss="modal" onclick="location.reload()" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="editar${alumno.id}" class="well editar" action="../controller/AlumnoController.php" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">Carnet:</label>
                                        <div class="col-md-8 inputGroupContainer">
                                            <input id="carnetEdit" name="carnet" placeholder="Carnet" class="form-control edit" required="true" value="${alumno.carnet}" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">Nombres:</label>
                                        <div class="col-md-8 inputGroupContainer">
                                            <input id="nombresEdit" name="nombres" placeholder="Nombres" class="form-control edit" required="true" value="${alumno.nombres}" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">Apellidos:</label>
                                        <div class="col-md-8 inputGroupContainer">
                                            <input id="apellidosEdit" name="apellidos" placeholder="Apellidos" class="form-control edit" required="true" value="${alumno.apellidos}" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">Activo:</label>
                                        <div class="col-md-8 inputGroupContainer">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="activo${alumno.id}" id="chA${alumno.id}" value="1" ${alumno.activo == '1' ? 'checked' : ''}>
                                                <label class="form-check-label" for="si">Si</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="activo${alumno.id}" id="chI${alumno.id}" value="0" ${alumno.activo == '0' ? 'checked' : ''}>
                                                <label class="form-check-label" for="no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">Fotografia:</label>
                                        <div class="col-md-8 inputGroupContainer">
                                            <input id="imagenEdit" name="imagen" class="form-control" accept="image/*" type="file">
                                            <div class="alert alert-warning" role="alert">
                                                Si no agrega una imagen nueva, se mantendra la imagen actual
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input id="idEdit" name="idEdit" min="1" class="form-control" required="true" value="${alumno.id}" type="hidden">
                                        <input id="img" name="img" class="form-control" required="true" value="${alumno.carnet}.${alumno.extension}" type="hidden">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">
                                            <em class="fa fa-times"></em> Cancelar
                                        </button>
                                        <button type="button" id="editarAlum${alumno.id}" name="editarAlumno" class="btn btn-primary editarAlumno editarAlum">
                                            <em class="fa fa-pencil-square-o"></em> Editar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modalDiv);

                // Add SweetAlert confirmation for each edit button
                document.getElementById(`editarAlum${alumno.id}`).addEventListener('click', function() {
                    swal({
                        title: "Editar",
                        text: "¿Estás seguro que deseas editar el alumno?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Cancelar",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Continuar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            document.getElementById(`editar${alumno.id}`).submit();
                        }
                    });
                });
            });
        })
        .catch(error => console.error('Error:', error));
    }

    checkboxActivos.addEventListener('change', fetchAndDisplayAlumnos);
    checkboxInactivos.addEventListener('change', fetchAndDisplayAlumnos);

    // Fetch and display alumnos on initial load
    fetchAndDisplayAlumnos();
});
