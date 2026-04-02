<?php 
session_start();

//validacion de usuario al inicar sesion
if(!isset($_SESSION['nombre'])){
    header("Location: ./assets/logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="../css/contadorvista.css">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>USUARIO X</h3>
        <a class="active">POLITICAS</a>
        <a href="../formularios/solicitud.php">SOLICITUD</a>
        <a>HISTORIAL</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="header">
            <h2>POLITICAS Y INSTRUCCIONES DE USO</h2>

            <div class="user-menu">
                <div class="user-btn" onclick="toggleMenu()">
                    👤
                </div>

                <div id="dropdown" class="dropdown">
                    <p><?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?></p>
                    <a href="logout.php">Cerrar sesión</a>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- CARD BIENVENIDA -->
            <div class="welcome-card">
                <h1>¡Bienvenido de nuevo Contador!</h1>

                <p>
                    Hola,
                    <span class="nombre-usuario">
                        <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>
                    </span>
                </p>

                <p>
                    Tu rol asignado es:
                    <strong>
                        <?php echo htmlspecialchars($_SESSION['rol']); ?>
                    </strong>
                </p>
            </div>

            <!-- POLITICAS -->
            <div class="card">
                <h3>Políticas de Plataforma</h3>
                <p>
                    El uso de esta plataforma implica la aceptación de nuestras políticas.
                    Los datos deben manejarse de forma responsable y segura.
                </p>

               
            </div>

            <!-- INSTRUCCIONES -->
            <div class="card">
                <h3>Instrucciones de Uso</h3>

                <ul class="list">
                    <li>📄 -----------</li>
                    <li>💳 -----------</li>
                    <li>📞 -----------</li>
                </ul>
            </div>

        </div>

    </div>

</div>

<!-- JS -->
<script>
function toggleMenu(){
    const menu = document.getElementById("dropdown");
    menu.classList.toggle("show");
}
</script>

</body>
</html>