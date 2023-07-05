<!DOCTYPE html>
<html>
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->
    <title>Registro de Cliente</title>
    <style>
        .error {
            color: red;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-container h2 {
            text-align: center;
        }

        .form-container form {
            margin-top: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->    
<div class="form-container">
    <h2>Registro de Cliente</h2>

    <?php
    // Verificar si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        // Verificar el formato del campo DNI usando una expresión regular
        if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $dni)) {
            echo '<p class="error">El DNI debe tener 8 dígitos seguidos de una letra.</p>';
        } else {
            // Verificar si el DNI ya existe en la base de datos
            $query = "SELECT * FROM clientes WHERE DNI = '$dni'";
            $resultado = mysqli_query($conexion, $query);

            if (mysqli_num_rows($resultado) > 0) {
                // El DNI ya está en uso, mostrar mensaje de error
                echo '<p class="error">El DNI ya está en uso. Por favor, elige otro DNI.</p>';
            } else {
                // Insertar el nuevo registro en la tabla clientes
                $query_insert = "INSERT INTO clientes (DNI, Nombre, Email, Telefono, Direccion, Contrasena) 
                                 VALUES ('$dni', '$nombre', '$email', '$telefono', '$direccion', '$contrasena')";
                $resultado_insert = mysqli_query($conexion, $query_insert);

                if ($resultado_insert) {
                    // Registro exitoso, mostrar mensaje de éxito
                    echo "Registro exitoso. Puedes iniciar sesión con tu nueva cuenta.";
                    // Limpiar los campos del formulario
                    $_POST = array();
                } else {
                    // Error al insertar el registro, mostrar mensaje de error
                    echo "Error al registrar el usuario. Por favor, inténtalo nuevamente.";
                }
            }
        }

        // Cerrar la conexión con la base de datos
        mysqli_close($conexion);
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required value="<?php echo isset($_POST['dni']) ? $_POST['dni'] : ''; ?>"><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required value="<?php echo isset($_POST['telefono']) ? $_POST['telefono'] : ''; ?>"><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required value="<?php echo isset($_POST['direccion']) ? $_POST['direccion'] : ''; ?>"><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <input type="submit" value="Registrarse">
        <a href="index.php">Volver</a>
    </form>
    </div>
</body>
</html>