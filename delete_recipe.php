<?php
include 'connection.php';
if (isset($_GET['id'])) {
    $recipe_id = $_GET["id"];
    $sql = "DELETE FROM recipes WHERE id = $recipe_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error occurred: " . mysqli_error($conn);
    }
} else {
    header("Location: home.php");
    exit();
}
?>