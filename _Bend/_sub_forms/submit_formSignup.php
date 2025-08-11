<?php
    //Signup submit Form
    if(isset($_POST['submit_Signup'])){
        require 'conn_DB.php';
        //Retrieve form fields
        $name = trim($_POST['name']);
        $telephone = trim($_POST['telephone']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $password2 = trim($_POST['password2']);

        //verify username and passwords equal
        if(empty($name)){
            header("Location:../../_pages/_accounts/signup.php?error=noname");
            exit();
        }
        if(empty($telephone)){
            header("Location:../../_pages/_accounts/signup.php?error=nophone");
            exit();
        }
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location:../../_pages/_accounts/signup.php?error=novalidemail");
            exit();
        }
        if (!preg_match("/^[a-zA-Z0-9]+$/", $username) && !filter_var($username, FILTER_VALIDATE_EMAIL)) {
            header("Location:../../_pages/_accounts/signup.php?error=invalidusername");
            exit();
        }
        if($password != $password2){
            header("Location:../../_pages/_accounts/signup.php?error=passworddontmatch");
            exit();
        }
        //Verify if username is already taken
        $sql = "SELECT username FROM client WHERE username =?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("s",$username);
        $stmt -> execute();
        $stmt -> store_result();

        if($stmt -> num_rows()>0){
            header("Location:../../_pages/_accounts/signup.php?error=usernamealreadytaken");
            exit();
        }
        $stmt -> close();
        //if username free insert into db hash password
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO client(username,u_password,nom,email,telephone) VALUES (?,?,?,?,?)";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("sssss",$username,$hash_password,$name,$email,$telephone);
        $stmt -> execute();

        if($stmt){
            header("Location:../../_pages/msg/signedThanks_form.php");
            exit();
        }else{
            header("Location:../../_pages/_accounts/signup.php?error=sqlerror");
            exit();
        }
        $stmt -> close();
        $conn -> close();
        exit();



    } else{
        header("Location:../../_pages/_accounts/signup.php?error=fillthefields");
        exit();
    }
   
?>
