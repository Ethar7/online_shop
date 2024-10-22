<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product";

$conn = new mysqli($servername, $username, $password, $dbname);




if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql_query = "DELETE FROM products WHERE id = ?";
    $prep = $conn->prepare($sql_query);
    $prep->bind_param("i", $product_id); 

    if ($prep->execute()) {
        header("Location: index.php?msg=Product deleted successfully");
        exit();
    } else {
        echo "<p>Error deleting product: " . $conn->error . "</p>";
    }

} 



?>
