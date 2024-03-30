<?php
include ("database.php");

$search = $_POST['search'];

if (!empty($search)) {
    // Consulta preparada con marcador de posición
    $query = "SELECT * FROM task WHERE NAME LIKE ?";

    // Preparar la consulta
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        // Vincular el parámetro
        $searchParam = $search . "%";
        mysqli_stmt_bind_param($stmt, "s", $searchParam);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Obtener el resultado
            $result = mysqli_stmt_get_result($stmt);

            // Crear un array para almacenar los resultados
            $json = array();
            while ($row = mysqli_fetch_array($result)) {
                $json[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description']
                );
            }

            // Convertir el array a JSON y enviarlo como respuesta
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } else {
            // Error al ejecutar la consulta
            die('Query Error ' . mysqli_error($connection));
        }

        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
    } else {
        // Error al preparar la consulta
        die('Prepare Error ' . mysqli_error($connection));
    }
}
?>