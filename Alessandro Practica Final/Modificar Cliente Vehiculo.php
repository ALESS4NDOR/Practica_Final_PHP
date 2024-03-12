<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Modificar Cliente Vehiculo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Taller Alessandro Wild</title>
</head>
<body>
<div class="container">
        <h2>Modificar Cliente y Vehículo</h2>
        <form action="" method="post" class="formulario1">
            <div class="caja1">
                <label for="cliente">Cliente:</label><br>
                <input type="text" id="cliente" name="cliente" required><br><br>
                <label for="ciudad">Ciudad:</label><br>
                <input type="text" id="ciudad" name="ciudad" required><br><br>
                <label for="vehiculo">Vehículo:</label><br>
                <input type="text" id="vehiculo" name="vehiculo" required><br><br>
            </div>
            <div class="caja2">
                <label for="dni">DNI:</label><br>
                <input type="text" id="dni" name="dni" maxlength="9" required><br><br>
                <label for="telefono">Telefono:</label><br>
                <input type="number" id="telefono" name="telefono" max="999999999"><br><br>
                <label for="modelo">Modelo:</label><br>
                <input type="text" id="modelo" name="modelo" required><br><br>
            </div>
            <div class="caja3">
                <label for="direccion">Direccion:</label><br>
                <input type="text" id="direccion" name="direccion" required><br><br>
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email"><br><br>
                <label for="anio">Año:</label><br>
                <input type="number" id="anio" name="anio" max="2999" required><br><br>
            </div>
            <input type="submit" value="Modificar">
        </form>
    </div>

    <?php
        session_start();

        if($_POST){
            include("Base de Datos.php");

            $conexion = mysqli_connect($host, $user, $password, $database);
            if(!$conexion){
                die("No se pudo establecer conexión con la base de datos. Connection Failed: ".mysqli_connect_error());
            }

            $cliente = $_POST['cliente'];
            $dni = $_POST['dni'];
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];
            $vehiculo = $_POST['vehiculo'];
            $modelo = $_POST['modelo'];
            $anio = $_POST['anio'];

            // Función de validación de DNI español
            function validarDNI($dni){
                return preg_match('/^0[1-9]{7}[A-Z]{1}$/', $dni);
            }

            // Función de validación de NIE español
            function validarNIE($dni){
                return preg_match('/^[A-Z]{1}[0-9]{7}[A-Z]{1}$/', $dni);
            }

            $sql = array();

            // Valido el DNI
            if(validarDNI($dni) || validarNIE($dni)){
                // Modifico los datos en la base de datos
                $sql[] = "UPDATE cliente
                          SET Direccion = '$direccion', Ciudad = '$ciudad'
                          WHERE DNI = '$dni';";

                $sql[] = "UPDATE vehiculo
                          SET Marca = '$vehiculo', Modelo = '$modelo', Anio = '$anio'
                          WHERE ID_Cliente = (SELECT ID_Cliente FROM Cliente WHERE DNI = '$dni')";

                // Recorro todos los arrays ($sql[]) para ejecutar cada consulta
                foreach($sql as $query){
                    if(mysqli_query($conexion, $query)){
                        echo "<p>Consulta $query insertada exitosamente</p>";
                    }else{
                        echo "<p>Error: $query</p><br>".mysqli_error($conexion);
                    }
                }
                // Cierro la conexión a la base de datos
                mysqli_close($conexion);
            }else{
                echo "El DNI no es válido.";
            }

            // Boton para cerrar sesión
            echo "<form action='Login Mecanico.php' method='post' class='formulario2'>
                    <input type='submit' name='cerrar sesion' value='Cerrar Sesion'>
                  </form>";

            // Verifico si se ha pulsado el botón "Cerrar Sesion" y lo redirijo al Login
            if(isset($_POST['cerrar sesion'])){
                session_destroy();
                header("Location: Login Mecanico.php");
                exit();
            }
        }
    ?>
</body>
</html>