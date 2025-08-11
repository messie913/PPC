function confirmerSuppression(id){
    if(confirm("Voulez-vous vraiment supprimer ce produit de votre panier ?")){      
        window.location.href="../_pages/_DPanier/supprimerProduit.php?id="+id;
    }
}
