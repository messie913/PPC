<?php
    session_start();
    if(isset($_POST['deleteClient'])){
        include 'conn_DB.php';
        $idClient = $_POST['id_client'];
        $sql = "DELETE FROM client WHERE id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('i',$idClient);
        $stmt ->execute();
        $stmt -> close();
        $conn -> close();
        header("location: ../../_pages/_accounts/listClients.php?error=deletesuccess");
        exit();
    }
?>