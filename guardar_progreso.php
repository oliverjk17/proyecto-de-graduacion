<?php
session_start();

// Conexión a la base de datos
$servername = 'localhost';
$dbname = 'proyecto_graduacion';
$username = 'root';
$password = 'root';

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos enviados desde el fetch
$data = json_decode(file_get_contents('php://input'), true);

$id_usuario = $data['usuarioId']; // El ID del usuario
$id_juego = $data['juegoId']; // El ID del juego
$respuestas_correctas = $data['respuestasCorrectas']; // El progreso (respuestas correctas)
$id_modulo = $data['idModulo']; // El ID del módulo (en este caso 1)
$fecha_completado = date("Y-m-d H:i:s");

// Insertar en la tabla "progreso"
$stmt = $conn->prepare("INSERT INTO progreso (id_usuario, id_juego, progreso_usuario, id_modulo, fecha_completado) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiiis", $id_usuario, $id_juego, $respuestas_correctas, $id_modulo, $fecha_completado);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Progreso guardado correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al guardar el progreso.']);
}

// Cerrar la conexión
$stmt->close();
$conn->close();

?>
