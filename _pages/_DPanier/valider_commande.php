<?php
    session_start();
    require '../../_Bend/_sub_forms/conn_DB.php';
    //Verify if user is connected
    if(!isset($_SESSION['userId'])){
        header("Location: ../_accounts/login.php?error=connectionneed");
        exit();
        //die("Veuillez vous connecter pour passer une commande");
    }
    //Retrieve variables
    $Valid= $_POST['acceptCond'];
    $id_client = $_SESSION['userId'];
    $panier = $_SESSION['panier'];
    $nom_client = $_SESSION['nom'];
    $tel = $_SESSION['telephone'];
    $to = $_SESSION['email'];
    // Check if empty basket
    if(empty($panier)){
        die("Votre panier est vide");
    }
    if($Valid != "accepted"){
        header("Location: ../_DPanier/panier.php?error=nocondition");
        exit();
    }
    /*if(!$isset($Valid)){
        header("Location: ../_DPanier/panier.php?error=nocondition");
        exit();
    }*/
    //Create command
    $sql = "INSERT INTO commandes (id_client) VALUES (?)";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("i",$id_client);
    $stmt -> execute();
    $id_commande = $conn ->insert_id;
    $_SESSION['id_commande'] = $id_commande;
    //Add products to command
    $ids = array_keys($panier);
    
    $placeholders = implode(',',array_fill(0,count($ids),'?'));
    $stmt = $conn -> prepare("SELECT id_produit, nom, description_p, prix, categorie FROM produits WHERE id_produit IN ($placeholders)");
    $stmt -> bind_param(str_repeat('i',count($ids)), ...$ids);
    $stmt -> execute();
    $result = $stmt->get_result();
    $produits = $result -> fetch_all(MYSQLI_ASSOC);
    foreach($produits as $produit){
        $produit_id = $produit['id_produit'];
        $prix = $produit['prix'];
        $quantite = $panier[$produit_id];
        $stmt_insert = $conn -> prepare("INSERT INTO commande_produits (id_commande,id_produit,quantite,prix) VALUES (?,?,?,?)");
        $stmt_insert -> bind_param("iiid",$id_commande, $produit_id,$quantite,$prix);
        $stmt_insert -> execute();
    }
    
    //Send an email
    $subject = "PPC - Recaptilatif de votre commande PPC000$id_commande";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@ppc.com" . "\r\n";
    $headers .= "Bcc: messie913@gmail.com" . "\r\n";
    $headers .= "Cc:mbregiscg@gmail.com" . "\r\n";
    $message = '<html><body>';
    $message .= "<h3>Numéro commande PPC000$id_commande sur Parapharmacie du Congo</h3>";
    $message .= "<p>Merci $nom_client pour votre achat sur notre site. Voici le récapitulatif de vos achats. Un membre de notre équipe vous contactera le plus rapidement possible au numéro $tel.</p>";
    $message .= '<table border="1" cellpadding="10" cellspacing="0">';
    $message .= '<thead>
    <tr>
    <th>Article</th>
    <th>Quantité</th>
    <th>Prix</th>
    </tr>
    </thead><tbody>';

    foreach ($produits as $produit) {
        $nom = htmlspecialchars($produit['nom']);
        $quantite = $_SESSION['panier'][$produit['id_produit']];
        $prix = number_format($produit['prix'], 2) . " FCFA";
        $total_produit = $produit['prix'] * $quantite;
        $total += $total_produit;

        $message .= "<tr>
            <td>$nom</td>
            <td>$quantite</td>
            <td>$prix</td>
            
        </tr>";
      
    }

    $message .= '</tbody></table>';
    $message .= '</body></html>';
    $message .= "<h1 class='h4 text-success mt-5'>Total :$total <strong>FCFA</strong></h1>";

    if (mail($to, $subject, $message, $headers)) {
        echo "Email envoyé avec succès.";
    } else {
        echo "Échec de l'envoi de l'email.";
    }

    //Send an email to client
    
    /*$message = "Message de confirmation ";
    $headers = array(
        'From' => 'no-reply@ppc.com',
        'X-Mailer' => 'PHP/' .phpversion()
    );
    mail($to, $subject, $message, $headers);*/
    // Message WhatsApp
    $whatsapp_message = "Bonjour, une nouvelle commande PPC000$id_commande a été passée par $nom_client. Numéro : $tel";
    $encoded_message = urlencode($whatsapp_message);
    $whatsapp_url = "https://wa.me/+15146775478?text=$encoded_message";

    // Redirection vers WhatsApp
    echo "<script>window.open('$whatsapp_url', '_blank');</script>";

    //Empty basket
    unset($_SESSION['panier']);
    $stmt_insert ->close();
    $conn -> close();
    header("Location: ../msg/thankspurchase.php");
    exit();
    
?>
<a href="../_DPanier/panier.php"></a>