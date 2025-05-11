<?php
$host       = getenv('DB_HOST')    ?: 'db';
$usuario    = getenv('DB_USER')    ?: 'ALPHA';
$contrasena = getenv('DB_PASS')    ?: '12369874';
$base_datos = getenv('DB_NAME')    ?: 'PruebaAlpha';

$mysqli = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($mysqli->connect_errno) {
    http_response_code(500);
    die("Conexión fallida ({$mysqli->connect_errno}): {$mysqli->connect_error}");
}
$mysqli->set_charset('utf8mb4');
?><!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Tablas en <?= htmlspecialchars($base_datos) ?></title>
<style>/* estilos básicos */</style>
</head><body>
  <h1>Tablas en «<?= htmlspecialchars($base_datos) ?>»</h1>
<?php
if ($tablas = $mysqli->query("SHOW TABLES")) {
    if (!$tablas->num_rows) {
        echo "<p>No hay tablas.</p>";
    }
    while ($fila = $tablas->fetch_array()) {
        $t = htmlspecialchars($fila[0]);
        echo "<h2>Tabla: $t</h2>";
        if ($datos = $mysqli->query("SELECT * FROM `{$fila[0]}` LIMIT 1000")) {
            if ($datos->num_rows) {
                echo "<table><tr>";
                foreach ($datos->fetch_fields() as $f) {
                    echo "<th>".htmlspecialchars($f->name)."</th>";
                }
                echo "</tr>";
                while ($r = $datos->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($r as $v) {
                        echo "<td>".htmlspecialchars((string)$v)."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tabla vacía.</p>";
            }
            $datos->free();
        } else {
            echo "<p>Error al leer «$t»: ".htmlspecialchars($mysqli->error)."</p>";
        }
    }
    $tablas->free();
} else {
    echo "<p>Error al listar tablas: ".htmlspecialchars($mysqli->error)."</p>";
}
$mysqli->close();
?>
</body></html>
