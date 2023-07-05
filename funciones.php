<?php
// Función para buscar un usuario en la base de datos por nombre de usuario o correo electrónico
function buscarUsuario($nombreUsuarioCorreo) {
    // Realiza la consulta en la base de datos para verificar si existe el usuario
    // Supongamos que ya tienes una conexión establecida a la base de datos
    $sql = "SELECT * FROM clientes WHERE nombre_usuario = '$nombreUsuarioCorreo' OR correo = '$nombreUsuarioCorreo'";
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');
    $resultado = mysqli_query($conexion, $sql);

    // Comprueba si se encontró algún resultado
    if (mysqli_num_rows($resultado) > 0) {
        // El usuario existe
        return true;
    } else {
        // El usuario no existe
        return false;
    }
}

// Función para generar una contraseña aleatoria
function generarContrasenaAleatoria() {
    // Define los caracteres permitidos para la contraseña
    $caracteresPermitidos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    
    // Genera una cadena aleatoria de longitud 8
    $longitud = 8;
    $nuevaContrasena = '';
    for ($i = 0; $i < $longitud; $i++) {
        $indiceAleatorio = rand(0, strlen($caracteresPermitidos) - 1);
        $nuevaContrasena .= $caracteresPermitidos[$indiceAleatorio];
    }
    
    return $nuevaContrasena;
}

// Función para actualizar la contraseña de un usuario en la base de datos
function actualizarContrasena($nombreUsuarioCorreo, $nuevaContrasena) {
    // Realiza la actualización en la base de datos
    // Supongamos que ya tienes una conexión establecida a la base de datos
    $sql = "UPDATE clientes SET contrasena = '$nuevaContrasena' WHERE nombre_usuario = '$nombreUsuarioCorreo' OR correo = '$nombreUsuarioCorreo'";
    $conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');
    mysqli_query($conexion, $sql);
}

// Función para enviar un correo electrónico al usuario con la nueva contraseña
function enviarCorreoElectronico($nombreUsuarioCorreo, $nuevaContrasena) {
    // Configura los datos del servidor de correo
    $smtpHost = 'smtp.gmail.com';
    $smtpPort = 587;
    $smtpUsuario = 'eligecoche1987@gmail.com';
    $smtpContrasena = 'Eligecoche1987!';
    
    // Configura el destinatario y el contenido del correo
    $destinatario = $nombreUsuarioCorreo;
    $asunto = 'Recuperación de contraseña';
    $mensaje = 'Hola, tu nueva contraseña es: ' . $nuevaContrasena;
    
    // Configura el encabezado del correo
    $cabeceras = "From: $smtpUsuario\r\n";
    $cabeceras .= "Reply-To: $smtpUsuario\r\n";
    $cabeceras .= "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=utf-8\r\n";
    
    // Envía el correo electrónico
    mail($destinatario, $asunto, $mensaje, $cabeceras);
}
?>