<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coffeShop</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css">

    <link rel="stylesheet" href="css/stylee.css">
</head>
<body>
    
    <!-- header -->

    <header class="header">

        <a href="crud/index.php" class="logo"> <i class="fas fa-coffee"></i> __cofeshop </a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="product.php">product</a>
            <a href="gallery.php">gallery</a>
            <a href="team.php">team</a>
            <a href="profile user.php">profile user</a>
            <!--<a href="#review">review</a>-->
            <!--<a href="#order">order</a>-->
        </nav>

        <div class="icons" id="cart">
            <div id="cart-btn" class="fas fa-shopping-cart"></div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>

    </header>

    <!-- header end -->

    <!-- shopping cart -->

    <section id="cart-btn">
        <?php
            if (isset($_POST["add"])){
                if (isset($_SESSION["cart"])){
                    $item_array_id = array_column($_SESSION["cart"],"product_id");
                    if (!in_array($_GET["id"],$item_array_id)){
                        $count = count($_SESSION["cart"]);
                        $item_array = array(
                            'product_id' => $_GET["id"],
                            'item_foto' => $_POST["hidden_foto"],
                            'item_name' => $_POST["hidden_name"],
                            'product_price' => $_POST["hidden_price"],
                            'item_quantity' => $_POST["quantity"],
                        );
                        $_SESSION["cart"][$count] = $item_array;
                        
                        echo '<script>alert("Produk berhasil dimasukkan keranjang")</script>';
                        echo '<script>window.location="cart_view.php"</script>';
                       
                    }else{
                        echo '<script>alert("Produk sudah ada di keranjang")</script>';
                        echo '<script>window.location="index.php"</script>';
                    }
                }else{
                    $item_array = array(
                        'product_id' => $_GET["id"],
                        'item_foto' => $_POST["hidden_foto"],
                        'item_name' => $_POST["hidden_name"],
                        'product_price' => $_POST["hidden_price"],
                        'item_quantity' => $_POST["quantity"],
                    );
                    $_SESSION["cart"][0] = $item_array;
        
                    echo '<script>alert("Produk berhasil dimasukkan keranjang")</script>';
                    echo '<script>window.location="index.php#cart-btn"</script>';
        
                }
            }
        
            if (isset($_GET["action"])){
                if ($_GET["action"] == "delete"){
                    foreach ($_SESSION["cart"] as $key => $value){
                        if ($value["product_id"] == $_GET["id"]){
                            unset($_SESSION["cart"][$key]);
                            echo '<script>alert("Product has been Removed...!")</script>';
                            echo '<script>window.location="index.php"</script>';
                        }
                    }
                }elseif($_GET["action"] == "beli"){
                    
                    foreach($_SESSION["cart"] as $key => $value){
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    }
                    $query = mysqli_query($koneksi, "INSERT INTO trans (date_trans,total_harga) VALUE ('".date("Y-m-d")."','$total')");
                    $id_trans = mysqli_insert_id($koneksi);
        
                    foreach($_SESSION["cart"] as $key => $value){
                        $id_prod = $value['product_id'];
                        $qty = $value['item_quantity'];
                        $sql = "INSERT INTO detail (id_trans,id_prod,qty) VALUES ('$id_trans', '$id_prod', '$qty')";
                        $res = mysqli_query($koneksi, $sql); 
                    }
                    
                    unset($_SESSION["cart"]);
                    echo '<script>alert("Terima kasih sudah berbelanja!")</script>';
                    echo "<script>window.location='cetak.php?id=".$id_trans."'</script>";
        
                }
            }
        ?>
        <div class="cart-items-container" >


            <div id="close-form" class="fas fa-times"></div>
            <h3 class="title">checkout</h3>

            <?php if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>

            <div class="cart-item">
                <span class="fas fa-times"></span>
                <img src="images/cart-1.jpg" alt="">
                <div class="content">
                    <h3><?=$value["item_name"]?></h3>
                    <div class="price"><?=$value["product_price"]?></div>
                </div>
            </div>

                    <?php }}?>

            <a href="" class="btn"> checkout </a>

        </div>
    </section>

    <!-- shopping cart end-->


    
    <!-- home -->

    <section class="home" id="home">

        <div class="swiper home-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide slide" style="background: url(images/bckg1.jpg) no-repeat;">
                    <div class="content">
                        <h3>welcomeeeee</h3>
                        
                    </div>
                </div>

                <div class="swiper-slide slide" style="background: url(images/bckg2.jpg) no-repeat;">
                    <div class="content">
                        <h3>jl.perjuangan SMKN 1 cirebon</h3>
                       
                    </div>
                </div>

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>

    <!-- home section ends -->

    

    <!-- about us -->

    <section class="about" id="about">

        <h1 class="heading"> <span>about</span> us </h1>

        <div class="row">

            <div class="image">
                <img src="images/about.jpg" alt="">
            </div>

            <div class="content">
                <h3>Choffee Shop<span></h3>
                <p>Coffee shop adalah tempat yang menyediakan berbagai jenis kopi dan minuman non alkohol lainnya dalam suasana santai, tempat yang nyaman, dan dilengkapi dengan alunan musik, baik lewat pemutar atau pun live music,</p>
            </div>

        </div>

    </section>


    <!-- about us end-->

    <!-- team -->

    <section class="team" id="team">

        <h1 class="heading"><span></span></h1>

        <div class="box-container">

            <div class="box">
                <div class="image">
                    <img src="images/a1.jpg" alt="">
                </div>
                <div class="content">
                    <h3></h3>
                    <p></p>
                    
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="images/a2.jpg" alt="">
                </div>
                <div class="content">
                    <h3></h3>
                    <p></p>
                    
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="images/a3.jpeg" alt="">
                </div>
                <div class="content">
                    <h3></h3>
                    <p></p>
                    
                </div>
            </div>

        </div>

    </section>

    <!-- team -->

    <!-- parallax -->

    
    <!-- parallax -->

    <!-- review -->

    

    <!-- review -->

    <!-- order -->

    <!--<section class="order" id="order">

        <h1 class="heading"><span>order</span> now </h1>

        <div class="row">

            <div class="image">
                <img src="images/order.gif" alt="">
            </div>

            <form action="">

                <div class="inputBox">
                    <input type="text" placeholder="first name">
                    <input type="text" placeholder="last name">
                </div>

                <div class="inputBox">
                    <input type="email" placeholder="email address">
                    <input type="number" placeholder="phone number">
                </div>

                <div class="inputBox">
                    <input type="text" placeholder="food name">
                    <input type="number" placeholder="how much">
                </div>

                <textarea placeholder="your address" name="" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="order now" class="btn">
            </form>

        </div>

    </section>-->

    <!-- order end -->

    <!-- footer -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>address</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Alias sit debitis.</p>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <h3>E-mail</h3>
                <a href="#" class="link">ninjashub4@gmail.com</a>
                <a href="#" class="link">ninjashub4@gmail.com</a>
            </div>

            <div class="box">
                <h3>call us</h3>
                <p>+61 (2) 1478 2369</p>
                <p>+61 (2) 1478 2369</p>
            </div>

            <div class="box">
                <h3> opening hours</h3>
                <p>Monday - Friday: 9:00 - 23:00 <br> Saturday: 8:00 - 24:00 </p>
            </div>

        </div>

        <div class="credit">created by <span>ninjashub</span> all rights reserved! </div>

    </section>







    <!-- footer ends -->

















    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js"></script>

    <script src="js/script.js"></script>

    <script>
        lightGallery(document.querySelector('.gallery .gallery-container'));
    </script>


</body>
</html>