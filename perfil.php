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
    <title>Sistema de Comunicación</title>
    <link rel="stylesheet" href="css/principal.css">
</head>
<body>
<header>
        <div class="header-container">
            <div class="header-title">
                <h1><a href="principal.php" >Sistema de comunicación</a></h1>
            </div>
            <nav class="header-nav">
                <a href="modulos.html" id="modulos-link">Módulos</a>
                <a href="#" id="perfil-link">Perfil</a>
            </nav>
        </div>
    </header>


    <main>
        <div class="container">
            <div id="perfil-usuario">
        
                <img src="/imagenes/perfil.jpg" alt="Perfil del usuario" style="width: 100px; height: 100px;">
                <h2>Bienvenido,<span id="nombre-usuario">Usuario</span>estas son tus calificaciones</h2>
            </div>
            <div id="tabla-progreso">
                <!-- Aquí se mostrará el progreso cargado desde la base de datos -->
            </div>
          
        </div>
    </main>
    <script src="/js/consultaProgreso.js"></script>
    <script>
        var usuarioId = <?php echo $_SESSION['id_usuario']; ?>;
         </script>
</body>
</html>
