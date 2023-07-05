<?php
// Obtener los datos del formulario
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$contrasena = $_POST['contrasena'];

// Establecer la conexión con la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

if (!$conexion) {
    // Error al conectar con la base de datos, mostrar mensaje de error o redirigir a página de error
    echo "Error al conectar con la base de datos. Por favor, inténtalo nuevamente.";
    exit;
}

// Insertar el nuevo registro en la tabla clientes
$query_insert = "INSERT INTO clientes (DNI, Nombre, Email, Telefono, Direccion, Contrasena) 
                 VALUES ('$dni', '$nombre', '$email', '$telefono', '$direccion', '$contrasena')";
$resultado_insert = mysqli_query($conexion, $query_insert);

if ($resultado_insert) {
    // Registro exitoso, mostrar mensaje de éxito o redirigir a página de inicio
    echo "Registro exitoso. Puedes iniciar sesión con tu nueva cuenta.";
} else {
    // Error al insertar el registro, mostrar mensaje de error o redirigir a página de error
    echo "Error al registrar el usuario. Por favor, inténtalo nuevamente.";
}

// Cerrar la conexión con la base de datos
mysqli_close($conexion);
?>