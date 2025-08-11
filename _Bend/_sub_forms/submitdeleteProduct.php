<?php
    session_start();
    if(isset($_POST['deleteProduct'])){
        include 'conn_DB.php';
        $id_prod = $_POST['id_produit'];
        //Verifier si le produit est utiliser dans la table foavorites
        $checkStmt = $conn -> prepare("SELECT COUNT(*) FROM favorites WHERE produit_id=?");
        $checkStmt -> bind_param('i',$id_prod);
        $checkStmt -> execute();
        $checkStmt -> bind_result($count);
        $checkStmt -> fetch();
        $checkStmt -> close();
        //Afficher message si present
        if($count >0){
            //echo "⚠️ Impossible de supprimer ce produit : il est encore présent dans les favoris.";
            header("location: ../../_pages/_accounts/listProducts.php?error=productfav");
            exit();
        }
        else{
            $sql = "DELETE FROM produits WHERE id_produit = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param('i',$id_prod);
            $stmt ->execute();
            $stmt -> close();
            $conn -> close();
            header("location: ../../_pages/_accounts/listProducts.php?error=deletesuccess");
            exit();
        }
        
    }
?>