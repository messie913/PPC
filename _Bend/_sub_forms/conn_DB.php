<?php
    //var for db
    $host = "localhost";
    $dbUsername = "sysadmin";
    $dbPassword = "BRUnel08";
    $dbName = "para_DB";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Active le mode exception
    //Create DB connexion
    try{
        $conn = new mysqli($host,$dbUsername,$dbPassword,$dbName);
    }
    catch(Exception $e){
        die("❌ Erreur acces BD: " .$e->getMessage());
    }   
?>