<?php
// Función para generar una nueva contraseña aleatoria
function generateNewPassword() {
    $length = 8; // Longitud de la contraseña
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, strlen($characters) - 1);
        $password .= $characters[$randomIndex];
    }

    return $password;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el DNI y correo electrónico del formulario
    $dni = $_POST['dni'];
    $email = $_POST['email'];

    // Verificar si el DNI y correo electrónico son válidos (agrega tus propias validaciones aquí)

    // Generar una contraseña nueva
    $newPassword = generateNewPassword();

    // Actualizar la contraseña en la tabla de clientes (asumiendo que tienes una conexión a la base de datos)
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $query = "UPDATE clientes SET contrasena = '$hashedPassword' WHERE dni = '$dni' AND email = '$email'";
    mysqli_query($conexion, $query);

    // Enviar el correo electrónico con la nueva contraseña
    $subject = 'Recuperación de contraseña';
    $message = "Tu nueva contraseña es: $newPassword";
    $headers = 'From: Eligecoche@gmail.com' . "\r\n" .
               'Reply-To: Eligecoche@gmail.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    $success = mail($email, $subject, $message, $headers);

    if ($success) {
        echo 'Se ha enviado un correo electrónico con una nueva contraseña.';
    } else {
        echo 'Ha ocurrido un error al enviar el correo electrónico.';
    }
}
?>

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
    <title>Recuperar contraseña</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f1f1f1;
            margin-right: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
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

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #666;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <h2>Recuperar contraseña</h2>
    <form method="POST" action="">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" required><br><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required><br><br>

        <input type="submit" value="Recuperar contraseña">
    </form>
    
    <br>
    <a href="index.php">Volver a Index</a>
</body>
</html>
