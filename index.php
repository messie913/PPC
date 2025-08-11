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
    //code for new products
    require '_Bend/_sub_forms/conn_DB.php';
    $sql = "SELECT id_produit,nom,description_p,prix FROM `produits` ORDER BY id_produit DESC LIMIT 4 ";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $res = $stmt -> get_result();
    $produits = $res->fetch_all(MYSQLI_NUM); // ou MYSQLI_ASSOC si tu préfères
    //while($row = $res -> )
    //var_dump($produits);
    /*foreach($produits as $item){
        $produit_id_image = $item[0];
        echo $item[0];
        echo "<br>";
        echo "<br>";
        $sql = "SELECT image_p FROM images_produits WHERE produit_id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i",$item[0]);
        $stmt -> execute();
        $res = $stmt -> get_result();
        //$images = $res -> fetch_assoc();
        //var_dump($images);
        $pics =[];
        if($res){
            $pics = $res -> fetch_all(MYSQLI_ASSOC);
        }
        print_r($pics);
    };*/
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parapharmacie du congo - Accueil</title>
    <!--Style pages-->
    <link rel="stylesheet" href="_styles/style.css">
    <!--Style for index page--> 
    <link rel="stylesheet" href="_styles/index.css">
    <link rel="stylesheet" href="_styles/normalize.css">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="_BS_CSS/css/bootstrap.min.css">
    <!--Bootstrap CSS-->
    <script src="_BS_JS/js/bootstrap.bundle.min.js" defer></script>
    <script src="_JS/favBtn.js" defer></script>
    
    <!--Favicon--> 
    <link rel="icon" type="image/png" href="_favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="_favicon/favicon.svg" />
    <link rel="shortcut icon" href="_favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="_favicon/apple-touch-icon.png" />
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
            .basket{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            .pres{
                width: 50%;
                margin: auto;
            }
            .offerText{
                width: 50%;
            }
            .bestventes{
                animation: bestVentes 2s ease 0s 1 normal forwards ;
            }
            @keyframes bestVentes {
                0% {
                    background-position: center bottom;
                    background-size: 100%;
                }

                100% {
                    background-position: center bottom;
                    background-size: 150%;
                }
            }
            @media screen and (max-width:900px) {
                .pres{
                    width: 100%;
                    text-align: left;
                    margin: auto;
                    text-align: justify;
                }
                .offerText{
                width: 100%;
                padding: 50px;
                }
                
            }
        </style>
        <script>
            const $images = document.querySelectorAll('.revealing-image');

            $images.forEach(($image) => {
                $image.animate(
                    {
                        opacity: [0, 1],
                        clipPath: ['inset(45% 20% 45% 20%)', 'inset(0% 0% 0% 0%)'],
                    },
                    {
                        fill: 'both',
                        timeline: new ViewTimeline({
                            subject: $image,
                        }),
                        rangeStart: 'entry 25%',
                        rangeEnd: 'cover 50%',
                    }
                );
            });
        </script>
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
                <a href="index.php" class="navbar-brand">
                    <img src="_images/Logo_PDC_-re.png" alt="Logo Pharmacie du Congo" class="logo ">
                </a>
                <!--Account menu for mobile-->
                <div class="d-block d-lg-none">
                    <div class="d-inline-flex flex-row-reverse">
                        <a href="_pages/_DPanier/panier.php">
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
                        <li class="nav-item mx-md-2 mx-lg-4">
                            <a href="index.php" class="nav-link active">Accueil</a>
                        </li>
                        <li class="nav-item mx-md-2 mx-lg-4">
                            <a href="_pages/about.php" class="nav-link">À propos</a>
                        </li>
                        <li class="nav-item mx-md-2 mx-lg-4">
                            <a href="_pages/store.php" class="nav-link ">Boutique</a>
                        </li>
                        <li class="nav-item mx-md-2 mx-lg-4">
                            <a href="_pages/contact.php" class="nav-link">Contact</a>
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
                                            <!--Choose wich dash-->
                                            <?php if(isset($_SESSION['userId'])): ?>
                                                <a class="dropdown-item text-success" href="../_pages/_accounts/dashboard.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                    <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                    <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                                </svg>    
                                            Tableau de bord</a>
                                            <?php else: ?>
                                                <?php if(isset($_SESSION['id'])): ?>
                                                    <a class="dropdown-item text-success" href="../_pages/_accounts/adminDash.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                    <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                    <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                                </svg>    
                                            Tableau de bord</a>
                                                <?php endif; ?>
                                            <?php endif;?>
                                        </li>
                                        <li><a class="dropdown-item text-success" href="_pages/_accounts/listCommands.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                                            <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                                        </svg>
                                        Historique des commandes</a></li>
                                    <li><a class="dropdown-item text-success" href="_pages/_accounts/listFavoris.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                        </svg>
                                        Mes favoris</a></li>
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
                                    <a href="_pages/_accounts/login.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                        </svg>
                                    </a>
                                </div>
                            <?php endif; ?>  
                        </div>
                    </ul>
                  
                    <div class="account d-none d-lg-flex">
                        <form action="#" class="d-none d-xxl-flex  formu mx-lg-5" role="search" id="formu">
                            <input type="search" class="form-control me-2" placeholder="Rechercher..." aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button>
                        </form>
                    <!--Verify if user is logged in for computers-->    
                        <?php if(isset($_SESSION['userId']) || isset($_SESSION['id'])): ?>
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
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <!--Choose wich dash-->
                                        <?php if(isset($_SESSION['userId'])): ?>
                                            <a class="dropdown-item text-success" href="_pages/_accounts/dashboard.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                            </svg>    
                                        Tableau de bord</a>
                                        <?php else: ?>
                                            <?php if(isset($_SESSION['id'])): ?>
                                                <a class="dropdown-item text-success" href="_pages/_accounts/adminDash.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                            </svg>    
                                        Tableau de bord</a>
                                            <?php endif; ?>
                                        <?php endif;?>
                                        <!--<a class="dropdown-item text-success" href="_pages/_accounts/dashboard.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                                <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                                <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                            </svg>    
                                        Tableau de bord</a>-->
                                    </li>
                                    <li><a class="dropdown-item text-success" href="_pages/_accounts/listCommands.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                                            <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                                        </svg>
                                        Historique des commandes</a></li>
                                    <li><a class="dropdown-item text-success" href="_pages/_accounts/listFavoris.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                        </svg>
                                        Mes favoris</a></li>
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
                                <a href="_pages/_accounts/login.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                                </a>
                            </div>
                        <?php endif; ?>    
                    </div>    
                </div>
            </div>
        </nav>
    </header>
    <main class="container-fluid">
        <!--Deconection message-->
        <?php
            if(isset($_GET["error"])){
                if($_GET["error"] == "disconnected"){
                    echo '<p class="error text-center">Votre session est désormais fermés<p>';
                    echo "
                    <script>
                        //Rafraichir page et nettoyer URL
                        setTimeout( function(){
                        //Nettoyer URL sans recharger la page
                        window.history.replaceState(null,null,window.location.pathname);
                        //Rafraichir la page apres nettoyage
                        location.reload();   
                        },3000 );
                    </script>";
                }
                if($_GET["error"] == "logoutinactive"){
                    echo '<p class="error text-center">Votre session a été fermé par manque d\'activité! <p>';
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
        
        <!--banner section-->
        <section class="banner mb-lg-4">
            <div class="textbanner">
                <h1 class="h1 text-white">Votre bien être, notre priorité !</h1>
                <a href="_pages/store.php" class="btn btn-lg btn-primary">Découvrir</a>
            </div>
        </section>
        <!--Welcome-->
        <section class="welcome">
            <h1 class="display-5 text-success text-center mt-3 mb-2">Bienvenue à la Parapharmacie du Congo</h1>
            <p class="text-center pb-3">Découvrez notre large gamme de produits de parapharmacie de qualité supérieure, livrés directement chez vous. 
                Profitez d'une expérience d'achat en ligne pratique et sécurisée!</p>
        </section>

        <!--NEW SECTION VENTES-->
        <section class="bestventes">
            <h1 class="display-5 py-3 text-success text-center">Nouveautés du moment</h1>
            <p class="text-center pb-3">Offrez à votre santé ce qu'il y'a de plus récent : soins, compléments et cosmétiques 
                sélectionnés avec expertise!
            </p>
            <div class="containerProd bg-light mb-5 revealing-image" id="revealing-image">
                <?php foreach($produits as $produit): ?>
                            <?php
                                $prod_id = $produit[0];
                                $sql = "SELECT image_p FROM images_produits WHERE produit_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $prod_id);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $images = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
                            ?>

                            <div class="product border card">
                                <!-- Image principale + bouton -->
                                <?php if (!empty($images)): ?>
                                    <img onclick="showProduct(<?= $prod_id ?>)" data-bs-toggle="modal" data-bs-target="#ProductModal<?= $prod_id ?>" src="/Parapharmacie_du_congo/<?= $images[0]['image_p']; ?>" alt="Image principale" class="card-img-top w-100 image_card revealing-image">
                                <?php else: ?>
                                    <img src="/Parapharmacie_du_congo/default.jpg" alt="Image manquante" class="card-img-top image_card">
                                <?php endif; ?>

                                <!-- Détails -->
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($produit[1]); ?> <span class="badge rounded-pill text-bg-danger">Nouveauté</span></h5></h5>
                                    <button class="btn btn-outline-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#ProductModal<?= $prod_id ?>">
                                        + Détails sur ce produit
                                    </button>
                                    <p class="card-text desc"><?php echo nl2br(htmlspecialchars($produit[2]));  ?></p>
                                    <p class="card-text"><strong>Prix : </strong><?php echo htmlspecialchars($produit[3]);  ?> <strong>FCFA</strong></p>
                                    <div class="favoris">
                                            <a href="../_pages/_DPanier/ajouterPanier.php?id=<?= $produit[0] ?>" class="btn btn-success">Ajouter au panier</a>
                                            <!--<form action="ajouterPanier.php?id=<?= $produit['id'] ?>" method="post">
                                                <button class="btn btn-success">Ajouter au panier</button>
                                            </form>-->
                                            <!--<button class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart fav" id="fav" viewBox="0 0 16 16">
                                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                            </svg>
                                            </button>-->
                                            <button 
                                                class="btn favorite-btn favBtn" 
                                                data-product-id="<?= $prod_id; ?>" 
                                                style=" color: <?= $favorite ? 'red' : 'gray' ?>;"
                                            >
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
                                            <h5 class="modal-title"><?= htmlspecialchars($produit[1]); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="carousel<?= $prod_id ?>" class="carousel slide">
                                                <div class="carousel-inner">
                                                    <?php foreach ($images as $index => $img): ?>
                                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
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

                                            <p class="mt-3"><?= nl2br(htmlspecialchars($produit[2])); ?></p>
                                            <p><strong>Prix :</strong> <?= htmlspecialchars($produit[3]); ?> FCFA</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="../_pages/_DPanier/ajouterPanier.php?id=<?= $prod_id ?>" class="btn btn-success">Ajouter au panier</a>
                                            <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php endforeach; ?>
            </div>
        </section>

       


        <!--Section Temognage-->
        <section class="temoignage my-5">
        <!--Slide for temoignage section-->
            <div id="carouselTemoignage" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active px-lg-5">
                        <h3 class="h4">⭐⭐⭐⭐⭐</h3>
                        <h3 class="h4 text-center text-white px-lg-5">“Très satisfaite de ma commande ! La crème que j’ai achetée fonctionne à merveille, et le personnel est toujours disponible pour conseiller. Merci à Parapharmacie du Congo ”</h3>
                        <h2 class="h5 text-center text-white">[Sylvie Batsimba]</h2>
                    </div>
                    <div class="carousel-item px-lg-5 text-white">
                        <h3 class="h4">⭐⭐⭐⭐</h3>
                        <h3 class="h4 text-center text-white px-lg-5">“J'ai été impressionné par la rapidité de livraison et la qualité des produits. Je recommande vivement Parapharmacie du Congo à mes amis et ma famille.”</h3>
                        <h2 class="h5 text-center">[Albert Nkonkolo]</h2>
                    </div>
                    <div class="carousel-item px-lg-5 text-white">
                        <h3 class="h4">⭐⭐⭐⭐⭐</h3>
                        <h3 class="h4 text-center px-lg-5 ">“J’ai apprécié la diversité des produits proposés, notamment les soins naturels. Le site est clair, facile à utiliser, et les prix sont abordables.”</h3>
                        <h2 class="h5 text-center">[Bob Bidié]</h2>
                    </div>
                    <div class="carousel-item px-lg-5 text-white">
                        <h3 class="h4">⭐⭐⭐⭐⭐</h3>
                        <h3 class="h4 text-center px-lg-5 ">“J'encourage mon entourage à faire affaire avec la plateforme innovante de Parapharmacie du Congo. Les produits sont de bonne qualité et trés abordables.”</h3>
                        <h2 class="h5 text-center">[Alfred Koumbemba]</h2>
                    </div>
                    <div class="carousel-item px-lg-5 text-white">
                        <h3 class="h4">⭐⭐⭐⭐⭐</h3>
                        <h3 class="h4 text-center px-lg-5 ">“Commande reçue en 48h, avec un petit échantillon gratuit en bonus ! Ça fait plaisir de voir un service aussi pro ici au Congo. Je passerai une nouvelle commande bientôt”</h3>
                        <h2 class="h5 text-center">[Sandra Elombe]</h2>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselTemoignage" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselTemoignage" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <!--Section offres--> 
        <section class="d-flex flex-column flex-lg-row align-items-center px-lg-5 my-lg-5">
            <div class="offerText py-lg-5 pres">
                <h1 class="h3">Offre spéciale!</h1>
                <p>Profitez de nos promotions exclusives sur une sélection de produits de parapharmacie. Faites-vous plaisir et prenez soin de vous!</p>
                <a href="_pages/store.php" class="btn btn-success">Découvrir</a>
            </div>
            <div class="offerImg">
                    <img src="_images/img_offre.webp" alt="" class="img-fluid">
            </div>
        </section>
        <!--Section Qui sommes nous--> 
        <section class="whoIam text-center">
            <h1 class="display-5 text-center text-success py-3">
                Qui sommes-nous ? 
            </h1>
            <p class=" py-lg-3 mb-1 pres">
                La parapharmacie du Congo est une entreprise spécialisée dans la vente de produits de parapharmacie en ligne. Notre mission est d'offrir des produits de qualité à des prix compétitifs, tout en garantissant un service client exceptionnel.
            </p>
            <a href="_pages/about.php" class="btn btn-success text-center mb-5">En savoir plus</a>
        </section>
    </main>
    <footer class="py-3">
        <!--Section footer left-->
        <section class="leftFooter">
            <a href="index.php" class="text-white">Accueil</a>
            <a href="_pages/about.php" class="text-white">Qui sommes-nous ?</a>
            <a href="_pages/store.php" class="text-white">Boutique</a>
            <a href="_pages/contact.php" class="text-white">Contact</a>
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
            fetch('_Bend/_sub_forms/get_product.php?id='+id)
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