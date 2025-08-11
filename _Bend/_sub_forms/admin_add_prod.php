<?php
    //session_start();
    if(isset($_POST['submit_produit'])){
        require 'conn_DB.php';
        //capture info from form
        $name = $_POST["name"];
        $description = $_POST["desc"];
        $prix = $_POST["prix"];
        $categorie = $_POST["categorie"];
        //verify if fields empty and insert into DB
        if(!empty($name)&& !empty($description)&& !empty($prix)&& !empty($_FILES["images"]["name"][0])){
            //inserer donnee dans BD
            $sql = "INSERT INTO produits(nom,description_p,prix,categorie) VALUES (?,?,?,?)";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("ssds",$name,$description,$prix,$categorie);
            $stmt -> execute();
            $produit_id = $conn -> insert_id;
            //upload images
            $uploadDirec = "uploads/";
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Parapharmacie_du_congo/uploads/";
            // Chemin web pour la BDD
            $uploadWebPath = "uploads/";
            if(!is_dir($uploadDir)){
                mkdir($uploadDir,0777,true);
            }
            foreach($_FILES["images"]["tmp_name"] as $key => $tmp_name){
                $imageName = basename($_FILES["images"]["name"][$key]);//Récupère le nom d'origine du fichier.
                $fileName = time() . "_" . $imageName;
                $imagePath = $uploadDir . $fileName;//Deplace fichier vers disque dur
                $imageUrl  = $uploadWebPath . $fileName;//stocke chemin web
                //$imagePath = $uploadDir.time()."_".$imageName;
                //deplace fichier de dossier tmp garder apres ajout dans form
                if(move_uploaded_file($tmp_name,$imagePath)){
                    //inserer images dans images_produit
                    $sql = "INSERT INTO images_produits(produit_id,image_p) VALUES (?,?)";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> bind_param("is",$produit_id,$imageUrl);
                    $stmt -> execute();
                    $stmt ->close();
                }
            }
            $message = "Produit ajouté avec succès !";
            header("Location:../../_pages/_accounts/adminDash.php?error=addedsuccess");
            exit();
        }else{
            $message = "Veuillez remplir tous les champs et ajouter au moins une image.";
            header("Location:../../_pages/_accounts/adminDash.php?error=noimage");
            exit();
        }
        $conn -> close();
    }
?>
