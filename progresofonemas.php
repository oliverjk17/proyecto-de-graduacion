<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

// Conectar a la base de datos
$servername = 'localhost';
$dbname = 'proyecto_graduacion';
$username = 'root';
$password = 'root';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si los datos fueron enviados correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_modulo = $_POST['id_modulo'];
    $id_juego = $_POST['id_juego'];
    $progreso_usuario = $_POST['progreso_usuario'];

    // Insertar o actualizar el progreso en la base de datos
    $sql = "INSERT INTO progreso (id_usuario, id_modulo, id_juego, progreso_usuario, fecha_completado) 
            VALUES ('$id_usuario', '$id_modulo', '$id_juego', '$progreso_usuario', NOW())
            ON DUPLICATE KEY UPDATE progreso_usuario='$progreso_usuario', fecha_completado=NOW()";

    if ($conn->query($sql) === TRUE) {
        echo "Progreso guardado correctamente";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
