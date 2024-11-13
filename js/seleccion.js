$(document).ready(function () {
    // Cargar tácticas y jugadores en el cuerpo de la página
    function cargarBody() {
        $.ajax({
            type: "GET",
            url: "./php/mostrar.php",
            dataType: "json",
            success: function (futbol) {
                if (futbol.success) {
                    // Cargar tácticas
                    $("#tacticas").empty();
                    futbol.tacticas.forEach(function (tactica) {
                        const selectTacticas = `<option value="${tactica.id_tactica}">${tactica.formacion}</option>`;
                        $("#tacticas").append(selectTacticas);
                    });

                    // Cargar jugadores por posición
                    $("#jugadores-defensas").empty();
                    $("#jugadores-centrocampistas").empty();
                    $("#jugadores-delanteros").empty();

                    futbol.equipo.forEach(function (campo) {
                        const jugadorHtml = `
                            <label>
                                <input class="jugador" type="checkbox" value="${campo.id_jugador}">
                                ${campo.nombre}
                            </label><br>`;

                        // Añadir jugador en la sección correspondiente
                        if (campo.posicion == "2") {
                            $("#jugadores-defensas").append(jugadorHtml);
                        } else if (campo.posicion == "3") {
                            $("#jugadores-centrocampistas").append(jugadorHtml);
                        } else if (campo.posicion == "4") {
                            $("#jugadores-delanteros").append(jugadorHtml);
                        }
                    });

                    // Llamar a `mostrarFormacion` para cargar la táctica inicial
                    mostrarFormacion();
                } else {
                    alert("Error: " + futbol.error);
                }
            },
            error: function () {
                alert("Error al cargar los datos de futbol.");
            },
        });
    }

    // Actualizar la formación al seleccionar una táctica
    function mostrarFormacion() {
        const tacticaSeleccionada = $("#tacticas").val();

        $.ajax({
            type: "GET",
            url: "./php/mostrar.php",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    // Limpiar contenedores de contadores de jugadores por posición
                    $("#total-defensas").empty();
                    $("#total-centro").empty();
                    $("#total-delanteros").empty();

                    // Usar la táctica seleccionada para mostrar la formación
                    const formacion = response.tacticas.find(
                        (t) => t.id_tactica == tacticaSeleccionada
                    );

                    if (formacion) {
                        const [defensas, centro, delanteros] = formacion.formacion
                            .split("-")
                            .map(Number);
                        $("#total-defensas").text(defensas);
                        $("#total-centro").text(centro);
                        $("#total-delanteros").text(delanteros);

                        // Restablecer el marcador de seleccionados
                        $(".marcados").text(0);
                    }
                } else {
                    console.error("No se pudo obtener la formación.");
                }
            },
            error: function (error) {
                console.error("Error en la solicitud AJAX:", error);
            },
        });
    }

    // Cargar la página inicialmente con los datos
    cargarBody();

    // Cambiar táctica y recargar formación al seleccionar una nueva táctica
    $("#tacticas").change(function (e) {
        e.preventDefault();
        mostrarFormacion();
        $(".marcados").text(0);

        // Desmarca todos los checkboxes y fuerza el cambio visual, si no, no rula.
        $("input.jugador").prop("checked", false).trigger("change");
    });

    // Actualizar el contador de jugadores seleccionados
    $(".jugadores").on("change", ".jugador", function () {
        const container = $(this).closest(".tipo-futbol"); // Encuentra la sección (defensas, centrocampistas, delanteros)

        // Encuentra el elemento con la clase .marcados dentro de esta sección
        const contador = container.find(".marcados");

        // Cuenta los checkboxes seleccionados en esta sección
        const seleccionados = container.find(".jugador:checked").length;

        // Encuentra el valor máximo permitido en el contador y conviértelo en un número
        const maxPermitido = parseInt(container.find(".contador").text());

        // Si el número de seleccionados supera el máximo permitido, muestra un mensaje de error
        if (seleccionados > maxPermitido) {
            alert(
                "Error: Has seleccionado más jugadores de los permitidos en esta sección."
            );
            // Anula la selección del checkbox actual
            $(this).prop("checked", false);
            return; // Detiene la ejecución
        }

        // Actualiza el contador correspondiente
        contador.text(seleccionados);
    });

    // Almacenado de jugadores seleccionados al hacer clic en el botón "Jugar"

    $("#jugar").click(function (e) {
        e.preventDefault();

        let seleccionados = [];

    
        $(".jugador:checked").each(function () {
            seleccionados.push($(this).val()); 
        });

        // Verifica si se seleccionaron jugadores
        if (seleccionados.length === 0) {
            alert("Por favor, selecciona al menos un jugador.");
            return; 
        }

       
        $.ajax({
            type: "POST", 
            url: "./php/insertarplantilla.php", 
            data: { jugadores: seleccionados }, 
            dataType: "json", 
            success: function (response) {
                if (response.success) {
                //Te lleva a la otra pagina si fue bien.
                window.location.href = './plantilla.html';
                    
                } else {
                    alert("Error: " + response.error);
                }
            },
            error: function () {
                alert("Error al enviar los datos.");
            },
        });
    });

    
});
