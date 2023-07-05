<?php
    session_start(); // Iniciar la sesión
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
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        /* Estilos para la factura */
        .factura {
            font-family: Arial, sans-serif;
            width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
        }
        
        .factura h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        
        .factura table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        
        .factura th, .factura td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        
        .factura tfoot {
            font-weight: bold;
        }
        
        .sello {
            text-align: center;
            margin-top: 20px;
        }
        
        .sello img {
            max-width: 200px;
        }
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
<div class="sello">
            <img src="EligeCoche.jpg" alt="Sello de EligeCoche">
        </div>
    <div class="factura">
    <?php
    if (isset($_POST['customize-button'])) {
        // Recoger los valores seleccionados del formulario
        $carroceria = $_POST['carroceria'];
        $motor = $_POST['motor'];
        $pintura = $_POST['pintura'];
        $puertas = $_POST['puertas'];
        $ruedas = $_POST['ruedas'];
        $traccion = $_POST['traccion'];
        $accesorios = isset($_POST['accesorios']) ? $_POST['accesorios'] : array();

        
        echo "<h2>Factura</h2>";
        // Verificar si se han seleccionado accesorios
        if (!empty($accesorios)) {
           
        } else {
            // Mostrar el mensaje de "No se han seleccionado accesorios" dentro de la factura
            echo "<h3>Accesorios:</h3>";
            echo "<p>No se han seleccionado accesorios.</p>";
        }
    // Realizar consulta a la base de datos para obtener los precios y nombres de las opciones seleccionadas
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

    // Consulta para obtener los precios y nombres de las opciones seleccionadas
    $query = "SELECT nombre, precio FROM carroceria WHERE id = '$carroceria'";
    $result = mysqli_query($conexion, $query);
    $carroceriaData = mysqli_fetch_assoc($result);

    $query = "SELECT nombre, precio FROM motor WHERE id = '$motor'";
    $result = mysqli_query($conexion, $query);
    $motorData = mysqli_fetch_assoc($result);

    $query = "SELECT nombre, precio FROM pintura WHERE id = '$pintura'";
    $result = mysqli_query($conexion, $query);
    $pinturaData = mysqli_fetch_assoc($result);

    $query = "SELECT nombre, precio FROM puertas WHERE id = '$puertas'";
    $result = mysqli_query($conexion, $query);
    $puertasData = mysqli_fetch_assoc($result);

    $query = "SELECT nombre, precio FROM ruedas WHERE id = '$ruedas'";
    $result = mysqli_query($conexion, $query);
    $ruedasData = mysqli_fetch_assoc($result);

    $query = "SELECT nombre, precio FROM traccion WHERE id = '$traccion'";
    $result = mysqli_query($conexion, $query);
    $traccionData = mysqli_fetch_assoc($result);

    $accesoriosData = array(); // Array para almacenar los datos de los accesorios seleccionados

    foreach ($accesorios as $accesorio) {
        $query = "SELECT nombre, precio FROM accesorios WHERE id = '$accesorio'";
        $result = mysqli_query($conexion, $query);
        $accesorioData = mysqli_fetch_assoc($result);
        $accesoriosData[] = $accesorioData;
    }

    // Calcular el coste total sumando los precios de las opciones seleccionadas
    $costeTotal = $carroceriaData['precio'] + $motorData['precio'] + $pinturaData['precio'] + $puertasData['precio'] + $ruedasData['precio'] + $traccionData['precio'];

    foreach ($accesoriosData as $accesorioData) {
        $costeTotal += $accesorioData['precio'];
    }

    // Mostrar la factura desglosada en pantalla
    echo "<h3>Carrocería:</h3>";
    echo "<p>Nombre: " . $carroceriaData['nombre'] . "</p>";
    echo "<p>Precio: " . $carroceriaData['precio'] . " €</p>";

    echo "<h3>Motor:</h3>";
    echo "<p>Nombre: " . $motorData['nombre'] . "</p>";
    echo "<p>Precio: " . $motorData['precio'] . " €</p>";

    echo "<h3>Pintura:</h3>";
    echo "<p>Nombre: " . $pinturaData['nombre'] . "</p>";
    echo "<p>Precio: " . $pinturaData['precio'] . " €</p>";

    echo "<h3>Puertas:</h3>";
    echo "<p>Nombre: " . $puertasData['nombre'] . "</p>";
    echo "<p>Precio: " . $puertasData['precio'] . " €</p>";

    echo "<h3>Ruedas:</h3>";
    echo "<p>Nombre: " . $ruedasData['nombre'] . "</p>";
    echo "<p>Precio: " . $ruedasData['precio'] . " €</p>";

    echo "<h3>Tracción:</h3>";
    echo "<p>Nombre: " . $traccionData['nombre'] . "</p>";
    echo "<p>Precio: " . $traccionData['precio'] . " €</p>";

    echo "<h3>Accesorios:</h3>";
    foreach ($accesoriosData as $accesorioData) {
        echo "<p>Nombre: " . $accesorioData['nombre'] . "</p>";
        echo "<p>Precio: " . $accesorioData['precio'] . " €</p>";
    }

    echo "<h3>Coste Total:</h3>";
    echo "<p>" . $costeTotal . " €</p>";
/////////////////////////////////////////////////////////////
// Validar si ya existe un registro en la tabla "coche" con los mismos campos
$query = "SELECT * FROM coches WHERE Carroceria_ID = '$carroceria' AND Motor_ID = '$motor' AND Pintura_ID = '$pintura' AND Puertas_ID = '$puertas' AND Ruedas_ID = '$ruedas' AND Traccion_ID = '$traccion'";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    // Ya existe un registro con los mismos campos, obtener el ID del coche existente
    $row = mysqli_fetch_assoc($result);
    $cocheId = $row['id'];
} else {
    // No existe un registro con los mismos campos, insertar uno nuevo en la tabla "coche"
    $query = "SELECT * FROM coches WHERE Carroceria_ID = '$carroceria' AND Motor_ID = '$motor' AND Pintura_ID = '$pintura' AND Puertas_ID = '$puertas' AND Ruedas_ID = '$ruedas' AND Traccion_ID = '$traccion'";
    mysqli_query($conexion, $query);

    // Obtener el ID del coche recién insertado
    $cocheId = mysqli_insert_id($conexion);
} 


// Insertar registro en la tabla "factura"
 $dniCliente = $_SESSION['dni'];
 $query = "INSERT INTO factura (ClientesID, CochesID) VALUES ('$dniCliente', '$cocheId')";
 mysqli_query($conexion, $query);
// Función para obtener el operario con menos coches asignados
function obtenerOperarioMenosCoches()
{
    // Realizar la conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

    // Obtener el operario con menos coches asignados
    $query = "SELECT dni_operario, COUNT(*) AS idencargo FROM encargo GROUP BY dni_operario ORDER BY idencargo ASC LIMIT 1";
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($result);
    $dniOperario = $row['dni_operario'];

    // Cerrar la conexión
    mysqli_free_result($result);
    mysqli_close($conexion);

    return $dniOperario;
}
/////////////////////////////////////////////////////////
    mysqli_close($conexion);
}
?>
El pago debe realizarse en la cuenta para que pueda formalizarse con asunto el número DNI: ES12 1234 5678 1234 5678 90
        <p></p><button onclick="window.print()">Imprimir</button>
    </div>
    <a href="index.php" class="btn-volver">Volver</a>
</body>
</html>