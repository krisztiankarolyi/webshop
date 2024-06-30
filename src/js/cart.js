
// Példa használat (gombra kattintással)
// Függvény a termék hozzáadásához a kosárhoz
function  fetchCart(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/webshop/api/cart/get', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var cart = JSON.parse(xhr.responseText);
            displayCart(cart);
        } else if (xhr.readyState == 4) {
            document.getElementById('cart-content').innerText = 'Failed to load cart.';
        }
    };
    xhr.send();
}

function displayCart(cart) {
    var cartContent = document.getElementById('cart-content');
    var totalQuantity = 0;
    var cartHtml = '<ul>';

    // Check if the cart is not empty
    if (Object.keys(cart).length > 0) {
        for (var productId in cart) {
            if (cart.hasOwnProperty(productId)) {
                var quantity = cart[productId];
                totalQuantity += parseInt(quantity);
                cartHtml += '<li>Product ID: ' + productId + ', Quantity: ' + quantity + '</li>';
            }
        }
        cartHtml += '</ul>';
        cartHtml += '<p>Total Items: ' + totalQuantity + '</p>';
        cartContent.innerHTML = cartHtml;
    } else {
        cartContent.innerText = 'Your cart is empty.';
    }
}


function addToCart(buttonElement) {
    const productCard = buttonElement.closest('.card');
    const hiddenInput = productCard.querySelector('.hidden-input');
    const productId = hiddenInput.value;
    alert(productId)

    fetch('http://localhost/webshop/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${encodeURIComponent(productId)}&quantity=1`
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

