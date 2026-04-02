<?php 
session_start();

// 1. Validación de sesión
if(!isset($_SESSION['nombre'])){
    header("Location: ./assets/index.php");
    exit();
}

// 2. Conexión
include("../php/conexion.php"); 

// Guardamos el nombre del usuario de la sesión en una variable
$usuario_sesion = $_SESSION['nombre'];

// 3. CONSULTA CONTADORES (Filtrado por tu columna 'usuario_nombre')
$sql_counts = "SELECT 
                COUNT(CASE WHEN estado = 'En proceso' THEN 1 END) as pendientes,
                COUNT(CASE WHEN estado = 'Rechazada' THEN 1 END) as rechazadas,
                COUNT(CASE WHEN estado = 'Aprobada' THEN 1 END) as aprobadas
               FROM solicitudes 
               WHERE usuario_nombre = ?"; // <-- Nombre de columna corregido según tu CREATE TABLE

$stmt_counts = $conexion->prepare($sql_counts);
$stmt_counts->bind_param("s", $usuario_sesion);
$stmt_counts->execute();
$res_counts = $stmt_counts->get_result();
$counts = $res_counts->fetch_assoc();

// FILTRO PARA LA TABLA DETALLADA
$estado_filtro = $_GET['ver_estado'] ?? '';
$solicitudes_detalle = null;

if($estado_filtro !== ''){
    // Filtramos por estado y por el nombre del usuario
    $stmt = $conexion->prepare("SELECT * FROM solicitudes WHERE estado = ? AND usuario_nombre = ?");
    $stmt->bind_param("ss", $estado_filtro, $usuario_sesion);
    $stmt->execute();
    $solicitudes_detalle = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="../css/solicitudes.css">
</head>
<body>

<div class="container">

    <aside class="sidebar">
        <h2>USUARIOS</h2>
        <nav>
            <a class="active" href="../vistas/solicitudes.php">SOLICITUDES</a>
            <a href="../formularios/solicitud.php">NUEVA SOLICITUDES</a>
            <a href="">COMPROBANTES</a>
            <a href="../vistas/usuarios.php">POLITICAS</a>
            <a href="/proyecto/logout.php">CERRAR SESIÓN</a>
        </nav>
    </aside>

    <main class="main-content">

        <header class="topbar">
            <h1>CENTRO DE SOLICITUDES</h1>
        </header>

        <div class="card">
            <div class="user-profile-header">
                <div class="user-icon">👤</div>
                <div class="user-info">
                    <p>
                        Nombre:
                        <span class="nombre-usuario">
                            <?php echo htmlspecialchars($usuario_sesion); ?>
                        </span>
                    </p>
                    <p>
                        Rol:
                        <strong>
                            <?php echo htmlspecialchars($_SESSION['rol'] ?? 'Sin Rol'); ?>
                        </strong>
                    </p>
                </div>
            </div>
        </div>

        <div class="stats-container">
            <a href="?ver_estado=En proceso" class="stat-card">
                <h3>SOLICITUDE<br>PENDIENTE</h3>
                <div class="number color-pendiente"><?php echo $counts['pendientes'] ?? 0; ?></div>
            </a>

            <a href="?ver_estado=Rechazada" class="stat-card">
                <h3>SOLICITUD<br>RECHAZADA</h3>
                <div class="number color-rechazada"><?php echo $counts['rechazadas'] ?? 0; ?></div>
            </a>

            <a href="?ver_estado=Aprobada" class="stat-card">
                <h3>SOLICITUD<br>APROBADA</h3>
                <div class="number color-aprobada"><?php echo $counts['aprobadas'] ?? 0; ?></div>
            </a>
        </div>

        <?php if ($estado_filtro !== '' && $solicitudes_detalle): ?>
        <div class="tabla-container">
            <h2>Mis Solicitudes: <?php echo htmlspecialchars($estado_filtro); ?></h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Proveedor</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>

                <?php if ($solicitudes_detalle->num_rows > 0): ?>
                    <?php while($row = $solicitudes_detalle->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['concepto']); ?></td>
                        <td>$<?php echo number_format($row['monto'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['proveedor']); ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            No tienes solicitudes con estado: <strong><?php echo htmlspecialchars($estado_filtro); ?></strong>.
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </main>
</div>

</body>
</html>