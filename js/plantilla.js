$(document).ready(function () {

    function cargarJugadores () {
        $.ajax({
            type: "GET",
            url: "./php/mostrarplantilla.php",
            dataType: "json",
            success: function (response) {
                
                $(".zonajuego").empty(); // Limpiar zona de juego

                response.alineacion.forEach(function (e) { // Usar .forEach correctamente

                    const jugadorHtml = `
                    <div class="jugador" id="${e.posicion}">
                    <h2 class="dorsal">${e.dorsal}</h2>
                    <p class="jugador-nombre">${e.nombre}</p>
                    </div>`;

                    // Añadir jugador en la sección correspondiente
                    if (e.posicion == "2") {
                        $("#defensa").append(jugadorHtml);
                    } else if (e.posicion == "3") { // Usar e.posicion en vez de campo.posicion
                        $("#centrocampistas").append(jugadorHtml);
                    } else if (e.posicion == "4") {
                        $("#delanteros").append(jugadorHtml);
                    }
                });

            }
        });
    }

    cargarJugadores(); // Llamar a la función para cargar los jugadores

});
