<?php
session_start();

$servername = 'localhost';
$dbname = 'proyecto_graduacion';
$username = 'root';
$password = 'root';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener el nombre del usuario
$query_usuario = "SELECT nombre FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = $conn->prepare($query_usuario);
$stmt_usuario->bind_param('i', $id_usuario);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$usuario = $result_usuario->fetch_assoc();

// Consulta para obtener el progreso del usuario, nombre del juego, y fecha de completado, ordenado por fecha descendente
$query_progreso = "
    SELECT p.id_juego, j.nombre_juego, p.id_modulo, p.progreso_usuario, p.fecha_completado
    FROM progreso p
    JOIN juegos j ON p.id_juego = j.id_juego
    WHERE p.id_usuario = ?
    ORDER BY p.id_progreso DESC
";


$stmt_progreso = $conn->prepare($query_progreso);
$stmt_progreso->bind_param('i', $id_usuario);
$stmt_progreso->execute();
$result_progreso = $stmt_progreso->get_result();

$progreso = [];
while ($row = $result_progreso->fetch_assoc()) {
    $progreso[] = $row;
}

// Devolver nombre del usuario y progreso en formato JSON
echo json_encode(['nombre' => $usuario['nombre'], 'progreso' => $progreso]);

?>
