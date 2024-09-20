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
    <title>Juego de Fonemas</title>
    <link rel="stylesheet" href="css/fonemas.css">
</head>
<body>

    <audio id="success-sound" src="fonemas/fonemaR/sonido-correcto.mp3"></audio>

    <div class="container">
        <div class="header">
            <div class="status-bar">
                
                <h1>Juego de Fonemas:  Evaluacion 3</h1>
                
            </div>
        </div>
        
   
        <div class="game-container">
            <div class="general-container">
                <h2>Imágenes</h2>
                <div class="images" id="general-container">
                    <!-- Aquí van las imágenes -->
                </div>
            </div>
            <div class="phoneme-container" id="container-p">
                <h2>Fonema P</h2>
                <!-- Aquí se colocarán las imágenes del fonema P -->
            </div>
            <div class="phoneme-container" id="container-l">
                <h2>Fonema L</h2>
                <!-- Aquí se colocarán las imágenes del fonema L -->
            </div>
            <div class="phoneme-container" id="container-r">
                <h2>Fonema R</h2>
                <!-- Aquí se colocarán las imágenes del fonema R -->
            </div>

            <div class="status-bar">
                <div class="timer" id="timer">Tiempo: 0s</div>
                <div class="correct-counter" id="correct-counter">Imágenes Correctas: 0</div>
            </div>
            
        </div>
        <button id="redireccionar-boton" onclick="window.location.href='principal.php';">
    Inicio
</button>
        <button class="btn-siguiente" onclick="location.href='principal.php'">Siguiente</button>
        <button id="reset-button">Reiniciar</button> <!-- Botón añadido -->
    </div>

    <div id="error-message" class="error-message">
        ¡Inténtalo de nuevo! Imagen en lugar incorrecto.
    </div>
    <script>
        var usuarioId = <?php echo $_SESSION['id_usuario']; ?>;
         </script>

    <script src="js/FtercerN.js"></script>
</body>
</html>
