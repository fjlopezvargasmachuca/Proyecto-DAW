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
  <title>Mantenimiento de coches</title>
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
  

  // Procesar el formulario de mantenimiento
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $matricula = $_POST['matricula'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $dni_cliente = $_SESSION['dni_cliente'];

    // Obtener el mover con menos apariciones en factaveria
    $query_mover = "SELECT dni_mover, COUNT(*) as contador FROM factaveria GROUP BY dni_mover ORDER BY contador ASC LIMIT 1";
    // Ejecutar la consulta SQL para obtener el mover
    $result_mover = mysqli_query($conexion, $query_mover);

    // Verificar si se encontraron resultados
    if ($result_mover && mysqli_num_rows($result_mover) > 0) {
        $row_mover = mysqli_fetch_assoc($result_mover);
        $dni_mover = $row_mover['dni_mover'];
    } else {
        // Si no se encontraron resultados, asignar un valor predeterminado
        $dni_mover = "77777777V";
    }

    // Obtener el primer registro de la tabla taller
    $query_taller = "SELECT CIF FROM taller LIMIT 1";
    // Ejecutar la consulta SQL para obtener el primer registro de la tabla taller
    $result_taller = mysqli_query($conexion, $query_taller);

    // Verificar si se encontraron resultados
    if ($result_taller && mysqli_num_rows($result_taller) > 0) {
        $row_taller = mysqli_fetch_assoc($result_taller);
        $cif_taller = $row_taller['CIF'];
    } else {
        // Si no se encontraron resultados, asignar un valor predeterminado
        $cif_taller = "CIF predeterminado";
    }

    // Insertar el registro en la tabla "factaveria"
    $query = "INSERT INTO factaveria (direccion, modelo, marca, matricula, detalles, dni_cliente, CIF_taller, dni_mover)
              VALUES ('$direccion', '$modelo', '$marca', '$matricula', '$descripcion', '$dni_cliente', '$cif_taller', '$dni_mover')";
    // Ejecutar la consulta SQL para insertar el registro en factaveria
    $result = mysqli_query($conexion, $query);

    if ($result) {
        // Redireccionar al usuario a la página principal
        header("Location: index.php");
        exit();
    } else {
        // Mostrar un mensaje de error si no se pudo insertar el registro
        echo "Error al insertar el registro en la base de datos";
    }
  }
  ?>
  
  <h2>Mantenimiento de coches</h2>
  <form method="POST" action="">
    <label for="marca">Marca:</label>
    <input type="text" id="marca" name="marca" required><br>

    <label for="modelo">Modelo:</label>
    <input type="text" id="modelo" name="modelo" required><br>

    <label for="matricula">Matrícula:</label>
    <input type="text" id="matricula" name="matricula" required><br>

    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="direccion" required><br>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" required></textarea><br>

    <input type="submit" value="Enviar">
  </form>
</body>
</html>