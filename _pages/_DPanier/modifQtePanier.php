<?php
    session_start();
    if(isset($_POST['id'],$_POST['quantite'])){
        $id = (int) $_POST['id'];
        $quantite = (int) $_POST['quantite'];
        echo $id;
        echo $quantite;
        if($quantite >0){
            $_SESSION['panier'][$id] = $quantite;
        }
    }
    header('Location: panier.php');
    exit();
?>