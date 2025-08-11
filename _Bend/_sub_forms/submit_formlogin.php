<?php
    ob_start();
    session_start();
    if(isset($_POST["submit_Login"])){
        require 'conn_DB.php';
        //capture form fields 
        $username = $_POST["username"];
        $password = $_POST["password"];
        //Check if username exists
        $sql = "SELECT id,username,u_password,nom,email,telephone FROM client WHERE username= ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("s",$username);
        $stmt -> execute();
        $stmt -> store_result();
        //verifie si utilisateur existe
        if($stmt -> num_rows() > 0){
            $stmt -> bind_result($id,$username_db,$passworddb,$nom,$email,$telephone);
            $stmt -> fetch();
                //Verifier le mot de passe
                if(password_verify($password,$passworddb)){
                    $_SESSION["userId"] = $id;
                    $_SESSION["username"] = $username_db;
                    $_SESSION["password"] = $passworddb;
                    $_SESSION["nom"] = $nom;
                    $_SESSION["email"] = $email;
                    $_SESSION["telephone"] = $telephone;

                    header("Location:../../_pages/_accounts/dashboard.php");
                    exit();
                }else{
                    header("Location:../../_pages/_accounts/login.php?error=wrongpassword");
                    exit();
                    
                }
        }else{
            header("Location:../../_pages/_accounts/login.php?error=usernamedontexist");
            exit();
        }
        $stmt -> close();
        $conn -> close();
    }else{
        header("Location:../../_pages/_accounts/login.php?error=entercredentials");
        exit();
    }
    ob_end_flush();
?>