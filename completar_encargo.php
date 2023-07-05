<?php
session_start();

// Realizar las operaciones necesarias para marcar el encargo como completado
// ...

// Obtener la dirección del cliente asociada al encargo
$clienteId = // Obtener el ID del cliente asociado al encargo
$direccionCliente = // Obtener la dirección del cliente desde la base de datos utilizando el ID del cliente

// Almacenar la dirección del cliente en una variable de sesión
$_SESSION['direccion_cliente'] = $direccionCliente;

// Marcar el encargo como completado en la base de datos
$encargoId = // Obtener el ID del encargo
// Realizar la consulta y actualizar el estado del encargo a completado

// Redirigir a la página de inicio o a donde corresponda
header("Location: index.php");
exit;
?>