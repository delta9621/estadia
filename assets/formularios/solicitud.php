<?php 
session_start();

//validacion de usuario al inicar sesion
if(!isset($_SESSION['nombre'])){
    header("Location: ./assets/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NUEVA SOLICITUD</title>
    <style>

   

    </style>
</head>
<body>
    <div class="welcome-card">
        <link rel="stylesheet" href="../css/foralta.css">
        <p>
        
            <span class="nombre-usuario">
                <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>
            </span>
        </p>

        <br>

    </div>

        <section>
            <h2>Nueva Solicitud de Pago</h2>
            <br><br>
            <form action="../php/proceso.php" method="post">
                <div>
                    <label for="fecha">Fecha: </label>
                    <input type="date" id="fecha" name="fecha">
                </div>
                <br>
                <div>
                    <label for="concepto">Concepto del Pago: </label>
                    <input type="text" id="concepto" name="concepto">
                </div>
                <br>
                <div>
                    <label for="monto">Monto: </label>
                    <input type="number" id="monto" name="monto" step="0.01">
                    
                    <label for="proveedor">Proveedor: </label>
                    <input type="text" id="proveedor" name="proveedor">
                </div>
                <br>
                <div>
                    <label>Metodo de Pago:</label>
                    <input type="radio" id="trasferencia" name="metodo_pago" value="trasferencia">
                    <label for="trasferencia">Trasferencia</label>

                    <input type="radio" id="efectivo" name="metodo_pago" value="efectivo">
                    <label for="trasferencia">Efectivo</label>

                    <input type="radio" id="cheque" name="metodo_pago" value="cheque">
                    <label for="trasferencia">Cheque</label>
                </div>
                
                <br>
                <div>
                    <label>Prioridad</label>
                    <input type="radio" id="alta" name="prioridad" value="alta">
                    <label for="alta">Alta</label>

                    <input type="radio" id="alta" name="prioridad" value="media">
                    <label for="media">Media</label>

                    <input type="radio" id="baja" name="prioridad" value="baja">
                    <label for="baja">Baja</label>
                </div>
                <br>
                <div>
                    <label for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="4" cols="50"></textarea>
                </div>
                <br>

                <button type="submit">Enviar Solicitud</button>
            </form>
        </section>
        <br>
        <br>

</body>
</html>