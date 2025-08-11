<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation inscription - PPC</title>
     <!--Style pages-->
     <link rel="stylesheet" href="../../_styles/style.css">
    <!--Style for index page--> 
    <link rel="stylesheet" href="../../_styles/contact.css">
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
            .thanksText{
                width: 30%;
                margin: auto;
                margin-top: 30px;
            }
            @media screen and (max-width:990px){
                .thanksText{
                width: 100%;
                margin: auto;
                
                margin-top: 30px;
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
                <div class="d-block d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="35" fill="currentColor" class="bi bi-basket3-fill" viewBox="0 0 16 16">
                        <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.468 15.426.943 9h14.114l-1.525 6.426a.75.75 0 0 1-.729.574H3.197a.75.75 0 0 1-.73-.574z"/>
                    </svg>     
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
                            <a href="../contact.php" class="nav-link active">Contact</a>
                        </li>
                        <!--Login btn for mobile-->
                        <div class="login d-flex gap-5  justify-content-between mt-3">
                            <li class="nav-item mx-md-2 mx-lg-4 mb-3 d-block d-lg-none m-auto">
                                <a href="#" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>Connexion</a>
                            </li>
                            <!--<li class="nav-item mx-md-2 mx-lg-4 d-block d-lg-none justify-content-between">
                                <a href="_pages/about.php" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>Inscription</a>
                            </li>-->
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
                        <div class="basket">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-cart mx-4" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                            <a href="../_accounts/signup.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-person mx-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                            </a>
                        </div>
                    </div>    
                </div>
            </div>
        </nav>
    </header>
    <main>
        <h1 class="display-5 text-success text-center">🎉 Bienvenue chez Parapharmacie du Congo !</h1>
        <section class="thanksText">
            <p class="error">Votre compte a bien été supprimé !</p>
            <p>Créer un nouveau compte : <a href="../../_pages/_accounts/signup.php">S'inscrire</a> </p>
            <p>👉 Commencez votre shopping dès maintenant : <a href="../store.php"> Voir notre boutique</a></p>
            <img src="../../_images/img_offre.webp" alt="Image offre inscription" class="img-fluid mt-3 mb-5">
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
</body>