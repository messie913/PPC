<?php
    ini_set('session.gc_maxlifetime', 900);
    session_start();
    //Logout after 5 minutes
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        // request 15 minates ago
        session_unset();     // unset $_SESSION variable for the runtime
        session_destroy();   // destroy session data completely
        header("Location: ../index.php?error=logoutinactive");
        exit(); 
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time
    //file to filter data into page store.php
    include '../_Bend/_sub_forms/conn_DB.php';
    include '../_pages/_accounts/paginationProduit.php';
    //$categorie = $_POST["categorie"];
    $sql = 'SELECT id_produit, nom, description_p, prix FROM produits WHERE categorie =? ORDER BY id_produit DESC'; 
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("s",$categorie);
    $stmt -> execute();
    $res = $stmt->get_result();
    $produits = $res->fetch_all(MYSQLI_NUM); // ou MYSQLI_ASSOC si tu préfères

    //var_dump($produits);
    //header("location: ../../_pages/store.php");
    //exit();
    // Récupération et sécurisation des filtres
    $category   = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
    $min_price  = isset($_GET['min-price']) ? (float)$_GET['min-price'] : 0;
    $max_price  = isset($_GET['max-price']) ? (float)$_GET['max-price'] : 0;
    $brand = isset($_GET['brand']) ? $conn->real_escape_string($_GET['brand']) : '';
    $groupSort = isset($_GET['inputGroupSort']) ? $conn->real_escape_string($_GET['inputGroupSort']) : '';
    /*echo $category;
    echo $min_price;
    echo $max_price;
    echo $groupSort;*/

    // Construction de la requête SQL
    $sql = "SELECT * FROM produits WHERE 1=1";
    //$sql ="SELECT * FROM `produits` WHERE 1 ORDER BY prix DESC;";
    $conditions = [];
    $params = [];
    $order =[];
    $types = '';

    if (!empty($category)) {
        $conditions[] = "categorie = ?";
        $params[] = $category;
        $types .= 's';
    }
    /*if(!empty($groupSort =='price-dec')){
        $sql ="SELECT * FROM `produits` WHERE 1 ORDER BY prix DESC";
        //$order[] = "ORDER BY prix DESC";
        $params[] = $groupSort;
        $types .='s';
    }
    if(!empty($groupSort =='price-cros')){
        $sql ="SELECT * FROM `produits` WHERE 1 ORDER BY prix ASC;";
        //$order[] = "ORDER BY prix ASC";
        $params[] = $groupSort;
        $types .='s';
    }*/
    if ($min_price > 0) {
        $conditions[] = "prix >= ?";
        $params[] = $min_price;
        $types .= 'd';
    }
    if (!empty($brand)) {
        $conditions[] = "categorie = ?";
        $params[] = $category;
        $types .= 's';
    }
    if ($max_price > 0) {
        $conditions[] = "prix <= ?";
        $params[] = $max_price;
        $types .= 'd';
    }
    if($max_price < $min_price){
        //echo "Prix maximum doit est inferieur au prix minimum ";
        header('Location: store.php?error=invalidmaxprice');
        exit();
    }

    if (!empty($conditions)) {
        $sql .= ' AND ' . implode(' AND ', $conditions);
    }

    if ($groupSort === 'price-cros') {
        $sql .= " ORDER BY prix ASC";
    } elseif ($groupSort === 'price-dec') {
        $sql .= " ORDER BY prix DESC";
    }
    if ($groupSort === 'name-asc') {
        $sql .= " ORDER BY nom ASC";
    } elseif ($groupSort === 'name-desc') {
        $sql .= " ORDER BY nom DESC";
    }

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $prod_fils = $result ->fetch_all(MYSQLI_NUM);
    if(empty($prod_fils)){
       // $prod_id = 0;
       //echo "Tableau vide";
       $prod_id = 0;
    }else{
        $prod_id = $prod_fils[0];
    }
   // $prod_id = $prod_fils[0];
    //print_r($prod_fils);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique - PPC</title>
     <!--Style pages-->
     <link rel="stylesheet" href="../../_styles/style.css">
    <!--Style for index page--> 
    <link rel="stylesheet" href="../_styles/index.css">
    <link rel="stylesheet" href="../_styles/normalize.css">
    <!--<link rel="stylesheet" href="../_styles/store.css">-->
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="../../_BS_CSS/css/bootstrap.min.css">
    <!--Bootstrap CSS-->
    <script src="../../_BS_JS/js/bootstrap.bundle.min.js" defer></script>
     <!--Favicon--> 
     <link rel="icon" type="image/png" href="../../_favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../_favicon/favicon.svg" />
    <link rel="shortcut icon" href="../../_favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../_favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <!--Fonts management-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Questrial&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <style>
            /*Add font style here because wasnt working on css files*/
            header {
            font-family: "Questrial", sans-serif;
            font-size: 16px;
            }
            main, footer{
                font-family: "Poppins", sans-serif;
            }
            h1{
                font-family: "Questrial",sans-serif;
            }
            .navbar-toggler {
                border-radius: 50%;
                background-color: transparent;
                color: white;
                border: none;
            }
            .modal{
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                justify-content: center;
                align-items: center;
            }
            .modal-content {
                background: white;
                padding: 20px;
                border-radius: 10px;
                width: 70%;
                max-width: 100%;               
                position: relative;
               align-items: center;
            }

            .modal-content img {
                width: 25%;
                height: 20%;
                border-radius: 10px;
            }
            .close {
                position: absolute;
                top: 10px;
                right: 20px;
                font-size: 24px;
                cursor: pointer;
                color: red;
            }
            .basket{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            @media screen and (max-width:600px) {
                .modal-content img {
                    width: 80%;
                    height: 100px;
                    height: auto;
                    border-radius: 10px;
                }
                .modal{
                    top: -100px;
                }
                .modal-content {
                    
                    width: 80%;
                }
            }
        </style>
</head>
<body>
    <header class="mb-5">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!--Btn for mobile menu-->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!--Show brand on menu-->
                <a href="../../index.php" class="navbar-brand">
                    <img src="../../_images/Logo_PDC.jpg" alt="Logo Pharmacie du Congo" class="logo ">
                </a>
                <!--Account menu for mobile-->
                <div class="d-block d-md-none">
                    <div class="d-inline-flex flex-row-reverse">
                        <a href="../../_pages/_DPanier/panier.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="35" fill="currentColor" class="bi bi-basket3-fill" viewBox="0 0 16 16">
                                <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.468 15.426.943 9h14.114l-1.525 6.426a.75.75 0 0 1-.729.574H3.197a.75.75 0 0 1-.73-.574z"/>
                            </svg>  
                            <span class="position-absolute top-2000 start-1 translate-middle badge rounded-pill bg-danger">
                                                    <?php
                                                        if(isset($_SESSION['panier'])){
                                                            echo count($_SESSION['panier']);
                                                        }
                                                        else{
                                                            echo 0;
                                                        }
                                                    ?>
                                                    <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>    
                    </div>   
                </div>
                <!--Menu for computer--> 
                <div class="collapse navbar-collapse menuComputer" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-lg-1">
                        <li class="nav-item mx-lg-4">
                            <a href="../../index.php" class="nav-link">Accueil</a>
                        </li>
                        <li class="nav-item mx-lg-4">
                            <a href="../../_pages/about.php" class="nav-link">À propos</a>
                        </li>
                        <li class="nav-item mx-lg-4">
                            <a href="../../_pages/store.php" class="nav-link active">Boutique</a>
                        </li>
                        <li class="nav-item mx-lg-4">
                            <a href="../../_pages/contact.php" class="nav-link">Contact</a>
                        </li>
                        <!--Login btn for mobile-->
                        <div class="d-flex d-md-none login  gap-5 justify-content-between mt-3">
                            <!--Verify if user is logged in for mobile-->    
                            <?php if(isset($_SESSION['userId']) || isset($_SESSION['id'])): ?>
                                <!--Dropdown menu-->
                                <div class="dropdown">
                                    <a data-bs-toggle="dropdown"  role="button" aria-expanded="false" class="dropdown-toggle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="dropdown-item text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-bounding-box ml-2" viewBox="0 0 16 16">
                                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
                                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                            </svg>
                                            Bienvenue <?php echo $_SESSION['username'] ?></a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-success" href="../../_pages/_accounts/dashboard.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                    <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                    <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                                </svg>    
                                            Tableau de bord</a>
                                        </li>
                                        <li><a class="dropdown-item text-success" href="#">Historique des commandes</a></li>
                                        <li class="dropdown-item">
                                            <form action="script_logout.php" method="post">
                                                <button class="btn btn-primary" type="submit" >
                                                    Fermer session
                                                </button>
                                            </form>                
                                        </li>
                                    </ul>
                                </div>
                                <div class="basket">
                                    <!--<a href="../../_pages/_DPanier/panier.php">
                                        <div class="d-inline-flex flex-row-reverse">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-cart mx-4" viewBox="0 0 16 16">
                                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                            <span class="position-absolute top-2000 start-1 translate-middle badge rounded-pill bg-danger">
                                                <?php
                                                    if(isset($_SESSION['panier'])){
                                                        echo count($_SESSION['panier']);
                                                    }
                                                    else{
                                                        echo 0;
                                                    }
                                                ?>
                                                    <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </div>  
                                    </a>-->
                                </div>  
                            <!--else-->
                            <?php else: ?>
                                <div class="basket">
                                    <!--<a href="../_pages/_DPanier/panier.php">
                                        <div class="d-inline-flex flex-row-reverse">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-cart mx-4" viewBox="0 0 16 16">
                                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                            <span class="position-absolute top-2000 start-1 translate-middle badge rounded-pill bg-danger">
                                                    <?php
                                                    if(isset($_SESSION['panier'])){
                                                        echo count($_SESSION['panier']);
                                                    }
                                                    else{
                                                        echo 0;
                                                    }
                                                    ?>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                        </div>  
                                    </a>-->
                                    <a href="_accounts/login.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                        </svg>
                                   
                                    </a>
                                </div>
                            <?php endif; ?>  
                        </div>
                    </ul>
                    <div class="account d-none d-md-flex">
                        <form action="#" class="d-none d-xxl-flex  formu mx-lg-5" role="search">
                            <input type="search" class="form-control me-2" placeholder="Rechercher..." aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button>
                        </form>

                         <!--Verify if user is logged in-->    
                         <?php if(isset($_SESSION['userId'])): ?>
                            <!--Dropdown menu-->
                            <div class="dropdown">
                                <!--<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Centered dropdown
                                </button>-->
                                <a data-bs-toggle="dropdown"  role="button" aria-expanded="false" class="dropdown-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                    </svg>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="dropdown-item text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-bounding-box ml-2" viewBox="0 0 16 16">
                                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                        </svg>
                                        Bienvenue <?php echo $_SESSION['username'] ?></a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-success" href="_accounts/dashboard.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                            </svg>    
                                        Tableau de bord</a>
                                    </li>
                                    <li><a class="dropdown-item text-success" href="#">Historique des commandes</a></li>
                                    <li class="dropdown-item">
                                        <form action="../../_Bend/_sub_forms/script_logout.php" method="post">
                                            <button class="btn btn-primary" type="submit" >
                                                Fermer session
                                            </button>
                                        </form>                
                                      </li>
                                </ul>
                            </div>
                            <div class="basket">
                                <a href="../../_pages/_DPanier/panier.php">
                                    <div class="d-inline-flex flex-row-reverse">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-cart mx-4" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                        </svg>
                                        <span class="position-absolute top-2000 start-1 translate-middle badge rounded-pill bg-danger">
                                            <?php
                                                if(isset($_SESSION['panier'])){
                                                    echo count($_SESSION['panier']);
                                                }
                                                else{
                                                    echo 0;
                                                }
                                            ?>
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                    </div>  
                                </a>
                            </div>  
                        <!--else-->
                        <?php else: ?>
                            <div class="basket">
                                <a href="../_pages/_DPanier/panier.php">
                                    <div class="d-inline-flex flex-row-reverse">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-cart mx-4" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                        </svg>
                                        <span class="position-absolute top-2000 start-1 translate-middle badge rounded-pill bg-danger">
                                                <?php
                                                if(isset($_SESSION['panier'])){
                                                    echo count($_SESSION['panier']);
                                                }
                                                else{
                                                    echo 0;
                                                }
                                                ?>
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                    </div>  
                                </a>
                                <a href="_accounts/login.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                                </a>
                            </div>
                        <?php endif; ?>  

                        <!--<div class="basket">
                            <a href="../_pages/_DPanier/panier.php">
                                <div class="d-inline-flex flex-row-reverse">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-cart mx-4" viewBox="0 0 16 16">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                    </svg>
                                    <span class="position-absolute top-2000 start-1 translate-middle badge rounded-pill bg-danger">
                                        <?php
                                            if(isset($_SESSION['panier'])){
                                                echo count($_SESSION['panier']);
                                            }
                                            else{
                                                echo 0;
                                            }
                                        ?>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                </div>  
                            </a>
                            <a href="_accounts/login.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                            </a>
                        </div>-->
                    </div>    
                </div>
            </div>
        </nav>
    </header>
    <main class="container-fluid">
            <!--SECTION VENTES-->
        <section class="bestventes">
            <h1 class="display-5 py-3 text-success text-center">Explorez nos produits</h1>
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == 'addsuccess'){
                        echo "<p class='error text-center'>Commande enregistré avec succès !</p>";
                        echo "
                        <script>
                            //Rafraichir page et nettoyer URL
                            setTimeout( function(){
                            //Nettoyer URL sans recharger la page
                            window.history.replaceState(null,null,window.location.pathname);
                            //Rafraichir la page apres nettoyage
                            location.reload();   
                            },5000 );
                        </script>";
                    }
                }
            ?>
            <p class="text-center">Découvrez notre large gamme de produits de parapharmacie de qualité supérieure, livrés directement chez vous.</p>
            <!--Offcanvas-->
            <a class="btn btn-outline-success mx-lg-5 h4 mb-4" data-bs-toggle="offcanvas" href="#offcanvasFiltre" role="button" aria-controls="offcanvasExample">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                </svg> Filtres
            </a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFiltre" aria-labelledby="offcanvasFiltreLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasFiltreLabel">Filtrer les produits</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="filterbycat.php" method="get" id="product-filter">
                        <!--Trier-->
                        <div class="input-group mb-5">
                           <label for="inputGroupSort" class="input-group-text">Trier par :</label>
                           <select name="inputGroupSort" id="inputGroupSort" class="form-select">
                                <option value="">-- Trier par prix --</option>
                                <option value="price-dec">Prix: Ordre décroissant</option>
                                <option value="price-cros">Prix : Ordre croissant</option>
                                <option value="name-asc">Nom croissant : (A-Z)</option>
                                <option value="name-desc">Nom décroissant : (Z-A)</option>
                           </select>
                        </div>
                        <!--Categorie filtre-->
                        <label class="form-label" for="category">Catégorie :</label>
                        <select class="form-select mb-5" name="category" id="category">
                            <option selected value="">-- Trier par catégorie --</option>
                            <option value="medisansordo">Médicaments sans ordonnance</option>
                            <option value="hygienesante">Hygiène & santé</option>
                            <option value="maternitebebe">Maternité & bébé</option>
                            <option value="nutritionmincesport">Nutrition, minceur & Sport</option>
                            <option value="veterinaire">Vétérinaire</option>
                            <option value="produitscongolais">Produits congolais</option>
                        </select>
                        <!--Prix-->
                        <label class="form-label" for="min-price">Prix minimum :</label>
                        <input type="number" class="form-control-sm mb-3" name="min-price" id="min-price" placeholder="0">
                        <label class="form-label" for="min-price">Prix maximum :</label>
                        <input type="number" class="form-control-sm mb-5" name="max-price" id="max-price" placeholder="100">
                        <hr>
                        <div class="d-md-flex justify-content-md-end">
                            <button class="btn btn-success mt-5" type="submit">Voir les résultats</button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="mx-lg-5">Affinez votre recherche en sélectionnant une catégorie de produits : soins visage, compléments alimentaires, hygiène, bébé, et bien plus. Trouvez rapidement ce dont vous avez besoin :</p>
            <form action="filterbycateg.php" method="post" class="d-flex flex-row mx-lg-5 ">
                <div class="input-group ">
                    <span class="input-group-text ">Catégorie :</span>
                    <select class="form-select" aria-label="products category" name="categorie">
                        <option selected>Sélectionner la catégorie ...</option>
                        <option value="medisansordo">Médicaments sans ordonnance</option>
                        <option value="hygienesante">Hygiène & santé</option>
                        <option value="maternitebebe">Maternité & bébé</option>
                        <option value="nutritionmincesport">Nutrition, minceur & Sport</option>
                        <option value="veterinaire">Vétérinaire</option>
                        <option value="produitscongolais">Produits congolais</option>
                    </select>
                </div>
                   
                <button type="submit" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                </button>
            </form>
            <p class="mx-5 my-3">Vous avez sélectionné la catégorie : <?= $category; ?></p>

            <div class="containProduct mb-5">
                <!--Ajout dynamique-->              
                    <?php foreach($prod_fils as $prod_fil): ?>
                        <div class="product border card" >
                                    <?php
                                        include '../_Bend/_sub_forms/conn_DB.php';
                                        include '../_Bend/_sub_forms/admin_add_prod.php';
                                        $prod_id = $prod_fil[0];
                                        $sql = "SELECT image_p FROM images_produits WHERE produit_id = ?";
                                        $stmt = $conn -> prepare($sql);
                                        $stmt -> bind_param("i",$prod_fil[0]);
                                        $stmt -> execute();
                                        $res = $stmt -> get_result();
                                        $images = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
                                        /*$images = $res -> fetch_assoc();
                                        //var_dump($images);
                                        $images =[];
                                        if($res){
                                            $images = $res -> fetch_all(MYSQLI_NUM);
                                        }*/
                                        //print_r($images);
                                    ?>
                                    <?php if(!empty($images)): ?>
                                        <img onclick="showProduct(<?php echo $prod_fil[0]; ?>)" src="../Parapharmacie_du_congo/<?php echo $images[0]['image_p']; ?>" alt="Image principale" class="card-img-top image_card">
                                    <?php else: ?>
                                        <img src="../Parapharmacie_du_congo/uploads/1743777256_still-life-skincare-products-min.jpg" alt="Parfum PDC" class="card-img-top image_card">
                                    <?php endif; ?>
                                    <!--<img src="../_images/free-photo-beauty-product-bottle-mockup-image-with-background.jpg" alt="Parfum PDC" class="card-img-top image_card">-->
                                    <div class="card-body">
                                        <h5 class="h5 card-title"><strong><?php echo htmlspecialchars($prod_fil[1]); ?></strong></h5>
                                        <button class="btn btn-outline-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#ProductModal<?= $prod_id ?>">
                                            + Détails sur ce produit
                                        </button>
                                        <h6 class="card-text h6"><b>Code catégorie : <?= htmlspecialchars($prod_fil[5]); ?></b></h6>
                                        <p class="card-text desc"><?php echo nl2br(htmlspecialchars($prod_fil[2]));  ?></p>
                                        <p class="card-text"><strong>Prix : </strong><?php echo htmlspecialchars($prod_fil[3]);  ?> <strong>FCFA</strong></p>
                                        <div class="favoris">
                                            <a href="../_pages/_DPanier/ajouterPanier.php?id=<?= $prod_fil[0] ?>" class="btn btn-success">Ajouter au panier</a>
                                            <!--<form action="ajouterPanier.php?id=<?= $prod_fil['id'] ?>" method="post">
                                                <button class="btn btn-success">Ajouter au panier</button>
                                            </form>-->
                                            <button class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart fav" id="fav" viewBox="0 0 16 16">
                                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                            </svg>
                                            </button>
                                        </div>    
                                    </div>
                        </div>
                        <!-- Modal pour ce produit -->
                            <div class="modal fade" id="ProductModal<?= $prod_id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?= htmlspecialchars($prod_fil[1]); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="carousel<?= $prod_id ?>" class="carousel slide">
                                                <div class="carousel-inner">
                                                    <?php foreach ($images as $index => $img): ?>
                                                        <div class="w-100 m-auto carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                            <img src="/Parapharmacie_du_congo/<?= $img['image_p']; ?>" class="d-block w-100" alt="Image">
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $prod_id ?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $prod_id ?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>

                                            <p class="mt-3"><?= nl2br(htmlspecialchars($prod_fil[2])); ?></p>
                                            <p><strong>Prix :</strong> <?= htmlspecialchars($prod_fil[3]); ?> FCFA</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="../_pages/_DPanier/ajouterPanier.php?id=<?= $prod_id ?>" class="btn btn-success">Ajouter au panier</a>
                                            <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <!--Modal to show product on big page-->
                            <div class="modal" id="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <h2 class="h2" id="modal-title"></h2>
                                    <img src="" id="modal-image" alt="Image du produit" class="card-img-top image_card img-fluid">
                                    <p id="modal-description" class="desc mt-3"></p>
                                    <p><strong>Prix :</strong><span id="modal-price"></span>FCFA</p>
                                </div>
                            </div>
                        <?php endforeach; ?>                             
                    </div>
                    <div class="pagination justify-content-center pagination-md mb-5">
                        <?php for ($i = 1; $i <= $nbPages; $i++): ?>
                            <?php if ($i == $pageActuelle): ?>
                                <span></span><strong class="page-link active"><?= $i ?></strong>
                            <?php else: ?>
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
        </section>
       
    </main>
    <footer class="py-3">
        <!--Section footer left-->
        <section class="leftFooter">
            <a href="../index.php" class="text-white">Accueil</a>
            <a href="about.php" class="text-white">Qui sommes-nous ?</a>
            <a href="store.php" class="text-white">Boutique</a>
            <a href="contact.php" class="text-white">Contact</a>
        </section>
 
        <section class="adresse">
            <p class="text-white">117 bis rue Lorimier, Brazzaville, Congo</p>
            <p class="text-white">contact@ppc.cg</p>
            <p class="text-white">+242 06 654 76 54</p>
        </section>
        <section class="CenterFooter">
            <div class="rightFooter">
                <!--Facebook RS--> 
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-facebook" viewBox="0 0 16 16">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                </svg>
                <!--Instagram RS--> 
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-instagram" viewBox="0 0 16 16">
                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                </svg>
                <!--Twitter RS--> 
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-twitter-x" viewBox="0 0 16 16">
                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                </svg>
            </div>
            <div class="devweb">
                <p class="text-white">Créé par <a href="https://regip.tech/" target="_blank" class="text-white">regip tech</a>.</p>
                <p class="text-white">© 2025 parapharmacie du congo.</p>
            </div>
        </section>
    </footer>
    
    <!--AJAX Script to show product in big page with pop up-->
    <script>
        function showProduct(id){
            //retrieve data from AJAX
            fetch('get_product.php?id='+id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-title').innerText = data.nom;
                    document.getElementById('modal-image').src = "../Parapharmacie_du_congo/"+data.image;
                    document.getElementById('modal-description').innerText = data.description;
                    document.getElementById('modal-price').innerText = data.prix;
                    //Show popup
                    document.getElementById('modal').style.display="flex";
                });
        }
        function closeModal(){
            document.getElementById('modal').style.display="none";
        }
    </script>
</body>
</html>