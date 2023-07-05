<!DOCTYPE html>
<html>
<head>
<?php
    session_start();
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->
<title>Venta de Coches Personalizados</title>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VND1STDBMF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VND1STDBMF');
</script>
<link rel="stylesheet" type="text/css" href="styles.css">
  <style>
        body {
            font-family: "Arial";
            font-size: 16px;
            background-color: white;
        }

        table {
            width: 100%;
            
        }

        table, th, td {
            border-bottom: 1px solid black;
            text-align: center;
            margin-top: 100px;
        }

        td {
            padding: 0.5em;
        }

        td:hover{
            background-color: lightgray;
        }

        .login-info {
            color: white;
            font-weight: bold;
            text-decoration: underline;
            font-size: 0.8em;
            border-bottom: 1px solid white;
            padding-bottom: 2em;
            margin-bottom: 2em;
        }

        .logout {
            width: 100%;
        }

        .project-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 175px;
            height: 100vh;
            background-color: black;
            color: white !important;
            box-sizing: border-box;
            padding: 1em;
        }

        .project-sidebar ul {
            padding-left: 0;
            list-style-type: none;
        }

        .project-sidebar li a {
            display: block;
            margin-bottom: 0.5em;
            color: white;
            padding-left: 0;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: 0.5s ease;
        }

        .project-sidebar li a:hover {
            padding-left: 0.5em;
        }

        .social-links-bottom {
            border-top: 1px solid white;
            padding-top: 2em;
            position: absolute;
            bottom: 16px;
            left: 0;
            width: 100%;
        }

        .social-links-bottom a{
            font-size: 0.8em;
            color: white;
            text-decoration: none;
        }

        #content {
            margin-left: 200px; /* Ancho del sidebar */
            padding: 20px;
            box-sizing: border-box;
        }

        .contact-data {
            text-align: center;
        }

        .contact-data label {
            font-weight: bold;
            text-decoration: underline;
            font-size: 1.2em;
        }

        .contact-data input {
            display: block;
            padding: 1em;
            margin: 1em auto 0;
        }

        .contact-data textarea {
            margin-top: 1em;
            width: 200px;
            height: 50px;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 175px;
            height: 15vh;
            width: calc(100vw - 175px);
            background-color: black;
            color: white;
            font-size: 0.8em;
            text-align: center;
        }

        .login-menu {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        /* Estilos para el div del catálogo */
        .catalogo-container {
            text-align: center;
            margin-top: 170px;
            padding-bottom: 80px; /* Espacio adicional para el aviso de cookies */
        }

        #cookie-notice {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            text-align: center;
            background-color: rgba(240, 240, 240, 0.8); /* Cambiar el valor de "0.8" según tu preferencia */
            backdrop-filter: blur(5px); /* Aplicar un efecto de desenfoque en el fondo */
        }

        #accept-cookies {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .catalogo-container h4 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .catalogo-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ccc;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('a').click(function(event) {
                event.preventDefault();
                var page = $(this).attr('href');
                $('#content').load(page);
            });
        });
    </script>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="login-menu">
    <?php

    // Verificar si hay una sesión iniciada
    if ( !isset($_SESSION['dni'])) {
        // La sesión está abierta, mostrar la sesión y el botón de cerrar sesión
        echo '
        <form action="login.php" method="POST">
            <label for="DNI">DNI:</label>
            <input type="text" id="DNI" name="DNI" required><br><br>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <input type="submit" value="Iniciar sesión">
        </form>';
    }
?>
      </div>
    <?php
        require 'config.php';
        // Importar los controladores necesarios
        require 'controllers/HomeController.php';
        require 'controllers/CarSalesController.php';
        require 'controllers/CarRepairController.php';
        require 'controllers/CarCustomizationController.php';
        require 'controllers/AuthController.php';
        require_once 'funciones.php';
?>
 
     <!-- Script y estilos adicionales -->
        <script src="script.js"></script>
        <link rel="stylesheet" type="text/css" href="additional-styles.css">
        <div class="content" id="content">  
        </div>

  <div id="sidebar" class="project-sidebar">
    <div class="login-info">
    <?php
        if (isset($_SESSION['dni'])) {
            echo '<p>Bienvenido: ' . $_SESSION['dni'] . '</p>';
            echo '<form action="cerrar_sesion.php" method="POST">';
            echo '<input class="logout" type="submit" value="Cerrar sesión">';
            echo '</form>';
        } 
    ?>
    </div>
        <ul>
            <li>
                <a href="quienes_somos.php">Quienes Somos</a>
            </li>
            <li>
                <a href="crear_coche.php">Crea tu coche</a>
            </li>
            <li>
                <a href="mantenimiento.php">Mantenimiento de coches</a>
            </li>
            <li>
                <a href="seguimiento.php">Seguimiento de mantenimiento coches</a>
            </li>
            <li>
                <a href="contacto.php">Contacto</a>
            </li>
            <li>
                <a href="login_operarios.php">Login Operarios</a>
            </li>
            <li>
                <a href="formulario.php">Quiero vender un coche</a>
            </li>
            <li>
                <a href="mostrar_ofertas.php">Ofertas de clientes</a>
            </li>
            <li>
                <a href="ranking.php">Recomendaciones de los usuarios</a>
            </li>
        </ul>
        <div class="social-links-bottom">
                <a href="forgot-password.php">¿Olvidaste tu contraseña?</a><br>
                <a href="create-account.php">Crear nueva cuenta</a>
        </div>
    </div>

    <div class="catalogo-container">
    <h4>Catálogo</h4>
    <a href="mostrar_caracteristicas.php" target="_blank">Ver Precios</a>
    <div id="cookie-notice">
        <p>Utilizamos cookies para mejorar tu experiencia en nuestro sitio web. Al continuar navegando, aceptas nuestro uso de cookies.</p>
        <button id="accept-cookies">Aceptar</button>
    </div>
</div>
<script>
    // Obtener el elemento del aviso de cookies
    const cookieNotice = document.getElementById('cookie-notice');

    // Verificar si el usuario ya ha aceptado las cookies
    const cookiesAccepted = localStorage.getItem('cookiesAccepted');

    // Mostrar u ocultar el aviso de cookies según la preferencia del usuario
    if (cookiesAccepted) {
        cookieNotice.style.display = 'none';
    } else {
        cookieNotice.style.display = 'block';
    }

    // Agregar un evento al botón de aceptar cookies
    const acceptCookiesButton = document.getElementById('accept-cookies');
    acceptCookiesButton.addEventListener('click', () => {
        // Al hacer clic en el botón, almacenar la preferencia del usuario
        localStorage.setItem('cookiesAccepted', true);
        // Ocultar el aviso de cookies
        cookieNotice.style.display = 'none';
    });
</script>
</body>
</html>
