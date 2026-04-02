<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Acceso al sistema</title>

<link rel="stylesheet" href="assets/css/logout.css">

</head>

<body>

<div class="container">


    <div class="left">
        <div class="logo">
            <img src="lo.jpeg" alt="logo">
        </div>
    </div>

    <div class="right">

        <form action="./assets/php/login.php" method="post">

            <h2>Acceso al sistema</h2>

            <label>Correo:</label>
            <input type="email" name="correo" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Ingresar</button>

        </form>

    </div>

</div>

</body>
</html>