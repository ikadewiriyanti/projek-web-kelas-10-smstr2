<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Enkripsi password
    

    // Simpan data pengguna ke database (gantilah dengan pengaturan koneksi dan query sesuai kebutuhan Anda)
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "cofeshop";

    $koneksi = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    $query = "INSERT INTO users (username, email, password, ) VALUES ('$username', '$email', '$password',)";

    if ($conn->query($query) === TRUE) {
        echo "Registrasi berhasil!";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Registrasi</title>
	<link rel="stylesheet" type="text/css" href="../css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="../images/bglogin.png" >
	<div class="container">
		<div class="img">
			
		</div>
		<div class="login-content">

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
			//Cek apakah ada kiriman form dari method post
			if ($_SERVER["REQUEST_METHOD"] == "POST") {

				$username=input($_POST["username"]);
                $email=input($_POST["email"]);
				$password=input($_POST["password"]);

				//Query input menginput data kedalam tabel anggota
				$sql="insert into users (username,email,password) values
				('$username','$email','$password')";

				//Mengeksekusi/menjalankan query diatas
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
    
			<form action="index.php">
				<img src="../images/pp.svg">
				<h2 class="title">Registrasi</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
           		   		<input type="text" class="input">
           		   </div>
           		</div>
                   <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-envelope"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>email</h5>
           		   		<input type="text" class="input">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input">
            	   </div>
            	</div>
            	<a href="#">Forgot Password?</a>
            	<input type="submit" class="btn" value="Login">
				<a href="login.php">Login?</a>

            </form>
        </div>
    </div>
    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
