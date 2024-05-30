<?php
session_start(); // Start the session at the beginning

// Database connection parameters
$servername = "localhost"; // Hostname of the MySQL server
$username = "root"; // Default username for WampServer
$password = "<your-pass>"; // Default password for WampServer
$database = "shopping"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password from the form and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $input_password = mysqli_real_escape_string($conn, $_POST['password']);

    // SQL query to fetch user data from volunteers table
    $sql = "SELECT * FROM users WHERE name = '$name' AND password = '$input_password'";

    
    $result = $conn->query($sql);

    if ($name == 'admin' && $input_password == 'admin') {
        session_start();
        $_SESSION['name'] = $name;
        header("Location: home.php"); 
        exit();
    } elseif ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        
        if ($input_password==$row['password']) {
            session_start();
            $_SESSION['name'] = $name; // Store email in session variable
            header("Location: recipe-home/recipe.php"); // Redirect to welcome page
            exit();
        } else {
            echo "Invalid password for user account.<br>";
        }
    
    } else {
 echo "<script>
      alert('Invalid Username. Please sign up first.');
      window.location.href = 'index.php';
    </script>";
    }

}
// Close connection
$conn->close();
?>
