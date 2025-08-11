<?php
    session_start();
    if(isset($_GET["id"])){
        require 'conn_DB.php';
        //retrieve userid
        $id = (int) $_GET["id"];

        //delete user
        $sql = "DELETE FROM client WHERE id= ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i",$id);
        $stmt -> execute();
        $stmt -> close();
        //Reinit session
        session_unset();
        session_destroy();

        header("Location:../../_pages/msg/accDeleted.php");
        exit();
    }else{
        echo "ID non valide.";
    }
?>
