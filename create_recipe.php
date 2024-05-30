<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $ingredients = $_POST["ingredients"];
    $instructions = $_POST["instructions"];
    $cooking_time = $_POST["cooking_time"];
    $serving_size = $_POST["serving_size"];
    $image_name = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_folder = "uploads/";
    $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $unique_image_name = uniqid() . '.' . $image_extension;
    $image_path = $image_folder . $unique_image_name;
    move_uploaded_file($image_temp, $image_path);

    $sql = "INSERT INTO recipes (name, ingredients, instructions, cooking_time, serving_size, image_url ) VALUES ('$name', '$ingredients', '$instructions', '$cooking_time', '$serving_size', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php"); // Redirect to home
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>