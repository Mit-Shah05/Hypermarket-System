<?php
include("db_connect.php"); // Connects to your 'hypermarketdb'

$sql = "SELECT ProductID, ProductName, Price, ImagePath FROM product WHERE Category = 'Clothing'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cloverse - Clothing</title>

    <!-- SWIPER -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <style>
        .cargo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            justify-content: center;
            align-items: stretch;
        }

        .cargo-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 10px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cargo-item img {
            width: 180px;
            height: 220px;
            object-fit: contain;
        }
    </style>

    <script>
        function updateCart(productId, name, price, image, buyNow = false) {
            const selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            selectedItems.push({ productId, name, price, image });
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));

            if (buyNow) {
                window.location.href = 'your_cart.html';
            } else {
                alert('Item added to cart!');
            }
        }
    </script>
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <div id="menu-btn" class="fas fa-bars"></div>

        <div class="logo"><a href="index.html"><img src="logo.png" style="height:130px;width:150px"></a></div>

        <nav class="navbar">
            <a href="clothing.php">Clothes</a>
            <a href="grocery.php">Groceries</a>
            <a href="electronics.php">Electronics</a>
            <a href="fooditem.php">Food Items</a>
        </nav>
        <a href="account.html" class="btn">My Account</a>
        <a href="your_cart.html" class="btn">Go to Cart</a>
    </header>

    <section>
        <h1 class="heading" style="margin-top: 150px;">Collection <span>Clothing</span></h1>
        <div class="cargo-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="cargo-item">
                    <img src="<?php echo htmlspecialchars($row['ImagePath']); ?>" alt="">
                    <h3><?php echo htmlspecialchars($row['ProductName']); ?><br>Rs <?php echo number_format($row['Price'], 2); ?></h3>
                    <button class="btn" onclick="updateCart('<?php echo $row['ProductID']; ?>', '<?php echo htmlspecialchars($row['ProductName']); ?>', <?php echo $row['Price']; ?>, '<?php echo htmlspecialchars($row['ImagePath']); ?>', true)">Buy Now</button>
                    <button class="btn" onclick="updateCart('<?php echo $row['ProductID']; ?>', '<?php echo htmlspecialchars($row['ProductName']); ?>', <?php echo $row['Price']; ?>, '<?php echo htmlspecialchars($row['ImagePath']); ?>')">Add to Cart</button>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!--Footer-->
    <section class="footer">
        <div class="box-container" style="background-color: white;">
            <div class="box">
                <h3>Shop</h3>
                <a href="index.html"><i class="fas fa-arrow-right"></i> Home</a>
                <a href="#"><i class="fas fa-arrow-right"></i> Sale</a>
                <a href="#"><i class="fas fa-arrow-right"></i> Featured</a>
                <a href="men.html"><i class="fas fa-arrow-right"></i> Men</a>
                <a href="#"><i class="fas fa-arrow-right"></i> Women</a>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="index.html"><i class="fas fa-arrow-right"></i> About Us</a>
                <a href="index.html"><i class="fas fa-arrow-right"></i> Careers</a>
                <a href="index.html"><i class="fas fa-arrow-right"></i> T&C</a>
                <a href="index.html"><i class="fas fa-arrow-right"></i> Privacy Policy</a>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <a href="#"><i class="fas fa-phone"></i> +22-659-7890</a>
                <a href="#"><i class="fas fa-phone"></i> +22-222-3333</a>
                <a href="#"><i class="fas fa-envelope"></i> cappulatte@gmail.com</a>
            </div>

            <div class="box">
                <h3>social links</h3>
                <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i> facebook</a>
                <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i> twitter</a>
                <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i> instagram</a>
                <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin"></i> linkedin</a>
            </div>
        </div>
    </section>

</body>
</html>
