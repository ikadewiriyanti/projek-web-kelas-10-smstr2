<?php
session_start();

// Fungsi untuk menambahkan produk ke keranjang
function tambahProdukKeKeranjang($produkId, $produkNama, $produkHarga, $jumlah) {
    // Jika keranjang masih kosong, inisialisasi sebagai array kosong
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = array();
    }

    // Jika produk sudah ada di keranjang, tambahkan jumlahnya
    if (array_key_exists($produkId, $_SESSION['keranjang'])) {
        $_SESSION['keranjang'][$produkId]['jumlah'] += $jumlah;
    } else {
        // Jika produk belum ada di keranjang, tambahkan ke keranjang
        $_SESSION['keranjang'][$produkId] = array(
            'nama' => $produkNama,
            'harga' => $produkHarga,
            'jumlah' => $jumlah
        );
    }
}

// Form pengisian data produk
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produkId = $_POST["produk_id"];
    $produkNama = $_POST["produk_nama"];
    $produkHarga = $_POST["produk_harga"];
    $jumlah = $_POST["jumlah"];

    tambahProdukKeKeranjang($produkId, $produkNama, $produkHarga, $jumlah);

    echo "Produk berhasil ditambahkan ke keranjang!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Tambah Produk ke Keranjang</title>
</head>
<body>
    <h2>Tambah Produk ke Keranjang</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Produk ID: <input type="text" name="produk_id"><br>
        Nama Produk: <input type="text" name="produk_nama"><br>
        Harga Produk: <input type="text" name="produk_harga"><br>
        Jumlah: <input type="number" name="jumlah"><br>
        <input type="submit" value="Tambah ke Keranjang">
    </form>

    <h2>Keranjang Produk</h2>
    <?php
    if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
        echo "<ul>";
        foreach ($_SESSION['keranjang'] as $produkId => $produk) {
            echo "<li>{$produk['nama']} - {$produk['harga']} - Jumlah: {$produk['jumlah']}</li>";
        }
        echo "</ul>";
    } else {
        echo "Keranjang kosong.";
    }
    ?>
</body>
</html>
