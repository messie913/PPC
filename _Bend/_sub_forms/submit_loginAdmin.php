<?php
    ob_start();
    session_start();
    if(isset($_POST['submit_adLogin'])){
        require 'conn_DB.php';
        $username = $_POST['username'];
        $password_a = $_POST['password'];
        //$hashpwd = password_hash("0000",PASSWORD_DEFAULT);
       // echo $hashpwd;
        //Check if username exists
        $sql = "SELECT admin_id,nom,email,username,admin_pwd FROM admin_para WHERE username = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("s",$username);
        $stmt -> execute();
        $stmt -> store_result();
        if($stmt -> num_rows() > 0){
            $stmt -> bind_result($id,$nom,$email,$username,$passwordadm);
            $stmt -> fetch();
                if($password_a == $passwordadm || password_verify($password_a,$passwordadm)){
                    $_SESSION['id']=$id;
                    $_SESSION['name']=$nom;
                    $_SESSION['email']=$email;
                    $_SESSION['username']=$email;
                    $_SESSION['password']=$passwordadm;
                    header("Location:../../_pages/_accounts/adminDash.php");
                    exit();
                    }else{
                        echo $_SESSION['password'];
                        header("Location:../../_pages/_accounts/adminLogin.php?error=wrongpassword");
                        exit();
                    }
        }
            else{
                header("Location:../../_pages/_accounts/adminLogin.php?error=usernamedontexist");
                exit();
            }
            $stmt -> close();
            $conn -> close();
    }else{
        header("Location:../../_pages/_accounts/adminLogin.php?error=entercredentials");
        exit();
    }
    ob_end_flush();
?>