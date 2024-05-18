<?php
// Incluir el archivo de conexión a la base de datos
include 'testconnection.php';

$aula_id = 1;  // Cambiar según el aula correspondiente
$materia_id = 1;  // Cambiar según la materia correspondiente
$fecha = date('Y-m-d');

$sql = "SELECT estudiantes.nombres, estudiantes.apellidos, estudiantes.carnet, asistencia.estado 
        FROM asistencia 
        JOIN estudiantes ON asistencia.estudiante_id = estudiantes.id 
        WHERE asistencia.aula_id = $aula_id AND asistencia.fecha = '$fecha' AND asistencia.materia_id = $materia_id
        ORDER BY estudiantes.apellidos";
$result = $conn->query($sql);

$attendance = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
}

echo json_encode($attendance);

$conn->close();
?>
