<html>
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->
    <title>Formulario de Venta</title>
    <!-- Agrega aquí tus estilos y scripts -->
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <h1>Formulario de Venta</h1>

    <?php
    session_start();

    // Verificar si el usuario está logueado
    if (isset($_SESSION['dni'])) {
        // Usuario logueado, mostrar solo el formulario de características del coche
        ?>
        <form action="guardar_venta.php" method="POST">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required><br>

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required><br>

            <label for="kilometros">Nº de KM:</label>
            <input type="number" id="kilometros" name="kilometros" required><br>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" required><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea><br>

            <input type="submit" value="Guardar Venta">
        </form>
        <?php
    } else {
        // Usuario no logueado, mostrar un mensaje de inicio de sesión
        echo "<p>Para completar el formulario de venta, debes iniciar sesión.</p>";
    }
    ?>

    <!-- Agrega aquí otros elementos de la página -->

</body>
</html>