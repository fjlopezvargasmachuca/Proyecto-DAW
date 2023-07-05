<?php
// Realizar la conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'eligecoche');

// Consulta para obtener el ranking de cada parte en la tabla "coches"
$query_motor = "SELECT m.Nombre AS parte, m.Precio, COUNT(c.ID) AS contador
                FROM coches c
                INNER JOIN motor m ON c.Motor_ID = m.id
                GROUP BY parte, Precio
                ORDER BY contador DESC
                LIMIT 5";

$query_ruedas = "SELECT r.Nombre AS parte, r.Precio, COUNT(c.ID) AS contador
                FROM coches c
                INNER JOIN ruedas r ON c.Ruedas_ID = r.id
                GROUP BY parte, Precio
                ORDER BY contador DESC
                LIMIT 5";

$query_carroceria = "SELECT ca.Nombre AS parte, ca.Precio, COUNT(c.ID) AS contador
                FROM coches c
                INNER JOIN carroceria ca ON c.Carroceria_ID = ca.id
                GROUP BY parte, Precio
                ORDER BY contador DESC
                LIMIT 5";

$query_pintura = "SELECT pi.Nombre AS parte, pi.Precio, COUNT(c.ID) AS contador
                FROM coches c
                INNER JOIN pintura pi ON c.Pintura_ID = pi.id
                GROUP BY parte, Precio
                ORDER BY contador DESC
                LIMIT 5";

$query_puertas = "SELECT pu.Nombre AS parte, pu.Precio, COUNT(c.ID) AS contador
                FROM coches c
                INNER JOIN puertas pu ON c.Puertas_ID = pu.id
                GROUP BY parte, Precio
                ORDER BY contador DESC
                LIMIT 5";

$query_accesorios = "SELECT a.Nombre AS parte, a.Precio, COUNT(c.ID) AS contador
                FROM coches c
                INNER JOIN accesorios a ON c.Accesorios_ID = a.id
                GROUP BY parte, Precio
                ORDER BY contador DESC
                LIMIT 5";

// Ejecutar las consultas y obtener los resultados para cada parte
$result_motor = mysqli_query($conexion, $query_motor);
$result_ruedas = mysqli_query($conexion, $query_ruedas);
$result_carroceria = mysqli_query($conexion, $query_carroceria);
$result_pintura = mysqli_query($conexion, $query_pintura);
$result_puertas = mysqli_query($conexion, $query_puertas);
$result_accesorios = mysqli_query($conexion, $query_accesorios);

// Verificar si se encontraron resultados para cada parte
if (mysqli_num_rows($result_motor) > 0 || mysqli_num_rows($result_ruedas) > 0 || mysqli_num_rows($result_carroceria) > 0 || mysqli_num_rows($result_pintura) > 0 || mysqli_num_rows($result_puertas) > 0 || mysqli_num_rows($result_accesorios) > 0) {
    echo "<h2>Ranking Top 5 de Partes</h2>";

    function mostrarRanking($parte, $result)
    {
        if (mysqli_num_rows($result) > 0) {
            echo "<h3>$parte</h3>";
            echo "<table>";
            echo "<tr><th>Parte</th><th>Precio</th><th>Clientes que lo han solicitado</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                $nombreParte = $row['parte'];
                $precioParte = $row['Precio'];
                $contador = $row['contador'];

                echo "<tr><td>$nombreParte</td><td>$precioParte</td><td align='center'>$contador</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados para $parte.</p>";
        }
    }

    mostrarRanking("Motor", $result_motor);
    mostrarRanking("Ruedas", $result_ruedas);
    mostrarRanking("Carrocería", $result_carroceria);
    mostrarRanking("Pintura", $result_pintura);
    mostrarRanking("Puertas", $result_puertas);
    mostrarRanking("Accesorios", $result_accesorios);
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>