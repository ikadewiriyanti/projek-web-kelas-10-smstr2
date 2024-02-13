<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <a href="index.php">home</a>
            <a href="index.php">about</a>
            <a href="product.php">product</a>
            <a href="gallery.php">gallery</a>
            <a href="team.php">team</a>
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
                    $item_array_id = array_column($_SESSION["cart"],"id_produk");
                    if (!in_array($_GET["id"],$item_array_id)){
                        $count = count($_SESSION["cart"]);
                        $item_array = array(
                            'id_produk' => $_GET["id_produk"],
                            'foto' => $_POST["foto"],
                            'nama' => $_POST["nama"],
                            'harga' => $_POST["harga"],
                            'item_quantity' => $_POST["quantity"],
                        );
                        $_SESSION["cart"][$count] = $item_array;
                        
                        echo '<script>alert("Produk berhasil dimasukkan keranjang")</script>';
                        echo '<script>window.location="index.php"</script>';
                       
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


    <section class="product" id="product">

        <h1 class="heading">our <span> products</span></h1>



        <div class="box-container">
            <?php
                include "crud/koneksi.php";
                $query = mysqli_query($koneksi, "SELECT * FROM produk");
                while($data=mysqli_fetch_array($query)){
            ?>
                <form method="post" action="">
                    <div class="box">
                        <div class="image">
                            <img src="images/<?=$data['foto']?>" alt="">
                        </div>
                        <div class="content">
                            <h3> <?=$data['nama']?></h3>
                            <span class="price"><?=$data['harga']?></span><br>
                                    <input type="hidden" name="hidden_foto" value="<?=$data['foto']?>">
                                    <input type="hidden" name="hidden_name" value="<?=$data['nama']?>">
                                    <input type="hidden" name="hidden_price" value="<?=$data['harga']?>">
                                    <input type="number" name="quantity" class="form-control" value="1">
                                    <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success" value="Add to Cart">
                        </div>
                    </div>
                </form>
            <?php }?>
                

        </div>


    </section>


    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js"></script>

    <script src="js/script.js"></script>

    <script>
        lightGallery(document.querySelector('.gallery .gallery-container'));
    </script>


</body>
</html>