<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LoginPaneles</title>

    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<form action="index.php" method="POST">
    <?php
    if(isset($errorLogin)){
        echo $errorLogin;
    }

    if(isset($_GET["error"])){
        $error = $_GET["error"];
        switch ($error) {
            case 1:
                echo "El Código de Evento no coincide con el del Panel Central";
                break;
            case 2:
                echo "No se ha introducido el Código de Evento";
                break;
            case 3:
                echo "La petición debe llegar del servidor externo";
                break;
            default:
                echo "Error inesperado no registrado";
                break;
        }
        $_GET["error"] = 0;
    }

    ?>
    <h2>Iniciar sesión en el panel de control</h2>
    <p>Nombre de administrador: <br>
        <input type="text" name="username" required></p>
    <p>Contraseña: <br>
        <input type="password" name="password" required></p>
    <p>Código del Evento: <br>
        <input type="text" name="codEvento" required></p>
    <p class="center"><input type="submit" value="Iniciar Sesión"></p>
</form>
</body>
</html>
