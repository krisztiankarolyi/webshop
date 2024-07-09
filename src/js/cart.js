
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
    cartContainer.innerHTML = ''; // Clear previous content

    cartItems.forEach(function(cartItem) {
        var productId = cartItem.id; // Assuming there's an ID field
        var productName = cartItem.name;
        var productPrice = cartItem.price;
        var productQuantity = cartItem._quantity; // Assuming the correct field name
        var productImgUrl = cartItem.img_url;

        // Create card with Bulma styles
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
                                <p>
                                    Quantity: 
                                    <input type="hidden" class="hidden-input" value="${productId}">
                                    <button class="button is-small quantity-button" data-product-id="${productId}" onclick="addToCart(null, '${productId}',-1)">-</button>
                                    <span class="quantity">${productQuantity}</span>
                                    <button class="button is-small quantity-button" data-product-id="${productId}" onclick="addToCart(null, '${productId}', 1) ">+</button>
                                </p>                         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append the card to the cart container
        cartContainer.innerHTML += productCard;
    });
}


function addToCart(buttonElement = null, id=null,  quantity=1) {
    var productId = 0;

    if(buttonElement != null){
        const productCard = buttonElement.closest('.card');
        const hiddenInput = productCard.querySelector('.hidden-input');
        productId = hiddenInput.value;
    }
    else if (id != null){
        productId = id.trim();
    }

    fetch(`${config.apiUrl}/cart/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${encodeURIComponent(productId)}&quantity=${quantity}`
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            updateCartCount(data.cartCount);
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    fetchCart();
}

function updateCartCount(count) {
    const cartCountElement = document.getElementById('cartTotal');
    cartCountElement.textContent = count;
}
