<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "<your-pass>";
$database = "shopping";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if password length is less than 6 characters
   if (strlen($password) < 6) {
        echo "<script>
                alert('Password must be at least 6 characters long.');
                window.location.href = 'index.php'; // Redirect back to the registration page
              </script>";
        exit(); // Stop further execution*/
    }

    //$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password after passing length check

    // Check if the email is already registered
    $emailCheckSql = "SELECT email FROM users WHERE email = '$email'";
                      
    $emailCheckResult = $conn->query($emailCheckSql);
    if ($emailCheckResult->num_rows > 0) {
        echo "<script>
                alert('The email address is already registered. Please use a different email.');
                window.location.href = 'index.php';
              </script>";
        exit();
    } else {
        $sql = null; // Initialize the SQL variable

       
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Record succesfully";
                header("Location: recipe-home/recipe.php");
                //exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        
        }

    $conn->close();
    }

?>
