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
    $email = $conn->real_escape_string($_POST['email']);
    $contraseña = $conn->real_escape_string($_POST['contraseña']);

    // Consulta para verificar el usuario
    $sql = "SELECT id_usuario, nombre, contraseña FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Comparación directa si la contraseña no está hashada
        if ($contraseña == $row['contraseña']) {
            // Contraseña correcta: establecer la sesión
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];

            // Redirigir al usuario a la página principal
            header("Location: /principal.php");
            exit();
        } else {
            // Contraseña incorrecta
            $error = "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        $error = "No existe una cuenta con ese correo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
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
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php
        if (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        }
        ?>
        <form method="post" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" required>

            <input type="submit" value="Ingresar">

            <p>¿No tienes cuenta? <a href="registro.php" id="registerLink">Regístrate aquí</a></p>
        </form>
    </div>
</body>
</html>
