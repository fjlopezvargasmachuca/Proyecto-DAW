<?php
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
    <title>Encargos Pendientes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Manejar el evento click del botón "Guardar Progreso"
            $('#guardar-progreso').on('click', function() {
                var encargosSeleccionados = [];

                // Obtener los encargos seleccionados
                $('input[name="encargo[]"]:checked').each(function() {
                    encargosSeleccionados.push($(this).val());
                });

                // Obtener los valores de los checkboxes seleccionados para cada encargo
                var partesSeleccionadas = {};
                for (var i = 0; i < encargosSeleccionados.length; i++) {
                    var encargoId = encargosSeleccionados[i];
                    partesSeleccionadas[encargoId] = [];

                    $('input[name="partes_coche_'+ encargoId +'[]"]:checked').each(function() {
                        partesSeleccionadas[encargoId].push($(this).val());
                    });
                }

                // Enviar los datos mediante AJAX al archivo "actualizar_encargo.php"
                $.ajax({
                    url: 'actualizar_encargo.php',
                    type: 'POST',
                    data: {
                        encargos: encargosSeleccionados,
                        partesCoche: partesSeleccionadas
                    },
                    success: function(response) {
                        console.log(response)
                        if (response === 'success') {
                            alert('El trabajo no se ha podido guardar');
                            location.reload();
                        } else {
                            alert('Trabajo guardado exitosamente.');
                        }
                    },
                    error: function(e) {
                        alert('Error al conectar con el servidor.');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php
    // Obtener el operario de la sesión
    $operario = $_SESSION['dni'];

    // Realizar la conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

    // Obtener los encargos pendientes del operario y mostrarlos en la página
    $query = "SELECT * FROM encargo WHERE dni_operario = '$operario'";
    $result = mysqli_query($conexion, $query);

    $operario = $_SESSION['dni'];

    // Obtener el nombre del operario
    $queryNombre = "SELECT nombre FROM operarios WHERE dni = '$operario'";
    $resultNombre = mysqli_query($conexion, $queryNombre);
    $rowNombre = mysqli_fetch_assoc($resultNombre);
    $nombreOperario = $rowNombre['nombre'];

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Operario: $nombreOperario</h2>";
        echo "<h3>Encargos Pendientes:</h3>";

        echo "<form id='form-encargos' action='actualizar_encargo.php' method='POST'>";

        while ($row = mysqli_fetch_assoc($result)) {
            $idEncargo = $row['idencargo'];
            $idFactura = $row['id_factura'];
        
            // Obtener las partes del coche de la factura
            $queryFactura = "SELECT CochesID FROM factura WHERE id = $idFactura";
            $resultFactura = mysqli_query($conexion, $queryFactura);
            $rowFactura = mysqli_fetch_assoc($resultFactura);
            $cochesId = $rowFactura['CochesID'];
        
            // Obtener los datos de las partes del coche
            $queryPartes = "SELECT m.nombre AS Nombre, r.nombre AS nombre_ruedas, car.nombre AS nombre_carroceria, p.nombre AS nombre_pintura, t.nombre AS nombre_traccion, pu.nombre AS nombre_puertas, a.nombre AS nombre_accesorios
                            FROM coches c
                            LEFT JOIN motor m ON c.Motor_ID = m.id
                            LEFT JOIN ruedas r ON c.Ruedas_ID = r.id
                            LEFT JOIN carroceria car ON c.Carroceria_ID = car.id
                            LEFT JOIN pintura p ON c.Pintura_ID = p.id
                            LEFT JOIN traccion t ON c.Traccion_ID = t.id
                            LEFT JOIN puertas pu ON c.Puertas_ID = pu.id
                            LEFT JOIN accesorios a ON c.Accesorios_ID = a.id
                            WHERE c.id = $cochesId";
            $resultPartes = mysqli_query($conexion, $queryPartes);
            $rowPartes = mysqli_fetch_assoc($resultPartes);
            echo "<h4>Encargo $idEncargo:</h4>";
            generarCheckboxes($idEncargo, $rowPartes);
        }

        echo "<button type='button' id='guardar-progreso'>Guardar Progreso</button>";
        echo "</form>";
    } else {
        echo "<h2>No hay encargos pendientes para el operario: $operario</h2>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);

    function generarCheckboxes($idEncargo, $rowPartes) {
        echo "<ul>";
        echo "<li><input type='checkbox' name='encargo[]' value='$idEncargo'> Encargo $idEncargo</li>";
        echo "<li><input type='checkbox' name='partes_coche_$idEncargo" . "[]' value='Motor_ID'> {$rowPartes['Nombre']} </li>";
        echo "<li><input type='checkbox' name='partes_coche_$idEncargo" . "[]' value='Ruedas_ID'> {$rowPartes['nombre_ruedas']}</li>";
        echo "<li><input type='checkbox' name='partes_coche_$idEncargo" . "[]' value='Carroceria_ID'> {$rowPartes['nombre_carroceria']}</li>";
        echo "<li><input type='checkbox' name='partes_coche_$idEncargo" . "[]' value='Pintura_ID'> {$rowPartes['nombre_pintura']}</li>";
        echo "<li><input type='checkbox' name='partes_coche_$idEncargo" . "[]' value='Traccion_ID'> {$rowPartes['nombre_traccion']}</li>";
        echo "<li><input type='checkbox' name='partes_coche_$idEncargo" . "[]' value='Puertas_ID'> {$rowPartes['nombre_puertas']}</li>";
        echo "<li><input type='checkbox' name='partes_coche_$idEncargo" . "[]' value='Accesorios_ID'> {$rowPartes['nombre_accesorios']}</li>";
        echo "</ul>";
    }
    ?>

    <form action="cerrar_sesion.php" method="POST">
        <br><input type="submit" value="Cerrar sesión">
    </form>
</body>
</html>