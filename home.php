<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Management</title>
    <link rel="stylesheet" href="./adminstyle.css">
</head>
<body>
    <div class="recipe-container">
    <h1>Recipe Management</h1>
    <h2>List of Recipes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Ingredients</th>
            <th>Instructions</th>
            <th>Cooking Time</th>
            <th>Serving Size</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php
        include 'connection.php';
        $sql = "SELECT * FROM recipes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['ingredients']}</td>";
                echo "<td>{$row['instructions']}</td>";
                echo "<td>{$row['cooking_time']}</td>";
                echo "<td>{$row['serving_size']}</td>";
                echo "<td><img src='{$row['image_url']}' width='100' height='100'></td>";
                echo "<td><button onclick='editRecipe({$row['id']})'>Edit</button>";
                echo "<button onclick='deleteRecipe({$row['id']})'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No recipes found</td></tr>";
        }
        ?>
    </table>

    <br><br>
    <h1>Add New Recipe</h1>
    <form action="create_recipe.php" method="post" enctype="multipart/form-data">
        Name: <input type="text" name="name" required><br>
        Ingredients (comma-separated): <textarea name="ingredients" required></textarea><br>
        Instructions: <textarea name="instructions" required></textarea><br>
        Cooking Time: <input type="text" name="cooking_time" required><br>
        Serving Size: <input type="number" name="serving_size" required><br>
        Image: <input type="file" name="image" required><br><br>
        <button type="submit">Add Recipe</button>
    </form>
    </div>
    <script>
        function editRecipe(id) {
            window.location.href = "update_recipe.php?id=" + id;
        }
        function deleteRecipe(id) {
            if (confirm("Are you sure you want to delete this recipe?")) {
                window.location.href = "delete_recipe.php?id=" + id;
            }
        }
    </script>
</body>
</html>