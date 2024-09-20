<?php
function ejecutarConsulta($sql) {
    $servername = 'localhost';
    $dbname = 'proyecto_graduacion';
    $username = 'root';
    $password = 'root';

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si la consulta retorna resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Almacenar cada fila en un array
        }
        // Devolver los resultados en formato JSON
        echo json_encode($data);
    } else {
        echo json_encode(array());
    }

    // Cerrar la conexión
    $conn->close();
}
