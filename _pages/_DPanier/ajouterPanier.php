<?php
    session_start();
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier']=[];
    }
    $id_produit = $_GET['id'];
    //Verify product already exist
   
        if(isset($_SESSION['panier'][$id_produit])){
            $_SESSION['panier'][$id_produit]++;
        }else{
            $_SESSION['panier'][$id_produit]=1;
        }
    
    header('Location: ../store.php?error=successadd');
    exit();
?>