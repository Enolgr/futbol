<?php

include_once "conexion.php";
header("Content-Type: application/json");

// Verifica que se reciban los datos necesarios desde el formulario
if (isset($_POST["tactica"]) && isset($_POST["jugadores"])) {

    $tactica = $_POST["tactica"]; // Este es el valor recibido desde el formulario como un array
    $tactica = explode("-",$tactica);


    // Convierte el array de jugadores a un string para la consulta SQL
    $jugadores = $_POST["jugadores"];
    $arrayJugadores = implode(",", $jugadores);

    // Prepara la consulta SQL para obtener las posiciones de los jugadores desde la tabla jugadores
    $sql = "SELECT id_jugador, id_posicion FROM jugadores WHERE id_jugador IN ($arrayJugadores);";
    $result = $conn->query($sql);

    $defensa = 0;
    $medioCampo = 0;
    $delantero = 0;

    // Procesa los resultados de la consulta para contar los jugadores por posición
    while ($row = $result->fetch_assoc()) {
        if ($row['id_posicion'] == 2) {
            $defensa++;
        } elseif ($row['id_posicion'] == 3) {
            $medioCampo++;
        } elseif ($row['id_posicion'] == 4) {
            $delantero++;
        }
    }

    // Verifica si la alineación cumple con la táctica especificada
    if ($defensa == $tactica[0] && $medioCampo == $tactica[1] && $delantero == $tactica[2]) {

        // Elimina todas las alineaciones
        $sqlDelete = "DELETE FROM alineacion;";
        if ($conn->query($sqlDelete) === false) {
            $response = array("success" => false, "error" => "Error al eliminar todas las alineaciones");
            echo json_encode($response);
            exit();
        }

        // Inserta la nueva alineación
        $sqlInsert = "INSERT INTO alineacion (id_jugador) VALUES (?)";
        $stmt = $conn->prepare($sqlInsert);

        // Inserta los jugadores uno por uno
        foreach ($jugadores as $jugador) {
            $stmt->bind_param("i", $jugador);
        }

        $response = array("success" => true);

    } else {
        $response = array("success" => false, "error" => "Las posiciones no coinciden con la táctica");
    }

    $stmt->close();
} else {
    $response = array("success" => false, "error" => "Faltan datos necesarios");
}

$conn->close();

echo json_encode($response);

?>
