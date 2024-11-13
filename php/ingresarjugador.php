<?php
include_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Consulta simple para obtener todos los registros de la tabla equipo
    $sql = "SELECT * FROM equipo";
    $result = $conn->query($sql);

    $totalJugadores = 0;
    $existeEntrenador = false;

    // Recorremos los resultados de la consulta para obtener el total de jugadores y verificar si ya existe un entrenador
    while ($row = $result->fetch_assoc()) {
        $totalJugadores++;

        // Verificamos si ya existe un entrenador (id_posicion = 5)
        if ($row['id_posicion'] == 5) {
            $existeEntrenador = true;
        }
    }

    // Tomamos los valores del formulario
    $nombreJugador = $_POST["nombre"];
    $posicion = $_POST["posicion"];
    $dorsal = $_POST["dorsal"];

    // Verificamos las condiciones para la inserción
    if ($totalJugadores >= 11) {
        echo "Error: Se ha alcanzado el límite de 11 jugadores.";
    } elseif ($posicion == 5 && $existeEntrenador) {
        echo "Error: Ya existe un entrenador";
    } else {
        // Si pasa las condiciones, insertamos al jugador
        $sqlInsert = "INSERT INTO equipo (nombre, id_posicion, dorsal) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("sii", $nombreJugador, $posicion, $dorsal);

        if ($stmt->execute()) {
            echo "Jugador " . $nombreJugador . " insertado";
        } else {
            echo "Error: No se pudo insertar al jugador.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
