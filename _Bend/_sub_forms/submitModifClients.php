<?php
    session_start();
    if(isset($_POST['update_client'])){
        include 'conn_DB.php';
        $id = $_POST['id_client'];
        $nom = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2= $_POST['password2'];

        if($password != $password2 ){
            header("Location:../../_pages/_accounts/modifClients.php?error=passworddontmatch");
            exit();
        }
        //exit();
        $hashpassword = password_hash($password,PASSWORD_DEFAULT);
        $sql = "UPDATE client SET username=? , u_password=?, nom=?, email=?, telephone=? WHERE id=?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("sssssi",$username,$hashpassword,$nom,$email,$telephone,$id);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("location:../../_pages/_accounts/listClients.php?error=updatesuccess");
            exit();
        }  
    }
?>