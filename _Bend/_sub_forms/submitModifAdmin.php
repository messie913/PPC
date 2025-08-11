<?php
    session_start();
    if(isset($_POST['telephone'])){
        include 'conn_DB.php';
        $id = $_POST['id_admin'];
        $nom = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2= $_POST['password2'];
       
        if($password != $password2 ){
            header("Location:../../_pages/_accounts/modifadmin.php?error=passworddontmatch");
            exit();
        }
        //exit();
        $hashpassword = password_hash($password,PASSWORD_DEFAULT);
        $sql = "UPDATE admin_para SET nom=? , email=?, username=?, admin_pwd=?, telephone=? WHERE admin_id=?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("sssssi",$nom,$email,$username,$hashpassword,$telephone,$id);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("location:../../_pages/_accounts/deleteadmin.php?error=updatesuccess");
            exit();
        }  
        /*$stmt -> execute();
        $stmt -> close();
        $stmt -> close();
        header("location:../../_pages/_accounts/deleteadmin.php?error=updatesuccess");
        exit();*/

    }
?>