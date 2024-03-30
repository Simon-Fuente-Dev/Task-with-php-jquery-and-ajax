<?php
include ("database.php");

if (isset($_POST["name"]) || isset($_POST["description"])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $query = "INSERT INTO task(name, description) VALUES (?,?)";
    //Preparar la consulta
    $stmt = $connection->prepare($query);

    //Vincular parametros con los marcadores de posicion
    $stmt->bind_param("ss", $name, $description);
    if ($stmt->execute()) {
        echo "Insercion exitosa";
    }else {
        echo "Error al insertar ".$stmt->error;
    }
    $stmt->close();
}
?>