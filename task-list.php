<?php
include ('database.php');

$query = "SELECT * FROM task";
$result = mysqli_query($connection, $query);
if(!$result) {
    die('Query failed '.mysqli_error($connection));
}

$json = array();
while($row = mysqli_fetch_array($result)) {
    $json[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
    );
};

$jsonstring = json_encode($json);
echo $jsonstring;

?>