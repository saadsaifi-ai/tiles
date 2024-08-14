<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

</head>
<body>

    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navbar.php'; ?>

    <div class="container my-5">
    <div class="row">
        <!-- Wall Category -->
        <div class="col-md-4 text-center">
            <h3>
                <a href="wall.php">Wall</a>
            </h3>
            <a href="wall.php">
                <img src="images/wall1.jpg" alt="Wall" class="img-fluid" style="width:300px; height:200px;">
            </a>
        </div>

        <!-- Floor Category -->
        <div class="col-md-4 text-center">
            <h3>
                <a href="floor.php">Floor</a>
            </h3>
            <a href="floor.php">
                <img src="images/floor1.jpg" alt="Floor" class="img-fluid" style="width:300px; height:200px;">
            </a>
        </div>

        <!-- Bathroom Category -->
        <div class="col-md-4 text-center">
            <h3>
                <a href="bathroom.php">Bathroom</a>
            </h3>
            <a href="bathroom.php">
                <img src="images/bath1.jpg" alt="Bathroom" class="img-fluid" style="width:300px; height:200px;">
            </a>
        </div>
    </div>
</div>


    <?php include 'includes/footer.php'; ?>


</body>
</html>
