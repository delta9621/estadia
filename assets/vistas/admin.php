<?php 
session_start();

// 1. Validación de sesión
if (!isset($_SESSION['nombre'])) {
    header("Location: ./assets/logout.php");
    exit();
}

// 2. Incluir conexión
include("../php/conexion.php"); 

// Consulta SQL
$sql = "SELECT id, nombre, correo, rol, password FROM usuarios";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="../css/adminvista.css">
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <h2>ADMINISTRADOR</h2>
        <nav>
            <a class="active" href="../vistas/admin.php">USUARIOS</a>
            <a href="../vistas/solicitudes.php">SOLICITUDES</a>
            <a href="../formularios/solicitud.php">NUEVA SOLICITUD</a>
            <a href="">COMPROBANTES</a>
            <a href="../vistas/usuarios.php">POLITICAS</a>
            <a href="/proyecto/logout.php" class="logout-mobile">CERRAR SESIÓN</a>
        </nav>
    </aside>

    <div class="main">

        <div class="topbar">
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>
            <a href="../../logout.php" class="logout-btn">Cerrar sesión</a>
        </div>

        <div class="card">
            <div class="profile">
                <img src="https://cdn-icons-png.flaticon.com/512/5989/5989226.png" alt="usuario">
                <div>
                    <p>Nombre: 
                        <span class="nombre-usuario">
                            <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Administrador'); ?>
                        </span>
                    </p><br>
                    <p>Rol: 
                        <strong>
                            <?php echo htmlspecialchars($_SESSION['rol'] ?? 'Admin'); ?>
                        </strong>
                    </p>
                </div>
            </div>
        </div>

        <div class="search">
            <input type="text" id="searchInput" placeholder="Buscar por nombre o correo...">
            <button class="btn-new" onclick="window.location.href='usuario.php'">
                Nuevo Usuario
            </button>
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
                <tbody>
                <?php
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['correo']); ?></td>
                            <td><?php echo htmlspecialchars($row['rol']); ?></td>

                            <td>
                                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">
                                    Actualizar
                                </a>

                                <a href="eliminar.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    Dar de Baja 
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>No se encontraron usuarios.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
      
        
        // Buscador corregido
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelector("table tbody").rows;
            
            for (let i = 0; i < rows.length; i++) {
                // Buscamos en Nombre (Columna 0) y Correo (Columna 1)
                let nombre = rows[i].cells[0].textContent.toLowerCase();
                let correo = rows[i].cells[1].textContent.toLowerCase();
                
                if (nombre.includes(filter) || correo.includes(filter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }      
            }
        });
    </script>

</body>
</html>