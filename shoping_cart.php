<?php
session_start();
if(!isset($_SESSION['email'])){
   echo'<script language="javascript">
   alert("login dulu lah cuy"); document.location="login.php";</script>'; 
  
}
$koneksi= mysqli_connect("localhost","root","","handphone");
if (isset($_POST["add"])){
    if(isset($_SESSION["cart"])){
    $item_array_id=array_column($_SESSION["cart"],"id_pembeli");
    if(!in_array($_GET["id"],$item_array_id)){
        $count= count($_SESSION["cart"]);
        $item_array=array(
            'id_pembeli' => $_GET["id"],
            'nama' => $_POST["nama"],
            'harga' => $_POST["harga"],
            'produk' => $_POST["produk"],
            'item_quantity' => $_POST["quantity"],

            
        );
        $_SESSION["cart"][$count]=$item_array;
        echo '<script>alert("Produk Berhasil di Masukan Keranjang")</script>';
        echo '<script>window.location="eflyer-master/perulangan.php"</script>';
    }else{
        echo '<script>alert("Produk sudah ada di dalam keranjang")</script>';
        echo '<script>window.location="eflyer-master/perulangan.php"</script>';
    }
}else{
    $item_array=array(
        'id_pembeli' => $_GET["id"],
        'nama' => $_POST["nama"],
        'harga' => $_POST["harga"],
        'produk' => $_POST["produk"],
        'item_quantity' => $_POST["quantity"],
        
       
        
    );
    $_SESSION["cart"][0]=$item_array;
}
}

if (isset($_GET["action"])){
    if($_GET["action"] == "delete"){
        foreach($_SESSION["cart"] as $keys => $value ){
            if($value["id_pembeli"] == $_GET["id"]){
                unset($_SESSION["cart"][$keys]);
                echo '<script>alert("Product has been Removed...!")</script>';
                echo '<script>window.location="Cart.php"</script>';
            }
        }
    }
    elseif($_GET["action"] == "beli"){
            $total=0;
        foreach($_SESSION["cart"] as $key => $value){
            $total = $total + ($value["item_quantity"] * $value["harga"]);
            $nama = $_POST['nama_beli'];
        }
        $query = mysqli_query($koneksi, "INSERT INTO checkout (nama_beli,tgl,total) VALUE ('$nama','".date("Y-m-d")."','$total')");
        $id_trans = mysqli_insert_id($koneksi);

        foreach($_SESSION["cart"] as $key => $value){
            $id_prod = $value['id_pembeli'];
            $qty = $value['item_quantity'];
            $sql = "INSERT INTO detail (id_checkout,id_pembeli,item_quantity) VALUES ('$id_trans', '$id_prod', '$qty')";
            $res = mysqli_query($koneksi, $sql); 
        }
        
        unset($_SESSION["cart"]);
        echo '<script>alert("Terima kasih sudah berbelanja!")</script>';
        echo "<script>window.location='cetak.php?id=".$id_trans."'</script>";

    }
}
    

?>






