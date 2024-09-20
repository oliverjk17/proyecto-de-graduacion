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
                <a href="perfil.php" id="perfil-link">Perfil</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Bienvenido <span id="nombre-usuario">Usuario</span> al sistema de comunicación</h2>
            <p>Ve a módulos para iniciar las evaluaciones</p>
            <button id="modulos-button">Módulos</button>
        </div>
    </main>
    <script>
        document.getElementById('modulos-button').addEventListener('click', function() {
            window.location.href = 'modulos.html';
        });
    </script>
    <script src="/js/consultaProgreso.js"></script>
    <script>
        var usuarioId = <?php echo $_SESSION['id_usuario']; ?>;
    </script>
</body>
</html>
