<?php include 'inc/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "product";

        $conn = new mysqli($servername, $username, $password, $dbname);

      

        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];

            $sql_query = "SELECT * FROM products WHERE id = ?";
            $prep = $conn->prepare($sql_query);
            $prep->bind_param("i", $product_id); 
            $prep->execute();
            $result = $prep->get_result();

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                ?>
                <div class="col-lg-6">
                    <img src="images/<?php echo $product['image']; ?>" class="card-img-top">
                </div>
                <div class="col-lg-6">
                    <h5><?php echo $product['name']; ?></h5>
                    <p class="text-muted">Price: <?php echo $product['price']; ?> EGP</p>
                    <p><?php echo $product['description']; ?></p>
                    <a href="index.php" class="btn btn-primary">Back</a>
                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn btn-info">Edit</a>
                    <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger">Delete</a>
                </div>
                <?php
         
            }

           
        } 

        
        ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
