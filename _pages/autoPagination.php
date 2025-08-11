<?php
    //create automatique pagination on store page
    include '../_Bend/_sub_forms/conn_DB.php';
    //Get current page number
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    $no_of_records_per_page = 8;
    $offset = ($pageno-1) * $no_of_records_per_page;
    //Number total of number of pages
    $total_pages_sql = "SELECT COUNT(*) FROM produits";
    $result = mysqli_query($conn,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    //Construct  SQL query for pagination
    $sql = "SELECT * FROM produits LIMIT $offset, $no_of_records_per_page";
    $res_data = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($res_data);
?>