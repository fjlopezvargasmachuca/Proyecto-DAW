<?php
session_start();
?>
<html><head>
<style>
.btn-volver {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ccc;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
</style>

    </head>
<body>

<?php
if (isset($_SESSION['dni'])) {
    // Usuario logueado, obtener los datos del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $kilometros = $_POST['kilometros'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $cliente = $_SESSION['dni']; // DNI del cliente logueado

    // Realizar la conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

    // Insertar los datos en la tabla "ventas"
    $query = "INSERT INTO ventas (Marca, Modelo, Kilometros, Cliente, Precio, Descripcion) 
              VALUES ('$marca', '$modelo', '$kilometros', '$cliente', '$precio', '$descripcion')";
    $result = mysqli_query($conexion, $query);

    // Verificar si la inserción fue exitosa
    if ($result) {
        echo "Venta guardada exitosamente.";
    } else {
        echo "Error al guardar la venta.";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    echo "Acceso no autorizado.";
}
?>
<a href="index.php" class="btn-volver">Volver</a>
</body>
</html>