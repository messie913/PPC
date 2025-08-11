<?php
session_start();

if (isset($_POST["submit_update"])) {
    require 'conn_DB.php';

    // Retrieve form fields
    $id = $_SESSION["userId"];
    $name = trim($_POST['name']);
    $telephone = trim($_POST['telephone']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    // Verify email validity
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../../_pages/_accounts/updateAcc.php?error=novalidemail");
        exit();
    }

    // Verify username format
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        header("Location: ../../_pages/_accounts/updateAcc.php?error=invalidusername");
        exit();
    }

    // Verify password match
    if ($password !== $password2) {
        header("Location: ../../_pages/_accounts/updateAcc.php?error=passworddontmatch");
        exit();
    }

    // Verify if username is already taken
    $sql = "SELECT username FROM client WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    /*if ($stmt->num_rows > 0) { 
        $stmt->close();
        header("Location: ../../_pages/_accounts/updateAcc.php?error=usernametaken");
        exit();
    }
    $stmt->close();*/

    // Hash password
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    // Update account
    $sql = "UPDATE client SET username = ?, u_password = ?, nom = ?, email = ?, telephone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $username, $hash_password, $name, $email, $telephone, $id);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../../_pages/_accounts/dashboard.php?error=accountupdated");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: ../../_pages/_accounts/updateAcc.php?error=updatefailed");
        exit();
    }
} else {
    header("Location: ../../_pages/_accounts/updateAcc.php?error=enterinfos");
    exit();
}
?>
