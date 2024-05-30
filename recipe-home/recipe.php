<?php

    session_start();
    $recipes=getRecipes();

    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ing = $_POST["ing"];
        if (isset($_POST['increment'])) {
            if (isset($_SESSION['cart'][$ing])) {
                $_SESSION['cart'][$ing]++;
            } else {
                $_SESSION['cart'][$ing] = 1; 
            }
        } elseif (isset($_POST["decrement"])) {
            if (isset($_SESSION['cart'][$ing]) && $_SESSION['cart'][$ing] > 0) {
                $_SESSION['cart'][$ing]--;
                if ($_SESSION['cart'][$ing] <= 0) {
                    unset($_SESSION['cart'][$ing]); 
                }
            }
        }
    }

    function getRecipes() {
        $servername = "localhost";
        $username = "root"; 
        $password = "<your-pass>"; 
        $database = "shopping"; 
        $conn = new mysqli($servername, $username, $password, $database, "3306");
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $recipes = [];  
        $sql = "SELECT * FROM recipes"; 
        $result = $conn->query($sql);  
    
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                $recipe = [
                    "name" => $row['name'],
                    "ingredients" => $row['ingredients'],
                    "instructions" => $row['instructions'],
                    "cooking_time" => $row['cooking_time'],
                    "serving_size" => $row['serving_size'],  
                    "image_path" => $row['image_url'] 
                ];
                $recipe['ingredients']=parseIngredients($recipe['ingredients']);
                array_push($recipes,$recipe);
            }
        } else {
            echo "0 results";
        }
    
        return $recipes;  // Return the array of recipes
    }
    function parseIngredients($ingredientsString) {
        $ingredientsArray = [];
        $ingredientsPairs = explode(",", $ingredientsString);
        
        foreach ($ingredientsPairs as $pair) {
            list($ingredient, $quantity) = explode(":", $pair);
            $ingredientsArray[$ingredient] = floatval($quantity);
        }
        
        return $ingredientsArray;
    }
    function mergeIngredients($recipes) {
        $mergedIngredients = [];
    
        foreach ($recipes as $recipe) {
            $ingredients = $recipe['ingredients'];
    
            foreach ($ingredients as $ingredient => $quantity) {
                // Check if the ingredient already exists in the merged list
                if (array_key_exists($ingredient, $mergedIngredients)) {
                    // Add the quantities together if the ingredient is already in the list
                    $mergedIngredients[$ingredient] += floatval($quantity); // Convert quantity to float
                } else {
                    // Add the ingredient to the merged list if it doesn't exist
                    $mergedIngredients[$ingredient] = floatval($quantity); // Convert quantity to float
                }
            }
        }
    
        return $mergedIngredients;
    }
    
    $uniqueIngredients = mergeIngredients($recipes);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Recipe</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="home.css">

</head>

<body class="overflow-hidden">

    <header>
        <nav>
            <a href="../home.html">
                <img src="../assets/logo.png" width="100" height="100" alt="Recipe sharing" priority />
            </a>

            <img src="../assets/cart.png" width="50" height="50" id="shopping-cart-icon">

        </nav>


    </header>

    <main>
        <h1 class="font-Cormorant title" > Discover the recipe that you like!</h1>
        <br>
        <br>
        <div class="recipeContainer">
            <?php
                foreach ($recipes as $recipe ) {
                    echo "<div  class='card recipe'>";
                    echo "<img src='../{$recipe['image_path']}' alt='Avatar' >";
                    echo "<div class='container'>";
                    echo "<h4><b>{$recipe['name']}</b></h4>";
                    echo "<p> {$recipe['instructions']} </p>";
                    echo "<p> Cooking Time : {$recipe['cooking_time']} </p>";
                    echo "<p> Serving Size : {$recipe['serving_size']} </p>";

                    echo "<ul>";
                    foreach ($recipe['ingredients'] as $ingredient => $quantity) {
                        echo "<form method='post' action='" .htmlspecialchars($_SERVER['PHP_SELF']) . "'>";
                        $cartQuantity = isset($_SESSION['cart'][$ingredient]) ? $_SESSION['cart'][$ingredient] : 0;
                        echo "<li class='ingredient  flex justify-between'>";
                        echo "<span style='width:100px'>{$ingredient}: </span>";
                        echo "<div style='width:143px;height:34px'>";
                        if ($cartQuantity > 0) {
                            echo "<button type='submit' name='decrement' >-</button>";
                        } else {
                            echo "<button type='submit' name='decrement' disabled>-</button>";
                        }
                        echo "<input type='text' name='{$ingredient}' value='{$cartQuantity}' size='2' readonly>";
                        echo "<input type='hidden' name='ing' value='{$ingredient}'>";
                        echo "<button type='submit' name='increment'>+</button>";
                        echo "</div>";

                        echo "</li>";
                        echo "</form>";
                    }
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";

                }
            ?>
        </div>            

        </div>
        
        </main>
    <div id="shopping-cart-container" class="hidden">
        <div id="shopping-cart-trigger">

        </div>
        <div class="shopping-cart-items-container">
            <h2>Shopping Cart</h2>
            <?php
                if (!empty($_SESSION['cart'])) {
                    echo "<table>";
                    echo "<tr><th>Icon</th><th>Ingredient</th><th>Quantity</th><th>Price for 1</th><th>Total price</th></tr>";

                    $totalCartPrice = 0;

                    foreach ($_SESSION['cart'] as $ingredient => $quantity) {
                        if (array_key_exists($ingredient, $uniqueIngredients)) {
                            $pricePerUnit = $uniqueIngredients[$ingredient];
                            $totalIngredientPrice = $pricePerUnit * $quantity;
                            $totalCartPrice += $totalIngredientPrice;

                            echo "<tr>";
                            echo "<td><img src='../assets/ingredient.svg' alt='{$ingredient}' style='width: 40px; height: 40px;'></td>";
                            echo "<td>{$ingredient}</td>";
                            echo "<td>{$quantity}</td>";
                            echo "<td>{$pricePerUnit}</td>"; 
                            echo "<td>{$totalIngredientPrice}</td>"; 
                            echo "</tr>";
                        } else {
                            echo "<tr>";
                            echo "<td><img src='../assets/ingredient.svg' alt='{$ingredient}' style='width: 40px; height: 40px;'></td>";
                            echo "<td>{$ingredient}</td>";
                            echo "<td>{$quantity}</td>";
                            echo "<td>Price not available</td>"; 
                            echo "<td>N/A</td>"; 
                            echo "</tr>";
                        }
                    }

                    echo "<tr><td colspan='4'><strong>Total Price:</strong></td><td><strong>\${$totalCartPrice}</strong></td></tr>";

                    echo "</table>";
                } else {
                    echo "<p>Shopping cart is empty</p>";
                }
            ?>
        </div>
    </div>

    </div>
    <footer>
        <section class="container ">
            <section class="intro">
                <h4>Digital Recipe</h4>
                <h5>

                </h5>

            </section>
            <section class="info">
                <h4>Beirut Lebanon</h4>
                <a href="https://g.co/kgs/sAu1kLT">
                    <span>
                        Lorem ipsulm
                    </span>
                </a>
                <a href="tel:+961 76838889">
                    +961 76838889
                </a>
                <a href="mailto:digital_recipe@outlook.com">
                    digital_recipe@outlook.com
                </a>
            </section>

        </section>
        <section style="margin-top: 4px; color: white;">
            <span>
                © YOYOS Catering. All Rights Reserved 2024
            </span>

        </section>

    </footer>

    <script src="../script.js"></script>

</body>

</html>