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
        <h1>Juego de unión de animales: Nivel 1</h1>
        <div class="row">
            <!-- Imágenes superiores -->
            <div class="item-container" id="item1">
                <img src="imagenes/Caballo.png" alt="Imagen 1" class="item-image">
            </div>
            <div class="item-container" id="item2">
                <img src="imagenes/Mono.png" alt="Imagen 2" class="item-image">
            </div>
            <div class="item-container" id="item3">
                <img src="imagenes/Oveja.png" alt="Imagen 3" class="item-image">
            </div>
            <div class="item-container" id="item4">
                <img src="imagenes/Vaca.png" alt="Imagen 4" class="item-image">
            </div>
        </div>

        <!-- Espacio entre filas -->
        <div class="spacer"></div>

        <div class="row">
            <!-- Imágenes inferiores -->
            <div class="item-container" id="item5">
                <img src="imagenes/Vaca.png" alt="Imagen 4" class="item-image">
            </div>
            <div class="item-container" id="item6">
                <img src="imagenes/Mono.png" alt="Imagen 2" class="item-image">
            </div>
            <div class="item-container" id="item7">
                <img src="imagenes/Caballo.png" alt="Imagen 1" class="item-image">
            </div>
            <div class="item-container" id="item8">
                <img src="imagenes/Oveja.png" alt="Imagen 3" class="item-image">
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
        var usuarioId = <?php echo $_SESSION['id_usuario']; ?>;
    </script>
    
    <script src="js/script.js"></script>
    <script>
        function redirigir() {
            window.location.href = 'casa.php';
        }

        document.getElementById('btn-redirigir').addEventListener('click', function() {
            guardarProgreso(usuarioId, 1, correctCount, timerElement.textContent);
            redirigir();
        });
    </script>
</body>
</html>
