<html><head><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->
<style>.btn-volver {
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
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eligecoche";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Mostrar la información en una tabla
$tablas = array("Motor", "Ruedas", "Carroceria", "Pintura", "Traccion", "Puertas", "Accesorios");
foreach ($tablas as $tabla) {
    $sql = "SELECT * FROM $tabla";
    $result = $conn->query($sql);

    // Mostrar la información en una tabla
    if ($result->num_rows > 0) {
        echo "<h2>Información de $tabla:</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["id"]."</td><td>".$row["Nombre"]."</td><td>".$row["Precio"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron registros de $tabla.";
    }
}

$conn->close();


?>
<p></p>
<div style="text-align: center;">
<a href="index.php" class="btn-volver">Volver</a>
</div>
</body>
</html>