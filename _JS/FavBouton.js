fetch('_pages/toggle_fav.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
        product_id: prod_id
    })
})
.then(res => {
    if (res.status === 401) {
        // L'utilisateur n'est pas connecté
        window.location.href = "store.php?error=nouser";
        return;
    }
    return res.json();
})
.then(data => {
    if (data.status === 'added') {
        console.log("Ajouté aux favoris");
        // Change couleur ici
    } else if (data.status === 'removed') {
        console.log("Retiré des favoris");
        // Change couleur ici
    }
});
