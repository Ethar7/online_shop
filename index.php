<?php include 'inc/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <?php
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "product";

        $conn = new mysqli($servername, $username, $password, $dbname);

        
        $sql_query = "SELECT * FROM products";
        $result = $conn->query($sql_query);

        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-lg-4 mb-3">
                    <div class="card">
                        <img src="images/<?php echo $row['image']; ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="text-muted"><?php echo $row['price']; ?> EGP</p>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <a href="show.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Show</a>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

        
        
        ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
