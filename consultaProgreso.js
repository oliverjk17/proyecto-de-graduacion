// Realizamos la solicitud para obtener el progreso
fetch('/php/obtener_progreso.php')
    .then(response => response.json())
    .then(data => {
        // Verificamos si hay un error (usuario no autenticado)
        if (data.error) {
            document.getElementById('nombre-usuario').textContent = 'Usuario no autenticado';
        } else {
            // Mostramos el nombre del usuario en la página
            document.getElementById('nombre-usuario').textContent = ` ${data.nombre} `; // aca se ve como se presenta el usuario en las diferentes paginas

            // Obtenemos el progreso y construimos la tabla HTML
            let progresoHTML = '<table><tr><th>Evaluaciones</th><th>Puntuacion</th><th>Modulo</th></tr>';

            data.progreso.forEach(item => {
                progresoHTML += `<tr>
                                    <td>${item.nombre_juego}</td> <!-- Mostrar el nombre del juego -->
                                    <td>${item.progreso_usuario}%</td>
                                    <td>${item.id_modulo}</td>
                                </tr>`;
            });

            progresoHTML += '</table>';
            
            // Mostramos la tabla en el div correspondiente
            document.getElementById('tabla-progreso').innerHTML = progresoHTML;
        }
    })
    .catch(error => console.error('Error al cargar el progreso: ', error));
