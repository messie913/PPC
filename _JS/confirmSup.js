function confirmerSuppression(id){
    if(confirm("La suppression du compte est irreversible! Voulez-vous vraiment supprimer cet utilisateur ?")){
        window.location.href="../../_Bend/_sub_forms/deleteAcc.php?id="+id;
    }
}
