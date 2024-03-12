<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Insertar Modificar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Taller Alessandro Wild</title>
</head>
<body>
    <?php
        session_start();
    
        // Verifico si el formulario ha sido enviado
        if($_POST){
            $usuario = $_POST['usuario'];

            echo "<div>
                    <h2>Hola $usuario ¿Que quieres hacer?</h2>
                    <form action='' method='post'>
                        <input type='submit' name='insertar' value='Insertar Datos'>
                        <input type='submit' name='modificar' value='Modificar Datos'>
                    </form>
                </div>";

            // Verifico si se ha pulsado el botón "Insertar" y redirijo a la pagina al Mecanico para que inserte datos a la BD
            if(isset($_POST['insertar'])){
                $_SESSION['insertar'] = true;
                header("Location: Insertar Cliente Vehiculo.php");
                exit();
            }elseif(isset($_POST['modificar'])){ // Verifico si se ha pulsado el botón "Modificar" y redirijo a la pagina al Mecanico para que modifique los datos de la BD
                $_SESSION['modificar'] = true;
                header("Location: Modificar Cliente Vehiculo.php");
                exit();
            }
        }
    ?>
</body>
</html>