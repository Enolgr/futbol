<?php
header("Content-Type: application/json");

include_once "conexion.php";

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "error" => "Conexión fallida: " . $conn->connect_error)));
}

// Consultar la tabla de equipo con sus posiciones
$sql = "SELECT e.nombre as nombre, dorsal, a.id_jugador as id ,e.id_posicion as posicion FROM alineacion a JOIN equipo e ON a.id_jugador=e.id";
$result = $conn->query($sql);

$alineacion = array();

if ($result && $result->num_rows > 0) {
    // Almacenar cada fila de resultados en un array
    while ($row = $result->fetch_assoc()) {
        
        if ($row["nombre"]) {

            // Dividir el nombre y apellido
            $nombreParts = explode(" ", $row["nombre"]);
            // Tomar solo el primer nombre
            $row["nombre"] = $nombreParts[0];
        }
        
        $alineacion[] = $row;
    }
}


// Cerrar la conexión
$conn->close();

// Devolver los resultados como JSON
echo json_encode(array("success" => true, "alineacion" => $alineacion));

