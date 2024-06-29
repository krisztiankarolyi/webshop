function loadPage(page) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', page + '.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('content').innerHTML = this.responseText;
            //history.pushState(null, '', page);
        }
    };
    xhr.send();
}


document.addEventListener('DOMContentLoaded', () => {
    const template = document.createElement('template');
    template.innerHTML = `
        <div class="column is-one-third">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="" alt="Product Image">
                    </figure>
                </div>
                <div class="card-content">
                    <p class="title is-4"></p>
                    <p class="subtitle is-6"></p>
                    <div class="content">
                        <p><strong>Description:</strong> </p>
                        <p><strong>Price:</strong> </p>
                    </div>
                </div>
            </div>
        </div>
    `;
    template.id = 'productTemplate';
    document.body.appendChild(template);
});

// Fetch API segítségével termékek lekérése
document.addEventListener('DOMContentLoaded', () => {
    fetchAndDisplayProducts();
});

async function fetchAndDisplayProducts() {
    try {
        const response = await fetch('http://localhost/webshop/api/products');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const products = await response.json();
        displayProducts(products);
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

function displayProducts(products) {
    const productListElement = document.getElementById('productList');
    productListElement.innerHTML = ''; // Ürítjük a listát

    // Sablon elem lekérése a DOM-ból
    const template = document.getElementById('productTemplate');

    // Termékek hozzáadása a sablon alapján
    products.forEach(product => {
        // Sablon másolatának készítése
        const productClone = document.importNode(template.content, true);

        // A másolat elemeinek kitöltése a termék adataival
        const imageElement = productClone.querySelector('img');
        imageElement.src = product.img_url;

        const titleElement = productClone.querySelector('.title');
        titleElement.textContent = product.name;

        const subtitleElement = productClone.querySelector('.subtitle');
        subtitleElement.textContent = product.category;

        const descriptionElement = productClone.querySelector('.content p:nth-of-type(1)');
        descriptionElement.textContent = `Description: \n ${product.description}`;

        const priceElement = productClone.querySelector('.content p:nth-of-type(2)');
        priceElement.textContent = `Price: ${product.price} $`;

        // A termék elem hozzáadása a listához
        productListElement.appendChild(productClone);
    });
}
