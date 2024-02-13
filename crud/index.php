<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<title>
    __cofeshop</title>
<body>
    <nav class="navbar navbar-dark bg-dark">
            <span class="navbar-brand mb-0 h1">DAFTAR PRODUK</span>
        </div>
    </nav>
<div class="container">
    <br>
    <h4><center>DAFTAR PRODUK</center></h4>
<?php

    include "koneksi.php";

    //Cek apakah ada kiriman form dari method post
    if (isset($_GET['id_produk'])) {
        $id_produk=htmlspecialchars($_GET["id_produk"]);

        $sql="delete from produk where id_produk='$id_produk' ";
        $hasil=mysqli_query($koneksi,$sql);

        //Kondisi apakah berhasil atau tidak
            if ($hasil) {
                header("Location:index.php");

            }
            else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";

            }
        }
?>


     <tr class="table-danger">
            <br>
        <thead>
        <tr>
       <table class="my-3 table table-bordered">
            <tr class="table-primary">           
            <th>No</th>
            <th>foto</th>
            <th>id</th>
            <th>nama</th>
            <th>harga</th>
            <th>stok</th>
            <th colspan='2'>Aksi</th>

        </tr>
        </thead>

        <?php
        include "koneksi.php";
        $sql="select * from produk order by id_produk desc";

        $hasil=mysqli_query($koneksi,$sql);
        $no=0;
        while ($data = mysqli_fetch_array($hasil)) {
            $no++;

            ?>
            <tbody>
            <tr>
                <td><?php echo $no;?></td>
                <td><img src="../images/<?php echo $data["foto"]; ?>" alt=""></td>
                <td><?php echo $data["id_produk"];   ?></td>
                <td><?php echo $data["nama"];   ?></td>
                <td><?php echo $data["harga"];   ?></td>
                <td><?php echo $data["stok"];   ?></td>
                <td>
                    <a href="update.php?id_produk=<?php echo htmlspecialchars($data['id_produk']); ?>" class="btn btn-warning" role="button">Update</a>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id_produk=<?php echo $data['id_produk']; ?>" class="btn btn-danger" role="button">Delete</a>
                </td>
            </tr>
            </tbody>
            <?php
        }
        ?>
    </table>
    <a href="create.php" class="btn btn-primary" role="button">Tambah Data</a>
</div>
</body>
</html>
