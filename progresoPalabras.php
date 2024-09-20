<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

// Conexión a la base de datos
$servername = 'localhost';
$dbname = 'proyecto_graduacion';
$username = 'root';
$password = 'root';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados desde JavaScript (cuerpo del POST en formato JSON)
$data = json_decode(file_get_contents('php://input'), true);

$score = $conn->real_escape_string($data['score']);
$id_juego = $conn->real_escape_string($data['id_juego']);
$id_modulo = $conn->real_escape_string($data['id_modulo']);
$id_usuario = $_SESSION['id_usuario'];  // Obtener el id del usuario de la sesión

// Guardar el progreso en la base de datos
$sql = "INSERT INTO progreso (id_usuario, id_juego, progreso_usuario, fecha_completado, id_modulo)
        VALUES ('$id_usuario', '$id_juego', '$score', NOW(), '$id_modulo')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Progreso guardado exitosamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el progreso']);
}

$conn->close();
?>
