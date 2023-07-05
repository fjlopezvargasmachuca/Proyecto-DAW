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
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php
if (!isset($_SESSION['dni'])) {
    // No se ha iniciado sesión de operario, devolver una respuesta de error
    echo "Error: No se ha iniciado sesión de operario.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // La petición no es de tipo POST, devolver una respuesta de error
    echo "Error: La petición debe ser de tipo POST.";
    exit;
}

$operario = $_SESSION['dni'];
$encargoId = $_POST['encargoId'];
$parteCoche = $_POST['parteCoche'];

// Realizar la conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

// Verificar si todas las partes están seleccionadas
$todasSeleccionadas = true;
foreach ($parteCoche as $parte) {
    if ($parte == 0) {
        $todasSeleccionadas = false;
        break;
    }
}

if (!$todasSeleccionadas) {
    // Actualizar el estado del encargo en la tabla "encargo"
    $query = "UPDATE encargo SET $parteCoche = TRUE WHERE idencargo = $encargoId";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        // La actualización se realizó correctamente

        // Verificar si todos los campos del encargo están completos
        $queryVerificarCompletado = "SELECT * FROM encargo WHERE idencargo = $encargoId AND campo1 = 1 AND campo2 = 1 AND campo3 = 1";
        $resultVerificarCompletado = mysqli_query($conexion, $queryVerificarCompletado);

        if (mysqli_num_rows($resultVerificarCompletado) > 0) {
            // Todos los campos del encargo están completos, mover el encargo a la tabla "encargos_completados"

            // Obtener el encargo completo
            $queryEncargoCompleto = "SELECT * FROM encargo WHERE idencargo = $encargoId";
            $resultEncargoCompleto = mysqli_query($conexion, $queryEncargoCompleto);
            $encargoCompleto = mysqli_fetch_assoc($resultEncargoCompleto);

            // Insertar el encargo completo en la tabla "encargos_completados"
            $queryInsertarCompletado = "INSERT INTO encargos_completados (idencargo, id_factura, dni_operario) VALUES ($encargoCompleto[idencargo], $encargoCompleto[id_factura], '$encargoCompleto[dni_operario]')";
            mysqli_query($conexion, $queryInsertarCompletado);

            // Eliminar el encargo de la tabla "encargo"
            $queryEliminarEncargo = "DELETE FROM encargo WHERE idencargo = $encargoId";
            mysqli_query($conexion, $queryEliminarEncargo);
        }

        echo "success";
    } else {
        echo "Error al actualizar el encargo.";
    }
} else {
    echo "Error: Todas las partes ya están seleccionadas.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
</body>
</html>