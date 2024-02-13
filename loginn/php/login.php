<?php 
session_start();

if(isset($_POST['username']) && 
   isset($_POST['password'])){

    include "../db_conn.php";

    $usename = $_POST['username'];
    $password = $_POST['password'];

    $data = "username=".$username."password=".$password;
    
    if(empty($username)){
    	$em = "username is required";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else if(empty($password)){
    	$em = "password is required";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else {

    	$sql = "SELECT * FROM users WHERE username = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute([$username]);

      if($stmt->rowCount() == 1){
          $user = $stmt->fetch();

          $username =  $user['username'];
          $password =  $user['password'];
          $id =  $user['id'];
          $pp =  $user['pp'];

          if($username === $username){
             if(password_verify($password, $password)){
                 $_SESSION['id'] = $id;
                 $_SESSION['pp'] = $pp;

                 header("Location: ../home.php");
                 exit;
             }else {
               $em = "Incorect username or password";
               header("Location: ../login.php?error=$em&$data");
               exit;
            }

          }else {
            $em = "Incorect username or password";
            header("Location: ../login.php?error=$em&$data");
            exit;
         }

      }else {
         $em = "Incorect username or password";
         header("Location: ../login.php?error=$em&$data");
         exit;
      }
    }


}else {
	header("Location: ../login.php?error=error");
	exit;
}
