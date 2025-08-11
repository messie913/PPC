<?php
    session_start();
    if(isset($_POST['username'])){
        include 'conn_DB.php';
        $name = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        //Verify username 
        if (!preg_match("/^[a-zA-Z0-9]+$/", $username) && !filter_var($username, FILTER_VALIDATE_EMAIL)) {
            header("Location:../../_pages/_accounts/addAdmin.php?error=invalidusername");
            exit();
        }
        //Verify password equals
        if($password != $password2){
            header("Location:../../_pages/_accounts/addAdmin.php?error=passworddontmatch");
            exit();
        }
        //Hash password
        $hashpassword = password_hash($password,PASSWORD_DEFAULT);
        //Veriy if username is free
        $sql = "SELECT nom,email,username,admin_pwd,telephone FROM admin_para WHERE username = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("s",$username);
        $stmt -> execute();
        $res = $stmt -> get_result();
        if($res -> num_rows >0){
            header("Location:../../_pages/_accounts/addAdmin.php?error=usernametaken");
            exit();
            $stmt -> close();
        }
        else{
            //Insert admin data into DB
            $sql_insert = "INSERT INTO admin_para(nom,email,username,admin_pwd,telephone) VALUES (?,?,?,?,?)";
            $stmt_insert = $conn -> prepare($sql_insert);
            $stmt_insert -> bind_param("sssss",$name,$email,$username,$hashpassword,$telephone);
            $stmt_insert -> execute();
            header("Location:../../_pages/_accounts/addAdmin.php?error=addsucces");
            exit();
            $stmt_insert -> close();
        }
        $conn -> close();
        
    }else{
        header("Location:../../_pages/_accounts/addAdmin.php?error=fillthefields");
        exit();
    }
?>
