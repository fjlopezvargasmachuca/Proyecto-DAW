<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSNRHWN');</script>
<!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <title>Nombre de la empresa</title>
    <link rel="stylesheet" href="style.css">
<style>
.footer {
            position: fixed;
            bottom: 0;
            left: 175px;
            height: 15vh;
            width: calc(100vw - 175px);
            background-color: black;
            color: white;
            font-size: 0.8em;
            text-align: center;
        }

</style>


    <script>
        function enviarCorreo() {
            var nombre = document.getElementById("nombre").value;
            var email = document.getElementById("email").value;
            var mensaje = document.getElementById("mensaje").value;

            // Aquí puedes utilizar un servicio o librería para enviar el correo electrónico, como PHPMailer o enviar una solicitud HTTP a un servidor que procese el envío del correo.

            alert("¡Correo enviado con éxito!");
        }
    </script>

    </style>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSNRHWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="container">
        <div class="contact-data">
            <form action="mensajecont.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="mensaje">Comentarios</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
                <div>
                <button type="button" onclick="enviarCorreo()">Enviar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="footer"> 
        <p>elige-coche</p>
        <p>Teléfono: +1234567890</p>
        <p>Dirección: Calle Falsa 123 C.P.41010, Sevilla</p>
        <p>Correo electrónico: eligecoche@gmail.com</p>
    </div>
</body>
</html>
