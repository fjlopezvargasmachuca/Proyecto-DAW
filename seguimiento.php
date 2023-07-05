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
  <title>Seguimiento de mantenimiento coches</title>
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
  <h2>Seguimiento de mantenimiento coches</h2>
  
  <?php

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['dni'])) {
    // El usuario no ha iniciado sesión, mostrar mensaje de error
    echo "Para poder acceder a la creación del coche, debes iniciar sesión.";
    exit; // Detener la ejecución del resto del código
}
  // Obtener el DNI del cliente logado
 
$dni_cliente = $_SESSION['dni'];

  // Realizar la consulta para obtener los registros de la tabla factaveria del cliente logado
  $query = "SELECT factaveria.*, taller.direccion
            FROM factaveria
            JOIN taller ON factaveria.CIF_taller = taller.CIF
            WHERE factaveria.dni_cliente = '$dni_cliente'";
  // Ejecutar la consulta en la base de datos
  $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');
  $result = mysqli_query($conexion, $query);

  // Verificar si se encontraron registros
  if (mysqli_num_rows($result) > 0) {
      // Mostrar la dirección del taller asociado para cada registro
      while ($row = mysqli_fetch_assoc($result)) {
          $direccion_taller = $row['direccion'];
          $modelo_ave = $row['modelo'];
          $marca_ave = $row['marca'];
          // Mostrar la dirección del taller
          echo "El coche $modelo_ave $marca_ave se encuentra en la siguiente dirección del taller: $direccion_taller<br>";
      }
  } else {
      // No se encontraron registros en la tabla factaveria para el cliente logado
      echo "No tienes registros en la tabla factaveria.";
  }
  ?>
</body>
</html>