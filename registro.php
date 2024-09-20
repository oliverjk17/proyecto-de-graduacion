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

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $contraseña = $conn->real_escape_string($_POST['contraseña']);

    // Asegurarse de que el email no esté ya registrado
    $sql_check = "SELECT * FROM usuarios WHERE email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 0) {
        // Insertar el nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, email, contraseña, fecha_registro) VALUES ('$nombre', '$email', '$contraseña', NOW())";

        if ($conn->query($sql) === TRUE) {
            // Registro exitoso: redirigir a la página de login
            header("Location: /php/login.php");
            exit();
        } else {
            $error = "Error al registrar el usuario: " . $conn->error;
        }
    } else {
        $error = "El email ya está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #28a745;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registro</h2>
        <?php
        if (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        }
        ?>
        <form method="post" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" required>

            <input type="submit" value="Registrarse">

            <p>¿Ya tienes cuenta? <a href="login.php" id="registerLink">Inicia sesión aquí</a></p>
        </form>
    </div>
</body>
</html>
