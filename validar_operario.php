<?php
session_start(); // Iniciar la sesión (si no se ha iniciado previamente)
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
</head><style>
    .btn-volver {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ccc;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
</style>
<body>
   <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --> 
<?php
// Verificar si ya hay una sesión iniciada
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
$query = "SELECT * FROM operarios WHERE dni = '$dni' AND contrasena = '$contrasena'";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) > 0) {
    // Sesión iniciada, guardar el DNI en la sesión
    $_SESSION['dni'] = $dni;

    // Redirigir al índice
    header('Location: encargos_pendientes.php');
    exit;
} else {
    // El usuario no existe o las credenciales son incorrectas
    echo "El usuario no existe o las credenciales son incorrectas.";
}
// Cerrar la conexión con la base de datos
mysqli_close($conexion);
?>

<a href="index.php" class="btn-volver">Volver</a>
</body>
</html>