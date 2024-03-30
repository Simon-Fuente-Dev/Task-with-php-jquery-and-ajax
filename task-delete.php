<?php
include ("database.php");
if (isset($_POST["id"])) {
    $id_task = $_POST['id'];
    $query = "DELETE FROM task WHERE id = ?";

    //Preparar la consulta
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        $stmt->bind_param('s', $id_task);
        if ($stmt->execute()) {
            echo 'Tarea eliminada exitosamente';
        } else {
            echo 'Error al eliminar la tarea: '. $stmt->error;
        }
    }else {
        echo 'Error al preparar la consulta'. mysqli_error($connection);
    }
    $stmt->close();
}


?>