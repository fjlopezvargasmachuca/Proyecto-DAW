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
</head>
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
    <body><!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php
// Verificar si hay una sesión iniciada
if (isset($_SESSION['dni'])) {
    // La sesión está abierta, mostrar la sesión y el botón de cerrar sesión
    $dni = $_SESSION['dni'];
    echo 'Sesión iniciada como: ' . $dni;
    echo '<form action="cerrar_sesion.php" method="POST">';
    echo '<input type="submit" value="Cerrar sesión">';
    echo '</form>';
} else {
    // No hay sesión iniciada, mostrar el formulario de inicio de sesión
    echo '
    <form action="validar_operario.php" method="POST">
        <label for="DNI">DNI:</label>
        <input type="text" id="DNI" name="DNI" required><br><br>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        
        <input type="submit" value="Iniciar sesión">
    </form>';
}
?>
<p><a href="index.php" class="btn-volver">Volver</a></p>

</body>
</html>