<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aulainteligente";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$grupo_id = 1;  // Cambiar según el aula correspondiente
$materia_id = 1;  // Cambiar según la materia correspondiente
date_default_timezone_set('America/El_Salvador');
$fecha = date("Y-m-d");

// Preparar la consulta SQL
$sql = "SELECT alumnos.nombres, alumnos.apellidos, alumnos.carnet, asistencias.estado 
        FROM asistencias 
        JOIN alumnos ON asistencias.alumno = alumnos.id 
        WHERE asistencias.grupo = ? AND DATE(asistencias.fechaHora) = ? AND asistencias.materia = ?
        ORDER BY alumnos.apellidos";

$stmt = $conn->prepare($sql);

// Vincular los parámetros a la consulta preparada
$stmt->bind_param("isi", $grupo_id, $fecha, $materia_id);

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados
$result = $stmt->get_result();

$attendance = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
}

echo json_encode($attendance);

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