<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style> 
body{
    background: linear-gradient(110deg, #BBDEFB 60%,#42A5F5  60%);                        
}
        
.shop{
    font-size: 10px;
}

.space{
    letter-spacing: 0.8px !important;
}

.second a:hover {
    color: rgb(92, 92, 92) ;
}

.active-2 {
    color: rgb(92, 92, 92) 
}


.breadcrumb>li+li:before {
    content: "" !important
}

.breadcrumb {
    padding: 0px;
    font-size: 20px;
    color: #ADD8E6 !important;
    position: relative;
    left:23px;
    
}

.first {
    background-color: white ;
}

a {
    text-decoration: none !important;
    color: #aaa ;
}

.btn-lg,.form-control-sm:focus,
.form-control-sm:active,
a:focus,a:active {
    outline: none !important;
    box-shadow: none !important
}

.form-control-sm:focus{
    border:1.5px solid #4bb8a9 ; 
}

.btn-group-lg>.btn, .btn-lg {
    padding: .5rem 0.1rem;
    font-size: 1rem;
    border-radius: 0;
    color: white !important;
    background-color: #4bb8a9;
    height: 2.8rem !important;
    border-radius: 0.2rem !important;
}

.btn-group-lg>.btn:hover, .btn-lg:hover {
    background-color: #26A69A;
}

.btn-outline-primary{
    background-color: #fff !important;
    color:#4bb8a9 !important;
    border-radius: 0.2rem !important;   
    border:1px solid #4bb8a9;
}

.btn-outline-primary:hover{
    background-color:#4bb8a9  !important;
    color:#fff !important;
    border:1px solid #4bb8a9;
}

.card-2{
    margin-top: 40px !important;
}

.card-header{
    background-color: #fff;
    border-bottom:0px solid #aaaa !important;
}

p{
    font-size: 13px ;
}
        
.small{
    font-size: 9px !important;
}

.form-control-sm {
    height: calc(2.2em + .5rem + 2px);
    font-size: .875rem;
    line-height: 3;
    border-radius: 0; 
    border-style: double;
    border-width:1px;
    border-color:#000;  
}

.cursor-pointer{
    cursor: pointer;
}

.boxed {
    padding: 0px 8px 0 8px ;
    background-color: #4bb8a9;
    color: white;
}

.boxed-1{
    padding: 0px 8px 0 8px ;
    color: black !important;
    border: 1px solid #aaaa;
}

.bell{
    opacity: 0.5;
    cursor: pointer;
}

@media (max-width: 767px) {
    .breadcrumb-item+.breadcrumb-item {
        padding-left: 0
    }
}
</style>
  </head>
  <body>
  <div class=" container-fluid my-5 ">
    <div class="row justify-content-center ">
        <div class="col-xl-10">
            <div class="card shadow-lg ">
                <div class="row p-2 mt-3 justify-content-between mx-sm-2">
                    <div class="col">
                        <p class="text-muted space mb-0 shop"><h6>RF PHONE STORE</h6></p>
                        <p class="text-muted space mb-0 shop"></p>   
                    </div>
                    <div class="col">
                        <div class="row justify-content-start ">
                            <div class="col">
                                <img class="irc_mi img-fluid cursor-pointer " src="shizuka.jpg"  width="70" height="70" >
                            </div> 
                        </div>
                    </div>
                    <div class="col-auto">
                        <img class="irc_mi img-fluid bell" src="https://i.imgur.com/uSHMClk.jpg" width="30" height="30"  >
                    </div>
                </div>
                <div class="row  mx-auto justify-content-center text-center">
                    <div class="col-12 mt-3 ">
                        <nav aria-label="breadcrumb" class="second ">
                            <ol class="breadcrumb indigo lighten-6 first  ">
                                <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase " href="#"><span class="mr-md-3 mr-1"></span></a><i class="fa fa-angle-double-right " aria-hidden="true"></i></li>
                                <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase" href="eflyer-master/perulangan.php "><span class="mr-md-3 mr-1">Home</span></a><i class="fa fa-angle-double-right text-uppercase " aria-hidden="true"></i></li>
                                <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase active-2" href="#"><span class="mr-md-3 mr-1"></span></a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            
                <div class="row justify-content-around">
                    <div class="col-md-5">
                        <div class="card  border-0">
                            <div class="card-header pb-0">
                                <h2 class="card-title space ">Checkout</h2>
                                
                                <hr class="my-0">
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-auto mt-0"><p><b></b></p></div>
                                    <div class="col-auto"><p><b></b> </p></div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col"><p class="text-muted mb-2">PAYMENT DETAILS</p><hr class="mt-0"></div>
                                </div>
                                <form action="Cart.php" method="post">
                               
                                <div class="form-group">
                                    <label for="name" class="small text-muted mb-1">NAMA</label>
                                    <input type="text" class="form-control form-control-sm" name="name"   placeholder="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="small text-muted mb-1">ALAMAT</label>
                                    <input type="text" class="form-control form-control-sm" name="alamat"   placeholder="addres" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="small text-muted mb-1">EMAIL</label>
                                    <input type="text" class="form-control form-control-sm" name="email"   placeholder="your email" required>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-sm-6 pr-sm-2">
                                        <div class="form-group">
                                            <label for="name" class="small text-muted mb-1">VALID THROUGH</label>
                                            <input type="text" class="form-control form-control-sm" name="name"   placeholder="06/21">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="small text-muted mb-1">CVC CODE</label>
                                            <input type="text" class="form-control form-control-sm" name="NAME"  placeholder="183">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-md-5">
                                    
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card border-0 ">
                            <div class="card-header card-2">
                                <p class="card-text text-muted mt-md-4  mb-2 space">YOUR ORDER <span class=" small text-muted ml-2 cursor-pointer">EDIT SHOPPING BAG</span> </p>
                                <hr class="my-2">
                            </div>
                            <?php
                            if(!empty($_SESSION["cart"])){
                                $total=0;
                                foreach($_SESSION["cart"] as $key => $value){
                            
                            
                            ?>
                            <div class="card-body pt-0">
                                <div class="row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="img/<?php echo $value["produk"]; ?>" width="62" height="62">
                                            <div class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col-auto"><p class="mb-0"><b><?php echo $value["nama"]; ?></b></p><small class="text-muted">1 Week Subscription</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" pl-0 flex-sm-col col-auto  my-auto"> <p class="boxed-1"><?php echo $value["item_quantity"]; ?></p></div>
                                    <div class=" pl-0 flex-sm-col col-auto  my-auto "><p><b><?php echo $value["harga"]; ?></b></p></div>
                                    <div class=" pl-0 flex-sm-col col-auto  my-auto "><p><a href="Cart.php?action=delete&id=<?php echo $value["id_pembeli"]; ?>"><span class="text-danger">Hapus</span></a></p></div>
                
                                </div>
                                <?php try{
                                    $sub= $value['item_quantity'] *
                                    $value['harga'];
                                    echo $sub;
                                }catch(exception $e){
                                    echo 'massage: '.$e->getmassage();
                                }
                                $total = $total + $sub;
                            } ?>
                                
                                
                                 <hr class="my-2">
                                <div class="row ">
                                    <div class="col">
                                        <div class="row justify-content-between">
                                            <div class="col-4"><p class="mb-1"><b>Subtotal</b></p></div>
                                            <div class="flex-sm-col col-auto"><p class="mb-1"><b><?php echo $total ?></b></p></div>
                                        </div>   
                                        <div class="col"><br>
                                        <button type="submit" name="beli" class="btn  btn-lg btn-block" value="beli"><a href="Cart.php?action=beli">pesan sekarang</button>
                                    </div>                                    
                                </div>
                                <?php 
                                } ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                            </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>