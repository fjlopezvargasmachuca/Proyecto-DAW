<?php
// Verificar si ya hay una sesión iniciada

session_start();
?>

<html>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->

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
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
if (isset($_SESSION['dni'])) {
    // Sesión iniciada, mostrar mensaje y opción para cerrar sesión
    echo "La sesión ya está iniciada con el DNI {$_SESSION['dni']}. ¿Deseas cerrar la sesión?";
    echo '<form action="cerrar_sesion.php" method="POST">
            <input type="submit" value="Cerrar sesión">
          </form>';
    exit;
}

// Obtener los datos del formulario
$dni = $_POST['DNI'];
$contrasena = $_POST['contrasena'];

// Establecer la conexión con la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

if (!$conexion) {
    // Error al conectar con la base de datos, mostrar mensaje de error o redirigir a página de error
    echo "Error al conectar con la base de datos. Por favor, inténtalo nuevamente.";
    exit;
}

// Verificar si el usuario ya existe
$query = "SELECT * FROM clientes WHERE DNI = '$dni' AND Contrasena = '$contrasena'";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) > 0) {
    // Sesión iniciada, guardar el DNI en la sesión
    $_SESSION['dni'] = $dni;
    // Redirigir al índice
    header('Location: index.php');
    exit();
} else {
    // El usuario no existe o las credenciales son incorrectas
    echo "El usuario no existe o las credenciales son incorrectas.";
}
// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Obtener la dirección del cliente del encargo completado
    if (isset($_SESSION['direccion_cliente'])) {
        $direccionCliente = $_SESSION['direccion_cliente'];

        // Mostrar el mensaje de encargo completado
        echo "<div class='mensaje-exito'>";
        echo "¡El encargo se ha completado con éxito!<br>";
        echo "El coche se enviará a la siguiente dirección: $direccionCliente<br>";
        echo "<label><input type='checkbox' name='no_mostrar' value='1'> No mostrar este mensaje nuevamente</label>";
        echo "</div>";

        // Eliminar la dirección del cliente de la variable de sesión
        unset($_SESSION['direccion_cliente']);
    }
}
// Cerrar la conexión con la base de datos
mysqli_close($conexion);
?>

<a href="index.php" class="btn-volver">Volver</a>
</body>
</html>