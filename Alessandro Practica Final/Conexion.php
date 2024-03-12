<?php
    function ConexionBD(){
        require_once("Base de Datos.php");

        $conexion = mysqli_connect($host, $user, $password, $database);
        if(!$conexion){
            die("No se pudo establecer conexión con la base de datos. Connection Failed: ".mysqli_connect_error());
        }else{
            echo "Se ha conectado correctamente a la base de datos: $database, con el usuario: $user<br><br>";
        }

        $sql = array();

        $sql[] = "DROP DATABASE IF EXISTS taller;";

        $sql[] = "CREATE DATABASE taller CHARACTER SET utf8mb4;";

        $sql[] = "USE taller;";

        $sql[] = "CREATE TABLE Proveedor (
                ID_Proveedor INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                NIF VARCHAR(9) NOT NULL,
                Nombre VARCHAR(100) NOT NULL,
                Direccion VARCHAR(255) NOT NULL,
                Ciudad VARCHAR(100) NOT NULL,
                Telefono INT(9) NOT NULL,
                Email VARCHAR(100) NOT NULL);";

        $sql[] = "CREATE TABLE Producto (
                ID_Producto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(100) NOT NULL,
                Precio DECIMAL(10, 2) NOT NULL,
                ID_Proveedor INT UNSIGNED,
                FOREIGN KEY (ID_Proveedor) REFERENCES Proveedor(ID_Proveedor));";

        $sql[] = "CREATE TABLE Taller (
                ID_Taller INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                NIF VARCHAR(9) NOT NULL,
                Nombre VARCHAR(100) NOT NULL,
                Direccion VARCHAR(255) NOT NULL,
                Ciudad VARCHAR(100) NOT NULL,
                Telefono INT(9) NOT NULL,
                ID_Producto INT UNSIGNED,
                FOREIGN KEY (ID_Producto) REFERENCES Producto(ID_Producto));";

        $sql[] = "CREATE TABLE Mecanico (
                ID_Mecanico INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                DNI VARCHAR(9) NOT NULL,
                Nombre VARCHAR(100) NOT NULL,
                Direccion VARCHAR(255) NOT NULL,
                Ciudad VARCHAR(100) NOT NULL,
                Telefono INT(9) NOT NULL,
                Email VARCHAR(100) NOT NULL,
                Especialidad VARCHAR(100) NOT NULL,
                ID_Taller INT UNSIGNED,
                FOREIGN KEY (ID_Taller) REFERENCES Taller(ID_Taller));";

        $sql[] = "CREATE TABLE Cliente (
                ID_Cliente INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                DNI VARCHAR(9) NOT NULL,
                Nombre VARCHAR(100) NOT NULL,
                Direccion VARCHAR(255) NOT NULL,
                Ciudad VARCHAR(100) NOT NULL,
                Telefono INT(9) NOT NULL,
                Email VARCHAR(100) NOT NULL);";

        $sql[] = "CREATE TABLE Vehiculo (
                ID_Vehiculo INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Marca VARCHAR(100) NOT NULL,
                Modelo VARCHAR(100) NOT NULL,
                Anio INT(4) NOT NULL,
                ID_Cliente INT UNSIGNED,
                FOREIGN KEY (ID_Cliente) REFERENCES Cliente(ID_Cliente));";

        $sql[] = "CREATE TABLE Servicio (
                ID_Servicio INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(100) NOT NULL,
                Precio DECIMAL(10, 2) NOT NULL,
                ID_Mecanico INT UNSIGNED,
                FOREIGN KEY (ID_Mecanico) REFERENCES Mecanico(ID_Mecanico));";

        $sql[] = "CREATE TABLE Reparacion (
                ID_Reparacion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Descripcion VARCHAR(255) NOT NULL,
                Fecha DATE NOT NULL,
                ID_Vehiculo INT UNSIGNED,
                FOREIGN KEY (ID_Vehiculo) REFERENCES Vehiculo(ID_Vehiculo));";

        $sql[] = "CREATE TABLE Servicio_Reparacion (
                ID_Servicio INT UNSIGNED,
                ID_Reparacion INT UNSIGNED,
                FOREIGN KEY (ID_Servicio) REFERENCES Servicio(ID_Servicio),
                FOREIGN KEY (ID_Reparacion) REFERENCES Reparacion(ID_Reparacion));";

        $sql[] = "CREATE TABLE Mantenimiento (
                ID_Mantenimiento INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Descripcion VARCHAR(255) NOT NULL,
                Fecha DATE NOT NULL,
                ID_Vehiculo INT UNSIGNED,
                FOREIGN KEY (ID_Vehiculo) REFERENCES Vehiculo(ID_Vehiculo));";

        $sql[] = "CREATE TABLE Servicio_Mantenimiento (
                ID_Servicio INT UNSIGNED,
                ID_Mantenimiento INT UNSIGNED,
                FOREIGN KEY (ID_Servicio) REFERENCES Servicio(ID_Servicio),
                FOREIGN KEY (ID_Mantenimiento) REFERENCES Mantenimiento(ID_Mantenimiento));";

        $sql[] = "CREATE TABLE Factura (
                ID_Factura INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Fecha DATE NOT NULL,
                Total DECIMAL(10, 2) NOT NULL,
                ID_Taller INT UNSIGNED,
                ID_Cliente INT UNSIGNED,
                FOREIGN KEY (ID_Taller) REFERENCES Taller(ID_Taller),
                FOREIGN KEY (ID_Cliente) REFERENCES Cliente(ID_Cliente));";

        $sql[] = "CREATE TABLE Factura_Servicio (
                ID_Factura INT UNSIGNED,
                ID_Servicio INT UNSIGNED,
                FOREIGN KEY (ID_Factura) REFERENCES Factura(ID_Factura),
                FOREIGN KEY (ID_Servicio) REFERENCES Servicio(ID_Servicio));";

        $sql[] = "INSERT INTO Proveedor (NIF, Nombre, Direccion, Ciudad, Telefono, Email) VALUES
                ('02345678A', 'Proveedor XYZ', 'Calle de los Proveedores 123', 'Madrid', '123456789', 'proveedor_xyz@example.com'),
                ('08765431B', 'Suministros Mecanicos S.A.', 'Av. de los Talleres 456', 'Barcelona', '987654321', 'suministros@example.com'),
                ('05678923C', 'Automoviles del Sur', 'Calle de los Coches 789', 'Sevilla', '456789123', 'automoviles_sur@example.com'),
                ('08912456D', 'Talleres Gonzalez', 'Av. de los Mecanicos 321', 'Valencia', '789123456', 'talleres_gonzalez@example.com'),
                ('02197654E', 'Repuestos Rapidos', 'Calle de las Piezas 654', 'Zaragoza', '321987654', 'repuestos_rapidos@example.com'),
                ('05421987F', 'MotoParts', 'Plaza de las Motos 987', 'Málaga', '654321987', 'motoparts@example.com'),
                ('08654321G', 'Neumaticos Rodriguez', 'Calle de las Ruedas 123', 'Bilbao', '987654321', 'neumaticos_rodriguez@example.com'),
                ('06789123H', 'Frenos Express', 'Av. de los Frenos 456', 'Granada', '456789123', 'frenos_express@example.com'),
                ('02345678I', 'Carrocerias del Norte', 'Calle de las Chapas 789', 'Murcia', '123456789', 'carrocerias_norte@example.com'),
                ('08765431J', 'Talleres Martinez', 'Plaza de las Reparaciones 321', 'Alicante', '987654321', 'talleres_martinez@example.com');";

        $sql[] = "INSERT INTO Producto (Nombre, Precio, ID_Proveedor) VALUES
                ('Bujia de Platino', 12.50, 1),
                ('Filtro de Aire Deportivo', 35.00, 2),
                ('Pastillas de Freno Ceramicas', 50.00, 3),
                ('Aceite de Motor Sintetico 5W-30', 40.00, 4),
                ('Lampara H7 para Faro', 8.50, 5),
                ('Escobillas Limpiaparabrisas', 15.00, 6),
                ('Kit de Distribucion', 80.00, 7),
                ('Suspension Deportiva', 300.00, 8),
                ('Llantas de Aleacion 17', 120.00, 9),
                ('Kit de Embrague', 200.00, 10);";

        $sql[] = "INSERT INTO Taller (NIF, Nombre, Direccion, Ciudad, Telefono, ID_Producto) VALUES
                ('03456789K', 'Taller Velocidad', 'Calle del Motor 123', 'Madrid', '123456789', 1),
                ('07654321L', 'Reparaciones Expres', 'Av. del Torno 456', 'Barcelona', '987654321', 2),
                ('05789123M', 'Carrocerias Lopez', 'Plaza del Pintor 789', 'Sevilla', '456789123', 3),
                ('08123456N', 'Neumaticos Garcia', 'Calle de las Gomas 321', 'Valencia', '789123456', 4),
                ('02187654O', 'MotoTaller', 'Av. de las Motos 654', 'Málaga', '321987654', 5),
                ('05431987P', 'Electromecanica Martinez', 'Plaza del Alternador 987', 'Zaragoza', '654321987', 6),
                ('08765421Q', 'Taller Diesel', 'Calle del Diesel 123', 'Bilbao', '987654321', 7),
                ('05678923R', 'Reparacion Rapida', 'Av. del Taller 456', 'Granada', '456789123', 8),
                ('02345679S', 'Lunas Express', 'Plaza del Parabrisas 789', 'Murcia', '123456789', 9),
                ('08764321T', 'ElectroAuto', 'Calle de los Electricos 321', 'Alicante', '987654321', 10);";

        $sql[] = "INSERT INTO Mecanico (DNI, Nombre, Direccion, Ciudad, Telefono, Email, Especialidad, ID_Taller) VALUES
                ('02355678A', 'Juan Perez', 'Calle Mecanico 1', 'Madrid', '123456789', 'juan_perez@example.com', 'Mecanica General', 1),
                ('08765432B', 'Maria Gomez', 'Av. Mecanica 2', 'Barcelona', '987654321', 'maria_gomez@example.com', 'Electricidad del Automovil', 2),
                ('05678012C', 'Pedro Rodriguez', 'Plaza de la Reparacion 3', 'Sevilla', '456789123', 'pedro_rodriguez@example.com', 'Chapista', 3),
                ('08982345D', 'Laura Martinez', 'Calle de las Reparaciones 4', 'Valencia', '789123456', 'laura_martinez@example.com', 'Mecanica de Motocicletas', 4),
                ('02798765E', 'Antonio Sanchez', 'Av. de los Motores 5', 'Zaragoza', '321987654', 'antonio_sanchez@example.com', 'Reparacion de Frenos', 5),
                ('05432998F', 'Ana Lopez', 'Plaza del Motor 6', 'Málaga', '654321987', 'ana_lopez@example.com', 'Reparacion de Suspensiones', 6),
                ('08765432G', 'David Garcia', 'Calle de las Motos 7', 'Bilbao', '987654321', 'david_garcia@example.com', 'Mecanica de Automoviles Clasicos', 7),
                ('07678912H', 'Sandra Martin', 'Av. de los Coches 8', 'Granada', '456789123', 'sandra_martin@example.com', 'Reparacion de Sistemas de Escape', 8),
                ('02345679I', 'Carlos Hernandez', 'Plaza del Automovil 9', 'Murcia', '123456789', 'carlos_hernandez@example.com', 'Electricidad Automotriz', 9),
                ('08745432J', 'Elena Diaz', 'Calle de las Piezas 10', 'Alicante', '987654321', 'elena_diaz@example.com', 'Mecanica de Motores Diesel', 10);";

        $sql[] = "INSERT INTO Cliente (DNI, Nombre, Direccion, Ciudad, Telefono, Email) VALUES
                ('02345778A', 'Antonio Garcia', 'Calle del Cliente 1', 'Madrid', '123456789', 'antonio_garcia@example.com'),
                ('08735432B', 'Maria Rodriguez', 'Av. del Consumidor 2', 'Barcelona', '987654321', 'maria_rodriguez@example.com'),
                ('05670912C', 'Juan Sanchez', 'Plaza de los Compradores 3', 'Sevilla', '456789123', 'juan_sanchez@example.com'),
                ('08012345D', 'Laura Lopez', 'Calle de las Ventas 4', 'Valencia', '789123456', 'laura_lopez@example.com'),
                ('02194765E', 'Pedro Martinez', 'Av. de los Usuarios 5', 'Zaragoza', '321987654', 'pedro_martinez@example.com'),
                ('05438198F', 'Ana Perez', 'Plaza de los Clientes 6', 'Málaga', '654321987', 'ana_perez@example.com'),
                ('08765472G', 'David Gonzalez', 'Calle del Consumidor 7', 'Bilbao', '987654321', 'david_gonzalez@example.com'),
                ('05778912H', 'Sandra Fernandez', 'Av. de los Compradores 8', 'Granada', '456789123', 'sandra_fernandez@example.com'),
                ('02345698I', 'Carlos Ruiz', 'Plaza del Cliente 9', 'Murcia', '123456789', 'carlos_ruiz@example.com'),
                ('08764432J', 'Elena Sanchez', 'Calle de las Ventas 10', 'Alicante', '987654321', 'elena_sanchez@example.com');";

        $sql[] = "INSERT INTO Vehiculo (Marca, Modelo, Anio, ID_Cliente) VALUES
                ('Ford', 'Focus', 2018, 1),
                ('Toyota', 'Corolla', 2017, 2),
                ('Volkswagen', 'Golf', 2019, 3),
                ('Honda', 'Civic', 2016, 4),
                ('Hyundai', 'Elantra', 2020, 5),
                ('Chevrolet', 'Cruze', 2015, 6),
                ('Nissan', 'Sentra', 2019, 7),
                ('Kia', 'Forte', 2017, 8),
                ('Mazda', '3', 2018, 9),
                ('Subaru', 'Impreza', 2020, 10);";

        $sql[] = "INSERT INTO Servicio (Nombre, Precio, ID_Mecanico) VALUES
                ('Cambio de Aceite y Filtro', 50.00, 1),
                ('Cambio de Bujias', 30.00, 2),
                ('Revision de Frenos', 80.00, 3),
                ('Cambio de Correa de Distribucion', 120.00, 4),
                ('Reparacion de Suspension', 150.00, 5),
                ('Cambio de Amortiguadores', 200.00, 6),
                ('Alineacion y Balanceo', 60.00, 7),
                ('Cambio de Liquido Refrigerante', 70.00, 8),
                ('Revision del Sistema de Escape', 90.00, 9),
                ('Reparacion de Sistema Electrico', 100.00, 10);";

        $sql[] = "INSERT INTO Reparacion (Descripcion, Fecha, ID_Vehiculo) VALUES
                ('Cambio de Aceite', '2023-01-05', 1),
                ('Reparacion de Sistema de Frenos', '2023-02-10', 2),
                ('Cambio de Correa de Distribucion', '2023-03-15', 3),
                ('Revision de Amortiguadores', '2023-04-20', 4),
                ('Reparacion de Sistema Electrico', '2023-05-25', 5),
                ('Cambio de Neumaticos', '2023-06-30', 6),
                ('Revision de Sistema de Escape', '2023-07-05', 7),
                ('Cambio de Bateria', '2023-08-10', 8),
                ('Reparacion de Transmision', '2023-09-15', 9),
                ('Recarga de Aire Acondicionado', '2023-10-20', 10);";

        $sql[] = "INSERT INTO Servicio_Reparacion (ID_Servicio, ID_Reparacion) VALUES
                (1, 1),
                (2, 2),
                (3, 3),
                (4, 4),
                (5, 5),
                (6, 6),
                (7, 7),
                (8, 8),
                (9, 9),
                (10, 10);";

        $sql[] = "INSERT INTO Mantenimiento (Descripcion, Fecha, ID_Vehiculo) VALUES
                ('Mantenimiento Preventivo', '2023-01-05', 1),
                ('Mantenimiento Correctivo', '2023-02-10', 2),
                ('Mantenimiento Preventivo', '2023-03-15', 3),
                ('Mantenimiento Correctivo', '2023-04-20', 4),
                ('Mantenimiento Preventivo', '2023-05-25', 5),
                ('Mantenimiento Correctivo', '2023-06-30', 6),
                ('Mantenimiento Preventivo', '2023-07-05', 7),
                ('Mantenimiento Correctivo', '2023-08-10', 8),
                ('Mantenimiento Preventivo', '2023-09-15', 9),
                ('Mantenimiento Correctivo', '2023-10-20', 10);";

        $sql[] = "INSERT INTO Servicio_Mantenimiento (ID_Servicio, ID_Mantenimiento) VALUES
                (1, 1),
                (2, 2),
                (3, 3),
                (4, 4),
                (5, 5),
                (6, 6),
                (7, 7),
                (8, 8),
                (9, 9),
                (10, 10);";

        $sql[] = "INSERT INTO Factura (Fecha, Total, ID_Taller, ID_Cliente) VALUES
                ('2023-01-05', 150.00, 1, 1),
                ('2023-02-10', 200.00, 2, 2),
                ('2023-03-15', 300.00, 3, 3),
                ('2023-04-20', 400.00, 4, 4),
                ('2023-05-25', 500.00, 5, 5),
                ('2023-06-30', 600.00, 6, 6),
                ('2023-07-05', 700.00, 7, 7),
                ('2023-08-10', 800.00, 8, 8),
                ('2023-09-15', 900.00, 9, 9),
                ('2023-10-20', 1000.00, 10, 10);";

        $sql[] = "INSERT INTO Factura_Servicio (ID_Factura, ID_Servicio) VALUES
                (1, 1),
                (2, 2),
                (3, 3),
                (4, 4),
                (5, 5),
                (6, 6),
                (7, 7),
                (8, 8),
                (9, 9),
                (10, 10);";

        foreach($sql as $query){
            if(mysqli_query($conexion, $query)){
                echo "Consulta $query insertada exitosamente<br><br>";
            }else{
                echo "Error: ".$query."<br>".mysqli_error($conexion);
            }
        }
        mysqli_close($conexion);
    }

    ConexionBD();
?>