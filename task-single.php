<?php
include ('database.php');

$id = $_POST['id'];

// Consulta preparada para evitar inyección SQL
$query = "SELECT * FROM task WHERE id = ?";
$stmt = mysqli_prepare($connection, $query);

if ($stmt) {
    // Vincular parámetro a la consulta preparada
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);

    // Obtener resultados
    $result = mysqli_stmt_get_result($stmt);
    
    // Verificar si se encontraron resultados
    if (mysqli_num_rows($result) > 0) {
        $json = array();
        
        // Recorrer los resultados y agregar cada fila al array $json
        while ($row = mysqli_fetch_assoc($result)) {
            $json[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description']
            );
        }
        
        // Codificar el array completo en formato JSON
        $jsonstring = json_encode($json[0]);
        
        // Mostrar el JSON
        echo $jsonstring;
    } else {
        echo json_encode(array("message" => "No se encontraron resultados"));
    }
    
    // Cerrar la consulta preparada
    mysqli_stmt_close($stmt);
} else {
    echo "Error en la preparación de la consulta";
}

// Cerrar la conexión a la base de datos
mysqli_close($connection);
?>
