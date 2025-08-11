<?php
    ini_set('session.gc_maxlifetime', 900);
    session_start();
    //Logout after 5 minutes
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        // request 15 minates ago
        session_unset();     // unset $_SESSION variable for the runtime
        session_destroy();   // destroy session data completely
        header("Location: ../../index.php?error=logoutinactive");
        exit(); 
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - PPC</title>
     <!--Style pages-->
     <link rel="stylesheet" href="../../_styles/style.css">
    <!--Style for index page--> 
    <link rel="stylesheet" href="../../_styles/contact.css">
    <link rel="stylesheet" href="../../_styles/dashboard.css">
    <link rel="stylesheet" href="../../_styles/normalize.css">
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
    <!--Fonts managment-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Questrial&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!--Custom JS script-->
    <script src="../../_JS/formVerif.js" defer></script> 
    <script src="../../_JS/confirmSup.js" defer></script>   
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
            .formInsc, .txtLogin{
                width: 100%;
                margin: auto;
                
            }
            .txtLogin{
                display: flex;
                flex-direction: row;
                justify-content: center;
                gap: 50px;
                margin: auto;               
            }
            .txtLogin form{
                width: 85%;
            }
            .form-control{
                width: 65%;
            }
            .txtLogin img{
                width: 100%;
                height: auto;
            }
            .imgLogin{
                background: url("../../_images/img_login.jpg") center no-repeat;
                background-size: 100%;
                width: 100%;
                border-radius: 2%;
            }
            .basket{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            @media screen and (max-width:991px) {
                .formInsc, .txtLogin{
                    width: 100%;
                }
                .txtLogin{
                    flex-direction: column;
                }
                .txtLogin form{
                    width: 100%;
                }
                .imgLogin{
                    width: 100%;
                    height: 200px;
                }
                .form-control{
                width: 100%;
                }
            }
            
        </style>
</head>
<body class="container-fluid">
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
                <div class="d-block d-lg-none">
                    <div class="d-inline-flex flex-row-reverse">
                        <a href="../_DPanier/panier.php">
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
                            <a href="../about.php" class="nav-link">À propos</a>
                        </li>
                        <li class="nav-item mx-lg-4">
                            <a href="../store.php" class="nav-link ">Boutique</a>
                        </li>
                        <li class="nav-item mx-lg-4">
                            <a href="../contact.php" class="nav-link">Contact</a>
                        </li>
                         <!--Login btn for mobile-->
                         <div class="d-flex d-lg-none login  gap-5 justify-content-between mt-3">
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
                                            <a class="dropdown-item text-success" href="../_accounts/dashboard.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                    <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                    <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                                </svg>    
                                            Tableau de bord</a>
                                        </li>
                                        <li><a class="dropdown-item text-success" href="listCommands.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                                                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                                                <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                                            </svg>
                                            Historique des commandes</a>
                                        </li>
                                        <li><a class="dropdown-item text-success" href="listFavoris.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                            </svg>
                                            Mes favoris</a>
                                        </li>
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
                                    <a href="../_accounts/login.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                        </svg>
                                    
                                    </a>
                                </div>
                            <?php endif; ?>  
                        </div>
                    </ul>
                    <div class="account d-none d-lg-flex">
                        <form action="#" class="d-none d-xxl-flex  formu mx-lg-5" role="search">
                            <input type="search" class="form-control me-2" placeholder="Rechercher..." aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button>
                        </form>
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
                                            <a class="dropdown-item text-success" href="dashboard.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                    <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                    <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                                </svg>    
                                            Tableau de bord</a>
                                        </li>
                                        <li><a class="dropdown-item text-success" href="listCommands.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                                                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                                                <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                                            </svg>
                                            Historique des commandes</a>
                                        </li>
                                        <li><a class="dropdown-item text-success" href="listFavoris.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                            </svg>
                                            Mes favoris</a>
                                        </li>
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
                        </div>
                    </div>    
                </div>
            </div>
        </nav>
    </header>
    <?php if(isset($_SESSION['userId'])): ?>
        <main class="container-fluid">
            <h1 class="h1 text-success text-center">Bienvenue <?php echo $_SESSION["nom"]?> !</h1>
            <?php
                if(isset($_GET['error'])){
                    if(isset($_GET["error"]) == "accountupdated"){
                        echo '<p class="text-center error">Le compte a bien été mis à jour ! Veuillez vous reconnecter pour terminer la mise à jour.</p>';
                        echo "
                            <script>
                                //Rafraichir page et nettoyer URL
                                setTimeout( function(){
                                //Nettoyer URL sans recharger la page
                                window.history.replaceState(null,null,window.location.pathname);
                                //Rafraichir la page apres nettoyage
                                location.reload();   
                                },15000 );
                            </script>";
                    }
                }
            ?>
            <section class="mainDash">
                <div class="custInfo w-100">
                    <div class="avatar">
                        <img src="../../_images/dashProfile.jpg" alt="Profile" class="img-fluid mb-3">
                        <h1 class="h3 text-success">Mes informations</h1>
                    </div>
                    <form action="" method="post" class="mt-3">
                        <fieldset>
                            <div >
                                <label for="username" class="form-label">Mon nom d'utilisateur :</label>
                                <span class="info"><?php echo $_SESSION["username"]?></span>
                            </div>
                            <div class="mt-3">
                                <label for="name" class="form-label">Mon nom :</label>
                                <span class="info"><?php echo $_SESSION["nom"]?></span>
                            </div>
                            <div class="mt-3">
                                <label for="email" class="fform-label">Mon email :</label>
                                <span class="info"><?php echo $_SESSION["email"]?></span>
                            </div>
                            <div class="mt-3">
                                <label for="telephone" class="form-label">Mon numéro de téléphone :</label>
                                <span class="info"><?php echo $_SESSION["telephone"]?></span>
                            </div>
                        </fieldset>
                    </form>
                    <a href="updateAcc.php" class="btn btn-success mt-4">Modifier mon compte</a><br>
                    <button  class="btn btn-danger mt-4 mb-2" onclick="confirmerSuppression(<?php echo $_SESSION['userId']; ?>)">Supprimer mon compte</button><br>
                    <cite class="cite">* La suppression du compte est irreversible!</cite>
                    <div class="favoris mt-4">
                        <h1 class="h3 text-success text-center">Mes favoris</h1>
                        <p>Liste de mes produits favoris :</p>
                        <?php
                            require '../../_Bend/_sub_forms/conn_DB.php';
                            $id_client = $_SESSION['userId'];
                            $sql = "SELECT favorites.user_id, favorites.produit_id,produits.nom, produits.prix, produits.categorie 
                                    FROM `favorites` 
                                    INNER JOIN produits ON favorites.produit_id = produits.id_produit 
                                    WHERE favorites.user_id = ?
                                    ORDER BY favorites.produit_id DESC
                                    LIMIT 5 ";
                            $stmt = $conn -> prepare($sql);
                            $stmt -> bind_param('i',$id_client);
                            $stmt -> execute();
                            $res = $stmt -> get_result();
                            $favorites = $res -> fetch_all(MYSQLI_ASSOC);
                            //print_r($favorites);
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Nom produit</th>
                                        <th>Prix</th>
                                        <th>Catégorie</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">                               
                                        <?php foreach($favorites as $favorite): ?>
                                            <tr>
                                                <td style="width: 10%;">
                                                    <?php
                                                        $produit_id=$favorite['produit_id'];
                                                        $sql = "SELECT image_p FROM images_produits WHERE produit_id = ?";
                                                        $stmt = $conn -> prepare($sql);
                                                        $stmt -> bind_param('i',$produit_id);
                                                        $stmt -> execute();
                                                        $res = $stmt -> get_result();
                                                        $images = $res -> fetch_all(MYSQLI_NUM);
                                                        //print_r($images);
                                                    ?>
                                                    <?php if(!empty($images)): ?>
                                                        <img src="../../Parapharmacie_du_congo/<?= $images[0][0]; ?>" alt="Image principale" class="img-fluid w-100 cardImages">
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $favorite["nom"]; ?></td>
                                                <td><?= $favorite["prix"]; ?></td>
                                                <td><?= $favorite["categorie"]; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <a href="listFavoris.php" class="text-success">Voir tous mes produits favoris</a>
                    </div>
                </div>
                <div class="figure imgDash border">
                    <!--<img src="../../_images/imgDash.jpg" alt="Image dashboard">-->
                </div>
                <div class="paramDash">
                    <div class="assistance mb-3">
                        <form action="../../_Bend/_sub_forms/submit_formContact.php" method="post">
                            <fieldset class="border p-2">
                                <legend class="float-none w-auto p-2 text-success h5 text-center">Support et assistance</legend>
                                <label for="name">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-telephone-inbound-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zM15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0"/>
                                    </svg>
                                    Assistance : +242 06 654 76 54
                                </label><br><br>
                                <label for="name" class="form-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-file-earmark-person" viewBox="0 0 16 16">
                                    <path d="M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2v9.255S12 12 8 12s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                    Nom :
                                </label>
                                <input type="text" name="name" id="name" class="form-control w-sm-auto w-100 disabled" value="<?php if(isset($_SESSION["nom"])) echo $_SESSION["nom"];?>" required><br>
                                <label for="email" class="form-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-envelope-at-fill" viewBox="0 0 16 16">
                                        <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"/>
                                        <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791"/>
                                    </svg>
                                    Email
                                </label>
                                <input type="email" name="email" id="email" class="form-control w-sm-auto w-100" value="<?php echo $_SESSION["email"]; ?>" required><br>
                                <label for="texte" class="form-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-chat-square-text-fill" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.5a1 1 0 0 0-.8.4l-1.9 2.533a1 1 0 0 1-1.6 0L5.3 12.4a1 1 0 0 0-.8-.4H2a2 2 0 0 1-2-2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
                                    </svg>
                                    Message :
                                </label>
                                <textarea name="texte" id="texte" class="form-control w-sm-auto w-100" required></textarea><br>
                                <button type="submit" name="submit_contact" class="btn btn-success m-auto" style="float: right;">Envoyer</button>
                            </fieldset>
                        </form>
                    </div>
                    <h1 class="h3 text-success text-center">Mes dernieres commandes</h1>
                    <img src="../../_images/command.jpg" alt="Image commande" class="img-fluid mb-2">
                    <?php
                        require '../../_Bend/_sub_forms/conn_DB.php';
                        $id_client = $_SESSION['userId'];
                        $sql = "
                            SELECT produits.nom, produits.prix, commandes.date_commande FROM commande_produits 
                            INNER JOIN commandes ON commandes.id = commande_produits.id_commande 
                            INNER JOIN produits ON commande_produits.id_produit = produits.id_produit 
                            INNER JOIN client ON client.id = commandes.id_client WHERE client.id=?
                            ORDER BY date_commande DESC 
                            LIMIT 5;
                        ";
                        $stmt = $conn -> prepare($sql);
                        $stmt -> bind_param("i",$id_client);
                        $stmt ->execute();
                        $commandes_client =[];
                        $res = $stmt -> get_result();
                        if($res -> num_rows > 0){
                            echo '<table class="table table-striped">';
                            echo '
                                <thead>
                                    <tr>
                                        <th scope="col">Nom produit</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Date commande</th>
                                    </tr>
                                </thead>';
                            echo '<tbody>';
                            while ($row = $res -> fetch_assoc()){
                                echo '<tr>';
                                echo '<td>'. $row['nom']. '</td>';
                                echo '<td>'. $row['prix']. '</td>';
                                echo '<td>'. $row['date_commande']. '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>'; 
                            echo '</table>';
                        }
                        $stmt -> close();
                        $conn -> close();
                        //$commandes_client = $res -> fetch_array(MYSQLI_NUM);
                        //print_r($commandes_client);
                        //echo $id_client;
                        //var_dump($res);
                    ?>
                    <a href="listCommands.php" class="text-success mt-3">Voir mon historique de commande</a>
                </div>
            </section>
        </main>
    <?php else: ?>
        <img src="../../_images/oops_error404.jpg" alt="Erreur 404" class="img-fluid w-100">
        <p class="error text-center">Oops !! vous devez vous logger pour accéder à votre compte.</p>
        <p class="text-center">
                <a href="login.php" class="text-center btn btn-success mb-5">Connexion en tant qu'utilisateur</a>
        </p>
    <?php endif; ?>
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
</body>