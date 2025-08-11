<?php
    session_start();
    if(isset($_POST['reset'])){
        unset($_SESSION['panier']);
        header("location: ../../_pages/_DPanier/panier.php");
        exit();
    }
?>