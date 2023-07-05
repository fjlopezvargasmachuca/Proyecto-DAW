<?php
session_start(); // Iniciar la sesión
?>
<html>
    <head><!-- Google Tag Manager -->
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
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['dni'])) {
    // El usuario no ha iniciado sesión, mostrar mensaje de error
    echo "Para poder acceder a la creación del coche, debes iniciar sesión.";
    exit; // Detener la ejecución del resto del código
}

?>
<div class="car-configurator">
    <form method="POST" action="customization.php">
        <h2>Personaliza tu coche - Factura Pre-forma</h2>
        
        <h3>Carrocería:</h3>
        <select name="carroceria">
            <?php
            $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');
            $query = "SELECT id, nombre, precio FROM carroceria";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $precio = $row['precio'];

                echo "<option value='$id'>$nombre - $precio €</option>";
            }

            mysqli_free_result($result);
            ?>
        </select>

        <h3>Motor:</h3>
        <select name="motor">
            <?php
            $query = "SELECT id, nombre, precio FROM motor";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $precio = $row['precio'];

                echo "<option value='$id'>$nombre - $precio €</option>";
            }

            mysqli_free_result($result);
            ?>
        </select>

        <h3>Pintura:</h3>
        <select name="pintura">
            <?php
            $query = "SELECT id, nombre, precio FROM pintura";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $precio = $row['precio'];

                echo "<option value='$id'>$nombre - $precio €</option>";
            }

            mysqli_free_result($result);
            ?>
        </select>

        <h3>Puertas:</h3>
        <select name="puertas">
            <?php
            $query = "SELECT id, nombre, precio FROM puertas";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $precio = $row['precio'];

                echo "<option value='$id'>$nombre - $precio €</option>";
            }

            mysqli_free_result($result);
            ?>
        </select>

        <h3>Ruedas:</h3>
        <select name="ruedas">
            <?php
            $query = "SELECT id, nombre, precio FROM ruedas";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $precio = $row['precio'];

                echo "<option value='$id'>$nombre - $precio €</option>";
            }

            mysqli_free_result($result);
            ?>
        </select>

        <h3>Tracción:</h3>
        <select name="traccion">
            <?php
            $query = "SELECT id, nombre, precio FROM traccion";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $precio = $row['precio'];

                echo "<option value='$id'>$nombre - $precio €</option>";
            }

            mysqli_free_result($result);
            ?>
        </select>

        <h3>Accesorios:</h3>
        <?php
        $query = "SELECT id, nombre, precio FROM accesorios";
        $result = mysqli_query($conexion, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $precio = $row['precio'];

            echo "<label>";
            echo "<input type='checkbox' name='accesorios[]' value='$id'> $nombre - $precio €";
            echo "</label><br>";
        }

        mysqli_free_result($result);
        mysqli_close($conexion);
        ?>

        <input type="submit" name="customize-button" value="¡Quiero crearlo!">
    </form>

    <?php
    if (isset($_POST['customize-button'])) {
        // Obtener los valores del formulario
        $carroceria = $_POST['carroceria'];
        $motor = $_POST['motor'];
        $pintura = $_POST['pintura'];
        $puertas = $_POST['puertas'];
        $ruedas = $_POST['ruedas'];
        $traccion = $_POST['traccion'];
        $accesorios = isset($_POST['accesorios']) ? $_POST['accesorios'] : [];

        // Realizar la conexión a la base de datos
        $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

        // Insertar el coche en la tabla coches
        $query = "INSERT INTO coches (id, Motor_ID, Ruedas_ID, Carroceria_ID, Pintura_ID, Traccion_ID, Puertas_ID, Accesorios_ID)
                  VALUES (NULL, '$motor', '$ruedas', '$carroceria', '$pintura', '$traccion', '$puertas', NULL)";
        mysqli_query($conexion, $query);

        // Obtener el ID del coche insertado
        $cocheID = mysqli_insert_id($conexion);

        // Insertar la factura en la tabla factura
        $dni_cliente = $_SESSION['dni'];
        $query = "INSERT INTO factura (ClientesID, CochesID)
                  VALUES ('$dni_cliente', '$cocheID')";
        mysqli_query($conexion, $query);

        // Obtener el ID de la factura insertada
        $facturaID = mysqli_insert_id($conexion);

        // Obtener el operario con menos coches asignados en la tabla encargo
        $query = "SELECT dni_operario, COUNT(*) AS num_coches
                  FROM encargo
                  GROUP BY dni_operario
                  ORDER BY num_coches ASC
                  LIMIT 1";
        $result = mysqli_query($conexion, $query);
        $row = mysqli_fetch_assoc($result);
        $dni_operario = $row['dni_operario'];

        // Insertar el encargo en la tabla encargo
        $query = "INSERT INTO encargo (id_factura, dni_operario)
                  VALUES ('$facturaID', '$dni_operario')";
        mysqli_query($conexion, $query);

        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    }
    ?>

<p><a href="index.php" class="btn-volver">Volver</a></p>
</div>
</body>
</html>
