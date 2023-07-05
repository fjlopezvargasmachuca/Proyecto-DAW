<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
<head>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->

    <title>Encargos Completados</title>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <?php

    // Verificar si el operario ha iniciado sesión
    if (!isset($_SESSION['operario'])) {
        // Redirigir a la página de login de operarios si no ha iniciado sesión
        header("Location: login_operarios.php");
        exit;
    }

    // Obtener el operario de la sesión
    $operario = $_SESSION['operario'];

    // Realizar la conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

    // Obtener los encargos completados del operario y mostrarlos en la página
    $query = "SELECT * FROM encargos_completados WHERE dni_operario = '$operario'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Operario: $operario</h2>";
        echo "<h3>Encargos Completados:</h3>";
        echo "<ul>";

        while ($row = mysqli_fetch_assoc($result)) {
            $idEncargo = $row['idencargo'];
            $idFactura = $row['id_factura'];

            // Obtener las partes seleccionadas del coche de la factura
            $queryFactura = "SELECT * FROM factura WHERE id = $idFactura";
            $resultFactura = mysqli_query($conexion, $queryFactura);
            $rowFactura = mysqli_fetch_assoc($resultFactura);
            $partesCoche = $rowFactura['partes_coche'];

            echo "<li>Encargo $idEncargo:</li>";
            echo "<ul>";

            // Mostrar las partes seleccionadas del coche
            foreach (explode(',', $partesCoche) as $parte) {
                echo "<li>$parte</li>";
            }

            echo "</ul>";
        }

        echo "</ul>";
    } else {
        echo "<h2>No hay encargos completados para el operario: $operario</h2>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
    ?>
</body>
</html>
