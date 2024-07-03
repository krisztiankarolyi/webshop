
// Példa használat (gombra kattintással)
// Függvény a termék hozzáadásához a kosárhoz
function  fetchCart(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', `${config.apiUrl}/cart/getAll`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var cartArray = JSON.parse(xhr.responseText); // JSON tömböt parse-olunk
            displayCart(cartArray);
        }
    };
    xhr.send();
}

function displayCart(cartItems) {
    var cartContainer = document.getElementById('cart-container');
    cartContainer.innerHTML = ''; // Töröljük az előző tartalmat

    cartItems.forEach(function(cartItem) {
        var productName = cartItem.name;
        var productPrice = cartItem.price;
        var productQuantity = cartItem._quantity;
        var productImgUrl = cartItem.img_url;

        // Kártya létrehozása Bulma stílusokkal
        var productCard = `
                    <div class="column is-one-quarter">
                        <div class="product-card">
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="image is-128x128">
                                            <img src="${productImgUrl}" alt="${productName}" class="product-image">
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <h5 class="title is-5">${productName}</h5>
                                        <p>Price: ${productPrice} USD</p>
                                        <p>Quantity: ${productQuantity}</p>
                                        <button class="button is-danger is-small remove-button">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

        // Hozzáadjuk a kártyát a kosár tartalmát tartalmazó elemhez
        cartContainer.innerHTML += productCard;
    });
}


function addToCart(buttonElement) {
    const productCard = buttonElement.closest('.card');
    const hiddenInput = productCard.querySelector('.hidden-input');
    const productId = hiddenInput.value;

    fetch(`${config.apiUrl}/cart/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${encodeURIComponent(productId)}&quantity=1`
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            updateCartCount(data.cartCount);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

function updateCartCount(count) {
    const cartCountElement = document.getElementById('cartTotal');
    cartCountElement.textContent = count;
}
