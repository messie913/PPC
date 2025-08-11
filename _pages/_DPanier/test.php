<?php
   include '../../_pages/_accounts/paginationProduit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../_styles/style.css">
    <title>Document</title>
    <!--Style pages-->
    <link rel="stylesheet" href="../../_styles/style.css">
    <!--Style for index page--> 
    <link rel="stylesheet" href="../_styles/index.css">
    <link rel="stylesheet" href="../../_styles/normalize.css">
    <!--<link rel="stylesheet" href="../_styles/store.css">-->
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="../_BS_CSS/css/bootstrap.min.css">
    <!--Bootstrap CSS-->
    <script src="../_BS_JS/js/bootstrap.bundle.min.js" defer></script>
     <!--Favicon--> 
     <link rel="icon" type="image/png" href="../_favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../_favicon/favicon.svg" />
    <link rel="shortcut icon" href="../_favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../_favicon/apple-touch-icon.png" />
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
            .modale{
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
            .modale-content {
                background: white;
                padding: 20px;
                border-radius: 10px;
                width: 70%;
                max-width: 100%;               
                position: relative;
               align-items: center;
            }

            .modale-content img {
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
                .modale-content img {
                    width: 80%;
                    height: 100px;
                    height: auto;
                    border-radius: 10px;
                }
                .modale{
                    top: -100px;
                }
                .modale-content {
                    
                    width: 80%;
                }
            }
        </style>
</head>
<body>
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
                    <img onclick="showProduct(<?= $prod_id ?>)" data-bs-toggle="modal" data-bs-target="#ProductModal<?= $prod_id ?>" src="/Parapharmacie_du_congo/<?= $images[0]['image_p']; ?>" alt="Image principale" class="card-img-top image_card">
                <?php else: ?>
                    <img src="/Parapharmacie_du_congo/default.jpg" alt="Image manquante" class="card-img-top image_card">
                <?php endif; ?>

                <!-- Détails -->
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($produit[1]); ?></h5>
                    <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#ProductModal<?= $prod_id ?>">
                        + Détails sur ce produit
                    </button>
                    <p class="card-text desc"><?php echo nl2br(htmlspecialchars($produit[2]));  ?></p>
                    <p class="card-text"><strong>Prix : </strong><?php echo htmlspecialchars($produit[3]);  ?> <strong>FCFA</strong></p>
                        <div class="favoris">
                            <a href="../_pages/_DPanier/ajouterPanier.php?id=<?= $produit[0] ?>" class="btn btn-success">Ajouter au panier</a>
                            <!--<form action="ajouterPanier.php?id=<?= $produit['id'] ?>" method="post">
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
                            <button class="btn btn-success" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>



        <!--Page store-->
          <!--Ajout dynamique-->              
          <?php foreach($produits as $produit): ?>
                        <div class="product border card" >
                                    <?php
                                        include '../_Bend/_sub_forms/conn_DB.php';
                                        include '../_Bend/_sub_forms/admin_add_prod.php';
                                        $sql = "SELECT image_p FROM images_produits WHERE produit_id = ?";
                                        $stmt = $conn -> prepare($sql);
                                        $stmt -> bind_param("i",$produit[0]);
                                        $stmt -> execute();
                                        $res = $stmt -> get_result();
                                        //$images = $res -> fetch_assoc();
                                        //var_dump($images);
                                        $images =[];
                                        if($res){
                                            $images = $res -> fetch_all(MYSQLI_ASSOC);
                                        }
                                        //print_r($images);
                                    ?>
                                    <?php if(!empty($images)): ?>
                                        <img onclick="showProduct(<?php echo $produit[0]; ?>)" data-bs-toggle="modal" data-bs-target="#ProductModal" src="/Parapharmacie_du_congo/<?php echo $images[0]['image_p']; ?>" alt="Image principale" class="card-img-top image_card">
                                    <?php else: ?>
                                        <img src="/Parapharmacie_du_congo/1743777256_still-life-skincare-products-min.jpg" alt="Parfum PDC" class="card-img-top image_card">
                                    <?php endif; ?>
                                    <!--<img src="../_images/free-photo-beauty-product-bottle-mockup-image-with-background.jpg" alt="Parfum PDC" class="card-img-top image_card">-->
                                    <div class="card-body">
                                        <h5 class="h5 card-title"><?php echo htmlspecialchars($produit[1]); ?></h5>
                                        <!-- Button trigger modal -->
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-between ">
                                            <button type="button" class="btn btn-outline-success btn-sm mt-2 mb-4" data-bs-toggle="modal" data-bs-target="#ProductModal" onclick="showProduct(<?php echo $produit[0]; ?>)">
                                                + Détails sur ce produit
                                            </button>
                                        </div>
                                        <p class="card-text desc"><?php echo nl2br(htmlspecialchars($produit[2]));  ?></p>                                   
                                        <p class="card-text"><strong>Prix : </strong><?php echo htmlspecialchars($produit[3]);  ?> <strong>FCFA</strong></p>
                                        <div class="favoris">
                                            <a href="../_pages/_DPanier/ajouterPanier.php?id=<?= $produit[0] ?>" class="btn btn-success">Ajouter au panier</a>
                                            <!--<form action="ajouterPanier.php?id=<?= $produit['id'] ?>" method="post">
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
                    <?php endforeach; ?>  
</body>
</html>