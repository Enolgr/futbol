<?php
header("Content-Type: application/json");

include_once "conexion.php";

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "error" => "Conexión fallida: " . $conn->connect_error)));
}

// Consultar la tabla de equipo con sus posiciones
$sql = "SELECT e.nombre AS nombre, e.id AS id_jugador, p.id AS posicion FROM equipo e JOIN posicion p ON e.id_posicion = p.id";
$result = $conn->query($sql);

$equipo = array();

if ($result && $result->num_rows > 0) {
    // Almacenar cada fila de resultados en un array
    while ($row = $result->fetch_assoc()) {
        $equipo[] = $row;
    }
}

// Consultar la tabla de tácticas
$TacticaSql = "SELECT * FROM tactica";
$TacticaResult = $conn->query($TacticaSql);

$tacticas = array();

if ($TacticaResult && $TacticaResult->num_rows > 0) {
    // Almacenar cada fila de resultados en un array
    while ($row = $TacticaResult->fetch_assoc()) {
        $tacticas[] = $row;
        if (isset($row['formacion'])) {  // Asegúrate de que 'formacion' sea el nombre de la columna que contiene la táctica en formato "4-2-2"
            $arrayLimpio[] = explode("-", $row['formacion']);
        }
    }
}

// Cerrar la conexión
$conn->close();

// Devolver los resultados como JSON
echo json_encode(array("success" => true, "equipo" => $equipo, "tacticas" => $tacticas));
?>
