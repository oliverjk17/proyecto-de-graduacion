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
    <title>Juego de Unión de Objetos Iguales</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="game-container">
    <h1>Juego de union de Trasportes: Nivel 3</h1>
        <div class="row">
            <div class="item-container" id="item1">
                <img src="imagenes/Avion.png" alt="Imagen 1" class="item-image">
            </div>
            <div class="item-container" id="item2">
                <img src="imagenes/Barco.png" alt="Imagen 2" class="item-image">
            </div>
            <div class="item-container" id="item3">
                <img src="imagenes/Camion.png" alt="Imagen 3" class="item-image">
            </div>
            <div class="item-container" id="item4">
                <img src="imagenes/Moto.png" alt="Imagen 4" class="item-image">
            </div>
        </div>

        <!-- Espacio entre filas -->
        <div class="spacer"></div>

        <div class="row">
            <div class="item-container" id="item5">
                <img src="imagenes/Moto.png" alt="Imagen 4" class="item-image">
            </div>
            <div class="item-container" id="item6">
                <img src="imagenes/Camion.png " alt="Imagen 3" class="item-image">
            </div>
            <div class="item-container" id="item7">
                <img src="imagenes/Avion.png" alt="Imagen 1" class="item-image">
            </div>
            <div class="item-container" id="item8">
                <img src="imagenes/Barco.png" alt="Imagen 2" class="item-image">
            </div>
        </div>
        
        <!-- Contador de Respuestas Correctas -->
        <div class="counter">
            Respuestas Correctas: <span id="correct-count">0</span>
        </div>
         <!-- Timer -->
         <div id="timer">Tiempo: 0s</div>


        <!-- Botones de reinicio y redirigir -->
        <div class="button-container">
        <button id="redireccionar-boton" onclick="window.location.href='principal.php';">
    Inicio
</button>
            <button id="btn-reset">Reiniciar</button>
            <button id="btn-redirigir" onclick="redirigir()">Siguiente</button>
        </div>
    </div>

    <canvas id="canvas"></canvas>
    
    <!-- Audio para respuestas correctas -->
    <audio id="success-sound" src="fonemas/fonemaR/sonido-correcto.mp3"></audio>
    <script>
        // PHP inserta el ID del usuario en una variable JavaScript
        var usuarioId = <?php echo $_SESSION['id_usuario']; ?>;
        </script>
    
    <script src="js/script3.js"></script>
    <script>
        // Función para redirigir a otro HTML
        function redirigir() {
            window.location.href = 'modulos.html'; // Cambia 'otro.html' por la ruta a tu otro archivo HTML
        }
        
        // Agregar evento de clic al botón
        document.getElementById('btn-redirigir').addEventListener('click', function() {
            redirigir();
        });

      
    </script>
</body>
</html>
