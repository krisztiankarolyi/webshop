
// Példa használat (gombra kattintással)
// Függvény a termék hozzáadásához a kosárhoz
function addToCart(buttonElement) {
    const productCard = buttonElement.closest('.card');
    const hiddenInput = productCard.querySelector('.hidden-input');
    const productId = hiddenInput.value;

    fetch('http://localhost/webshop/src/models/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: JSON.stringify({
            action: 'add', // Az "action" paraméter beállítása itt
            product_id: productId,
            quantity: 1 // Például alapértelmezetten 1 darabot adunk a kosárhoz
        }),
    })
        .then(response => response)
        .then(data => {
            console.log(data);
            // Ha szükséges, frissíthetjük a kosár tartalmát vagy egyéb UI módosításokat végezhetünk
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            console.log(productId)
            // Hibakezelés például: hibaüzenet megjelenítése vagy további lépések
        });
}

