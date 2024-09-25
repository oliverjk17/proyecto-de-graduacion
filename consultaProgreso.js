// Realizamos la solicitud para obtener el progreso
fetch('/php/obtener_progreso.php')
    .then(response => response.json())
    .then(data => {
        // Verificamos si hay un error (usuario no autenticado)
        if (data.error) {
            document.getElementById('nombre-usuario').textContent = 'Usuario no autenticado';
        } else {
            // Mostramos el nombre del usuario en la página
            document.getElementById('nombre-usuario').textContent = ` ${data.nombre} `; // Mostrar el nombre del usuario

            // Obtenemos el progreso y construimos la tabla HTML
            let progresoHTML = '<table><tr><th>Evaluaciones</th><th>Puntuación</th><th>Módulo</th><th>Fecha Completado</th></tr>';

            data.progreso.forEach(item => {
                progresoHTML += `<tr>
                                    <td>${item.nombre_juego}</td> <!-- Mostrar el nombre del juego -->
                                    <td>${item.progreso_usuario}%</td>
                                    <td>${item.id_modulo}</td>
                                    <td>${new Date(item.fecha_completado).toLocaleDateString('es-ES')}</td> <!-- Mostrar la fecha de completado en formato local -->
                                </tr>`;
            });

            progresoHTML += '</table>';
            
            // Mostramos la tabla en el div correspondiente
            document.getElementById('tabla-progreso').innerHTML = progresoHTML;
        }
    })
    .catch(error => console.error('Error al cargar el progreso: ', error));

// Paginación

let currentPage = 1;
let itemsPerPage = 5; // Valor por defecto
let progressData = []; // Array para almacenar los datos del progreso

// Función para cargar y mostrar los datos
function loadProgressData() {
    fetch('/php/obtener_progreso.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('nombre-usuario').textContent = 'Usuario no autenticado';
            } else {
                document.getElementById('nombre-usuario').textContent = ` ${data.nombre} `;

                // Almacena los datos del progreso
                progressData = data.progreso;
                displayTable();
            }
        })
        .catch(error => console.error('Error al cargar el progreso: ', error));
}

// Función para mostrar la tabla de progreso
function displayTable() {
    let start = (currentPage - 1) * itemsPerPage;
    let end = start + itemsPerPage;
    let paginatedData = progressData.slice(start, end);

    let progresoHTML = '<table><tr><th>Evaluaciones</th><th>Puntuacion</th><th>Modulo</th><th>Fecha Completado</th></tr>';

    paginatedData.forEach(item => {
        const fechaCompletado = new Date(item.fecha_completado).toLocaleString(); // Muestra la fecha y hora

        progresoHTML += `<tr>
                            <td>${item.nombre_juego}</td>
                            <td>${item.progreso_usuario}%</td>
                            <td>${item.id_modulo}</td>
                            <td>${fechaCompletado}</td>
                        </tr>`;
    });

    progresoHTML += '</table>';
    document.getElementById('tabla-progreso').innerHTML = progresoHTML;

    // Actualiza la información de la paginación
    document.getElementById('page-info').textContent = `Página ${currentPage} de ${Math.ceil(progressData.length / itemsPerPage)}`;

    // Habilitar/deshabilitar botones de paginación
    document.getElementById('prev-btn').disabled = currentPage === 1;
    document.getElementById('next-btn').disabled = currentPage === Math.ceil(progressData.length / itemsPerPage);
}

// Función para cambiar la cantidad de registros por página
function changeItemsPerPage() {
    let selectElement = document.getElementById('items-per-page');
    itemsPerPage = parseInt(selectElement.value); // Actualiza el valor de itemsPerPage
    currentPage = 1; // Reiniciar a la primera página
    displayTable(); // Volver a cargar la tabla con el nuevo valor
}

// Función para cambiar de página
function changePage(direction) {
    currentPage += direction;
    displayTable();
}

// Cargar los datos al inicio
loadProgressData();
