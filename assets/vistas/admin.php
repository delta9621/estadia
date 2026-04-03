<?php 
session_start();

// Validación de sesión
if (!isset($_SESSION['nombre'])) {
    header("Location: ./assets/logout.php");
    exit();
}

// Incluir conexión
include("../php/conexion.php"); 

// Consulta SQL
$sql = "SELECT id, nombre, correo, rol FROM usuarios";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="../css/adminvista.css">
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="close-menu" onclick="toggleMenu()">×</div>
        <h2>ADMINISTRADOR</h2>
        <nav>
            <a href="../vistas/admin.php">GESTOR DE USUARIOS</a>
            <a href="../vistas/adminsoli.php">SOLICITUDES</a>
            <a href="../formularios/solicitudadmin.php">NUEVA SOLICITUD</a>
            <a href="#">COMPROBANTES</a>
        </nav>
    </aside>

    <div class="main">
        
        <div class="topbar">
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>
            <div class="topbar-title">Gestión de Usuarios</div>
            <a href="/proyecto/logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>

        <div class="card">
            <div class="profile">
                <img src="https://cdn-icons-png.flaticon.com/512/5989/5989226.png" alt="usuario">
                <div>
                    <p>Nombre: <span class="nombre-usuario"><?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Admin'); ?></span></p>
                    <p>Rol: <strong><?php echo htmlspecialchars($_SESSION['rol'] ?? 'Administrador'); ?></strong></p>
                </div>
            </div>
        </div>

        <div class="search">
            <input type="text" id="searchInput" placeholder="Buscar por nombre o correo...">
            <button class="btn-new" onclick="window.location.href='usuario.php'">+ Nuevo Usuario</button>
        </div>

        <div class="table-container">
            <h3>Usuarios Registrados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                <?php
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        ?>
                        <tr>
                            <td data-label="Nombre"><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td data-label="Correo"><?php echo htmlspecialchars($row['correo']); ?></td>
                            <td data-label="Rol"><?php echo htmlspecialchars($row['rol']); ?></td>
                            <td data-label="Acciones" class="actions-cell">
                                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Actualizar</a>
                                <a href="eliminar.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Baja</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='no-data'>No se encontraron usuarios.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#userTableBody tr");
            
            rows.forEach(row => {
                if(row.cells.length > 1) { // Evita la fila de "No se encontraron usuarios"
                    let nombre = row.cells[0].textContent.toLowerCase();
                    let correo = row.cells[1].textContent.toLowerCase();
                    row.style.display = (nombre.includes(filter) || correo.includes(filter)) ? "" : "none";
                }
            });
        });
    </script>
</body>
</html>