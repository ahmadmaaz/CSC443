<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
    $sql = "SELECT * FROM recipes WHERE id=$recipe_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $ingredients = $row['ingredients'];
        $instructions = $row['instructions'];
        $cooking_time = $row['cooking_time'];
        $serving_size = $row['serving_size'];
        $current_image = $row['image_url'];
    } else {
        echo "ERROR: RECIPE DOES NOT EXIST";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_id = $_POST["id"];
    $name = $_POST["name"];
    $ingredients = $_POST["ingredients"];
    $instructions = $_POST["instructions"];
    $cooking_time = $_POST["cooking_time"];
    $serving_size = $_POST["serving_size"];

    $image_update_sql = '';
    if ($_FILES["image"]["size"] > 0) {
        $image_name = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $image_folder = "uploads/";
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $unique_image_name = uniqid() . '.' . $image_extension;
        $image_path = $image_folder . $unique_image_name;
        move_uploaded_file($image_temp, $image_path);
        $image_update_sql = ", image_url='$image_path'";
    }

    $sql = "UPDATE recipes SET name='$name', ingredients='$ingredients', instructions='$instructions', cooking_time='$cooking_time', serving_size=$serving_size $image_update_sql WHERE id=$recipe_id";
    
    if ($conn->query($sql) === TRUE) { 
        echo "Recipe updated successfully"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="./updatestyle.css">
</head>
<body>
    <h1>Edit Recipe</h1>
    <form action="update_recipe.php?id=<?php echo $recipe_id; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $recipe_id; ?>">

        Name:
        <input type="text" name="name" value="<?php echo $name; ?>" required><br>
        Ingredients:
        <textarea name="ingredients" required><?php echo $ingredients; ?></textarea><br>
        Instructions:
        <textarea name="instructions" required><?php echo $instructions; ?></textarea><br>
        Cooking Time:
        <input type="text" name="cooking_time" value="<?php echo $cooking_time; ?>" required><br>
        Serving Size:
        <input type="number" name="serving_size" value="<?php echo $serving_size; ?>" required><br>
        Current Image: <img src="<?php echo $current_image; ?>" width="100" height="100"><br>
        Update Image:
        <input type="file" name="image"><br><br>
        <button type="submit">Update Recipe</button>
    </form>
</body>
</html>