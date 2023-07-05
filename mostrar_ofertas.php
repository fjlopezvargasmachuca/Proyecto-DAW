<?php
session_start();
?>
<html><head>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->
</head>
<?php
// Realizar la conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

// Obtener los datos de las ventas
$query = "SELECT v.*, c.Telefono FROM ventas v 
          INNER JOIN clientes c ON v.Cliente = c.DNI";
$result = mysqli_query($conexion, $query);

// Verificar si hay ventas para mostrar
if (mysqli_num_rows($result) > 0) {
    echo "<h1>Ofertas de Venta</h1>";
    echo "<table>";
    echo "<tr><th>Marca</th><th>Modelo</th><th>Nº de KM</th><th>Precio</th><th>Descripción</th><th>Teléfono</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['Marca']}</td>";
        echo "<td>{$row['Modelo']}</td>";
        echo "<td>{$row['Kilometros']}</td>";
        echo "<td>{$row['Precio']}</td>";
        echo "<td>{$row['Descripcion']}</td>";

        // Verificar si el usuario está logueado para mostrar el número de teléfono completo
        if (isset($_SESSION['dni'])) {
            echo "<td>{$row['Telefono']}</td>";
        } else {
            // Si el usuario no está logueado, mostrar el número de teléfono oculto con asteriscos
            $telefono = $row['Telefono'];
            $telefonoOculto = substr($telefono, 0, -5) . "*****";
            echo "<td>{$telefonoOculto}</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<h2>No hay ofertas de venta disponibles.</h2>";
}
echo "<br><br>Recordamos a los usuarias/os que deben estar logados para poder contactar con los clientes";
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

</html>