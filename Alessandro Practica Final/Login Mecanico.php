<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Login Mecanico.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Taller Alessandro Wild</title>
</head>
<body>
    <div>
        <h2>Iniciar Sesión - Mecánico</h2>
        <form action="Insertar Modificar.php" method="post">
            <label for="usuario">Usuario:</label><br>
            <input type="text" id="usuario" name="usuario"><br><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" id="enviar" value="Iniciar sesión">
        </form>
    </div>

    <?php
        session_start();

        if($_POST){
            // Desactivo la visualización de errores en pantalla, es para quitar el error cuando le doy click al boton "Cerrar Sesión"
            // y me redirige al Login
            ini_set('display_errors', 0);

            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            // Verifico las credenciales para iniciar sesión
            if($usuario === 'Mecanico' && $password === 'Aprobado10' || $password === 'Aprobado10'){
                // Inicio sesión y redirijo a la pagina para saber que quiere gestionar el Mecanico
                $_SESSION['usuario'] = $usuario;
                header("Location: Insertar Modificar.php");
                exit();
            }else{
                $mensaje_error = "Usuario o contraseña incorrecta";
            }

            // Si no coincide el Usuario y la Contraseña salta el mensaje de error
            if(isset($mensaje_error)){
                echo "<p>$mensaje_error</p>";
            }
        }
    ?>
</body>
</html>