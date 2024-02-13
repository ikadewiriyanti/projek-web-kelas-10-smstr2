<!DOCTYPE html>
<html>
<head>
    <title>Form daftar produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <?php

    //Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id_peserta
    if (isset($_GET['id_produk'])) {
        $id_produk=input($_GET["id_produk"]);

        $sql="select * from produk where id_produk=$id_produk";
        $hasil=mysqli_query($koneksi,$sql);
        $data = mysqli_fetch_assoc($hasil);


    }

    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_produk=htmlspecialchars($_POST["id_produk"]);
        $foto=input($_POST["foto"]);
        $id_produk=input($_POST["id_produk"]);
        $nama=input($_POST["nama"]);
        $harga=input($_POST["harga"]);
        $stok=input($_POST["stok"]);

        //Query update data pada tabel anggota
        $sql="update produk set
			foto='$foto',
			id_produk='$id_produk',
			nama='$nama',
			harga='$harga',
			stok='$stok'
			where id_produk=$id_produk";

        //Mengeksekusi atau menjalankan query diatas
        $hasil=mysqli_query($koneksi,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index.php");
        }
        else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";

        }

    }

    ?>
    <h2>Update produk</h2>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
            <label>foto:</label>
            <input type="file" name="foto" class="form-control" placeholder="Masukan foto" required />

        </div>
        <div class="form-group">
            <label>id:</label>
            <input type="number" name="id_produk" class="form-control" placeholder="Masukan id" required/>
        </div>
        <div class="form-group">
            <label>nama :</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan nama" required/>
        </div>
        <div class="form-group">
            <label>harga:</label>
            <input type="text" name="harga" class="form-control" placeholder="Masukan harga" required/>
        </div>
        <div class="form-group">
            <label>stok:</label>
            <input type="text" name="stok" class="form-control" placeholder="Masukan stok" required/>
        </div>

        <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>