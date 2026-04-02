<?php
session_start(); 

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    //  Consulta 
    $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE correo = ?";
    
    $stmt = $conexion->prepare($sql);

    // Verificamos si la preparación falló
    if (!$stmt) {
        die("Error en la base de datos: " . $conexion->error);
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($usuario = $resultado->fetch_assoc()){
        //  Comparacion de contraseña
        if(password_verify($pass, $usuario['password'])){

            // Guardamos datos en la sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre']; 
            $_SESSION['rol'] = $usuario['rol'];

            // Redireccion dependiendo del rol
            switch($usuario['rol']){
                case 'administrador':
                    header("Location: ../vistas/admin.php");
                    break;
                case 'contador':
                    header("Location: ../vistas/contador.php");
                    break;
                case 'usuario':
                    header("Location: ../vistas/solicitudes.php");
                    exit();
                    break;
                default:
                    header("Location: logout.html?error=rol_no_valido");
            }
            exit(); 
        }
    }
    echo "<br>Correo o contraseña incorrectos.";
}
?>