<?php
    session_start(); 
    if(isset($_POST['deleteAdmin'])){
        include 'conn_DB.php';
        $id_ad = $_POST['id_admin'];
        $sql = "DELETE FROM admin_para WHERE admin_id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i",$id_ad);
        $stmt -> execute();
        $stmt -> close();
        header("Location: ../../_pages/_accounts/deleteadmin.php?error=accountdeleted");
        exit();
    }
       
?>
