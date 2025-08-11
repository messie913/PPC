<?php
session_start();
require '../_Bend/_sub_forms/conn_DB.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId']; 
    $productId = $_POST['product_id'];

    // Vérifie si le favori existe déjà
    $sql = "SELECT * FROM favorites WHERE user_id = ? AND produit_id = ?";
    $stmt = $conn -> prepare($sql);
    //$stmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id = ? AND product_id = ?");
    $stmt -> bind_param('ii',$userId, $productId);
    $stmt -> execute();
    $stmt -> store_result();


    if ($stmt->num_rows() > 0) {
        // Le produit est déjà en favori : on le retire
        $stmt->close();
        $sql = "DELETE FROM favorites WHERE user_id = ? AND produit_id = ?";
        $delete = $conn -> prepare($sql);
        $delete -> bind_param("ii",$userId,$productId);
        //$delete = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND product_id = ?");
        $delete->execute();
        echo 'removed';
    } else {
        // Le produit n’est pas encore favori : on l’ajoute
        $stmt->close();
        $sql = "INSERT INTO favorites(user_id, produit_id) VALUES (?, ?)";
        $insert = $conn -> prepare($sql);
        $insert -> bind_param("ii",$userId,$productId);
        //$insert = $pdo->prepare("INSERT INTO favorites (user_id, product_id) VALUES (?, ?)");
        $insert->execute();
        echo 'added';
    }
}else{
    header("Location: store.php?error=nouser");
    exit();
}