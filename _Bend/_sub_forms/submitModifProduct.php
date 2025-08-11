<?php
    session_start();
    if(isset($_POST['id_produit'])){
        include 'conn_DB.php';
        $id= $_POST['id_produit'];
        //var_dump($_POST);
        //exit();
        $nomProduit = $_POST['name'];
        $descriptionPro = $_POST['desc'];
        $prixProduit = $_POST['prix'];
        $categorieProduit =$_POST['categorie'];
        //request update products
        $sql = "UPDATE produits SET nom= ?, description_p= ?, prix= ?, categorie = ? WHERE id_produit= ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('ssdsi',$nomProduit,$descriptionPro,$prixProduit,$categorieProduit,$id);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("location:../../_pages/_accounts/listProducts.php?error=updatesuccess");
            exit();
        }    
    }
?>