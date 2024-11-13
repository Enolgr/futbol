<?php

include_once "conexion.php";
header("Content-Type: application/json");


// Verifica que se reciban los datos necesarios desde el formulario
if (isset($_POST["jugadores"]) && is_array($_POST["jugadores"])) {

    // Convierte el array de jugadores a un string para la consulta SQL
    $jugadores = $_POST["jugadores"];

    // Elimina todas las alineaciones
    $sqlDelete = "DELETE FROM alineacion";
    if ($conn->query($sqlDelete) === false) {
        $response["error"] = "Error al eliminar todas las alineaciones";
        echo json_encode($response);
        exit();
    }

    // Inserta la nueva alineación
    $sqlInsert = "INSERT INTO alineacion (id_jugador) VALUES (?)";
    $stmt = $conn->prepare($sqlInsert);

    if ($stmt === false) {
        $response["error"] = "Error al preparar la consulta.";
        echo json_encode($response);
        exit();
    }

    // Inserta los jugadores uno por uno
    foreach ($jugadores as $jugador) {
        $stmt->bind_param("i", $jugador);
        if (!$stmt->execute()) {
            $response["error"] = "Error al insertar el jugador con ID $jugador.";
            echo json_encode($response);
            exit();
        }
    }

    // Si todo va bien, establece `success` en verdadero
    $response["success"] = true;

$stmt->close();

} else {
    $response["error"] = "No se recibieron jugadores o el formato es incorrecto.";
}

$conn->close();

echo json_encode($response);
?> 