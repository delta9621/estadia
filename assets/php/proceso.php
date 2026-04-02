<?php
session_start();
//conexion a la base de datos
include  'conexion.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //el nombre se registra de directa por la sesion
    $usuario_nombre = $_SESSION['nombre'];
    //recoleccion de los datos 
    $fecha = $_POST['fecha'];
    $concepto = $_POST['concepto'];
    $monto = $_POST['monto'];
    $proveedor = $_POST['proveedor'];
    $metodo_pago = $_POST['metodo_pago'];
    $prioridad = $_POST['prioridad'];
    $observaciones = $_POST['observaciones'];

    //consulta a utilizar y insertar datos
    $sql = "INSERT INTO solicitudes (usuario_nombre, fecha, concepto, monto, proveedor, metodo_pago, prioridad, observaciones) 
    values (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql);

    if($stmt){
        mysqli_stmt_bind_param($stmt, "sssdssss", $usuario_nombre, $fecha, $concepto, $monto, $proveedor, $metodo_pago, $prioridad, $observaciones);

        if(mysqli_stmt_execute($stmt)){
            echo "<script>
                    alerte('✅ Solicitud enviada con éxito'); 
                    window.location.href='formulario.php';
                  </script>";
        }else{
            echo "Error en tu solicitud: " . mysqli_error($conexion);
          }
    } else {
        echo "Error Fatal en la preparacion de la consulta: " . mysqli_error($conexion);
        }
}

?>