<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    //ecriptaccion de contraseña asignada
    $password_hash = Password_hash($password, PASSWORD_BCRYPT);


    //INSERTAR USUARIO
    $sql = "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("ssss" ,$nombre ,$correo ,$password_hash ,$rol);


    //verificacion
    if($stmt->execute()){
        echo "<br> ✅ Usuario registrado con exito";
    } else {
        if($conexion->errno == 1062 ){
            echo "<br>❌ Error: El correo ya está registrado.";
        } else {
            echo "<br>❌ Error al registrar: " . $stmt->error;
        }
    }


$conexion->close();

}

?>
