<?php
    //Script to show data on product pop up
    require 'conn_DB.php'; 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        //show products from DB
        $sql = "SELECT * FROM produits WHERE id_produit=?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('i',$id);
        $stmt -> execute();
        $res= $stmt -> get_result();
        $produit = $res -> fetch_assoc();

        //Show images from DB
        $sql2 = "SELECT image_p FROM images_produits WHERE produit_id =?";
        $stmt2 = $conn -> prepare($sql2);
        $stmt2 -> bind_param('i',$id);
        $stmt2 -> execute();
        $res2= $stmt2 -> get_result();
        $images = $res2 -> fetch_array(MYSQLI_NUM);

        /*$images = [];
        while ($row = $res2->fetch_assoc()) {
            $images[] = $row['image_p'];
        }

        if ($produit) {
            echo json_encode([
                'nom' => $produit['nom'],
                'description' => $produit['description_p'],
                'prix' => number_format($produit['prix'], 2, ',', ' '),
                'image' => $images
            ]);
        }*/

        if ($produit) {
            echo json_encode([
                'nom' => $produit['nom'],
                'description' => $produit['description_p'],
                'prix' => number_format($produit['prix'], 2, ',', ' '),
                'image' => $images[0] ?? ''
            ]);
        }
    }
?>