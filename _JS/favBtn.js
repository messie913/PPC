$('.favorite-btn').on('click', function() {
    let button = $(this); // Le bouton cliqué
    let prod_id = button.data('product-id'); // ID du produit

    $.ajax({
        url: 'toggle_favorite.php', // Script serveur
        type: 'POST',
        data: { product_id: prod_id },
        success: function(response) {
            // Réponse du serveur : "added" ou "removed"
            if (response === 'added') {
                button.css('color', 'red');
            } else if (response === 'removed') {
                button.css('color', 'gray');
            }
        }
    });
});
