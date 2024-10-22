<?php include 'inc/header.php';?>



<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">

        <?php
                    

                    if (isset($_POST['submit'])) {
                        $name = $_POST['name'];
                        $price = $_POST['price'];
                        $desc = $_POST['desc'];
                        $img = $_FILES['img'];

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

                        if (isset($_FILES['img'])) {
                            $image = $_FILES['img'];
                            $image_name = $image['name'];
                            $tmp_name = $image['tmp_name'];

                            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                            $size = $image['size'] / (1024 * 1024);  // MB

                            $arr = ["png", "jpg", "jpeg"];

                            if (!in_array($ext, $arr)) {
                                $errors[] = "Invalid image format. Allowed formats: png, jpg, jpeg.";
                            } else {
                                $newName = uniqid() . "." . $ext;
                                if (!move_uploaded_file($tmp_name, "images/$newName")) {
                                    $errors[] = "Failed to move the uploaded file.";
                                }
                            }
                        } else {
                            $errors[] = "No file was uploaded or there was an error uploading the file.";
                        }


                        if (empty($errors)) {
                            $servername = "localhost";
                            $username = "root"; 
                            $password = ""; 
                            $dbname = "product"; 

                            
                            $conn = new mysqli($servername, $username, $password, $dbname);

                        
                

                            
                            $sql_query = "INSERT INTO products (name, price, description, image) VALUES ('$name', $price, '$desc', '$newName')";

                            
                            if ($conn->query($sql_query) === TRUE) {
                                header("Location: add.php"); 
                                exit;
                        } else {
                            foreach ($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        }
                    }
                }
                    ?>


        <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name = "name">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>

                <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name = "desc"></textarea>
                </div>

                <div class="mb-3">
                <label for="formFile" class="form-label">Image:</label>
                <input class="form-control" type="file" id="formFile" name="img">
                </div>

                <center><button on type="submit" class="btn btn-primary" name="submit">Add</button></center>
            </form>
        </div>
    </div>
</div>


<?php include 'inc/footer.php'; ?>