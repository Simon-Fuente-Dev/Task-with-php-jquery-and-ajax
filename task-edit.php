<?php
include ('database.php');

// Obtener los datos de la solicitud POST de manera segura
$id = mysqli_real_escape_string($connection, $_POST['id']);
$name = mysqli_real_escape_string($connection, $_POST['name']);
$description = mysqli_real_escape_string($connection, $_POST['description']);

// Preparar la consulta con marcadores de posición (?)
$query = "UPDATE task SET name = ?, description = ? WHERE id = ?";

// Preparar la declaración
$stmt = mysqli_prepare($connection, $query);

// Vincular parámetros
mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);

// Ejecutar la consulta preparada
if(mysqli_stmt_execute($stmt)) {
    echo "Tarea actualizada exitosamente";
} else {
    echo "Error al actualizar la tarea: " . mysqli_error($connection);
}

// Cerrar la declaración y la conexión
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
