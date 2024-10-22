<?php 
include 'inc/header.php'; 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql_query = "SELECT * FROM products WHERE id = ?";
    $prep = $conn->prepare($sql_query);
    $prep->bind_param("i", $product_id);
    $prep->execute();
    $result = $prep->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "<div class='alert alert-danger'>Product not found.</div>";
        exit;
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $img = $_FILES['img'];
    $newName = $product['image']; 

    $errors = [];

    
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($price) || !is_numeric($price)) {
        $errors[] = "Valid price is required.";
    }

    if (empty($desc)) {
        $errors[] = "Description is required.";
    }

    if (!empty($img['name'])) {
        $image_name = $img['name'];
        $tmp_name = $img['tmp_name'];

        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $size = $img['size'] / (1024 * 1024); // MB

        $arr = ["png", "jpg", "jpeg"];

        if (!in_array($ext, $arr)) {
            $errors[] = "Invalid image format. Allowed formats: png, jpg, jpeg.";
        } else {
            $newName = uniqid() . "." . $ext;
            if (!move_uploaded_file($tmp_name, "images/$newName")) {
                $errors[] = "Failed to move the uploaded file.";
            }
        }
    }

    if (empty($errors)) {
        $sql_query = "UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?";
        $prep = $conn->prepare($sql_query);
        $prep->bind_param("sdssi", $name, $price, $desc, $newName, $product_id);

        if ($prep->execute()) {
            echo "<div class='alert alert-success'>Product updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="desc"><?php echo $product['description']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Image:</label>
                    <input class="form-control" type="file" id="formFile" name="img">
                    <div class="mt-3">
                        <img src="images/<?php echo $product['image']; ?>" class="img-fluid" width="150px">
                    </div>
                </div>

                <center><button type="submit" class="btn btn-primary" name="submit">Update</button></center>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
