<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unión de Palabras</title>
    <link rel="stylesheet" href="/css/unionP.css">
   
</head>
<body>
    <div class="container">
        <div class="title">Unión de Palabras: Nivel 2</div>
        
        <div class="stats">
            <div class="timer">Tiempo: <span id="timeElapsed">0s</span></div>
            <div class="score">Puntaje: <span id="score">0</span></div>
        </div>

        <div class="error-message" id="errorMessage">Orden incorrecto. Intenta de nuevo.</div>
        
        <div class="drop-area" id="dropArea">
            <!-- Aquí se ordenarán las imágenes -->
        </div>
        
        <div class="image-area" id="imageArea">
        <img src="palabras/afuera.png" class="draggable" alt="Imagen 4" draggable="true">
            <img src="palabras/ropa.png" class="draggable" alt="Imagen 2" draggable="true">
            <img src="palabras/esta.png" class="draggable" alt="Imagen 3" draggable="true">
            <img src="palabras/la.png" class="draggable" alt="Imagen 1" draggable="true">
        </div>
        
        <div class="buttons">
        <button class="btn-custom" id="redireccionar-boton" onclick="window.location.href='principal.php';">
        Inicio</button>
            <button class="btn-custom" id="resetButton">Reiniciar</button>
            <button class="btn-custom" id="navigateButton">Ir a Otra Página</button>
        </div>
    </div>
    
    <audio id="correctSound" src="fonemas/fonemaR/sonido-correcto.mp3" preload="auto"></audio>

    <script src="js/palabras2.js"></script>
    <script>
        // PHP inserta el ID del usuario en una variable JavaScript
        var usuarioId = <?php echo $_SESSION['id_usuario']; ?>;
        </script>
</body>
</html>
