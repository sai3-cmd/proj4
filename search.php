<?php
$servername = "localhost";
$username = "root"; // your DB username
$password = ""; // your DB password
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . $row['username'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Created At: " . $row['created_at'] . "<br>";
        }
    } else {
        echo "No user found.";
    }
    $stmt->close();
}

$conn->close();
?>
