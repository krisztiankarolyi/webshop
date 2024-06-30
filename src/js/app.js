function loadPage(page) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../src/parts/'+page + '.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('content').innerHTML = this.responseText;
            //history.pushState(null, '', page);

            if(page === 'products'){
                fetchAndDisplayProducts().then(() => {
                    console.log('Products were loaded');
                });
                const filterBtn = document.getElementById('productFilterBtn');
                if (filterBtn) {
                    // Ha létezik az elem, rendeljük hozzá az eseménykezelőt
                    filterBtn.addEventListener('click', function(event) {
                        const filter = {
                            name: document.getElementById('name').value.trim(),
                            category: document.getElementById('category').value.trim(),
                            min_price: document.getElementById('min_price').value.trim(),
                            spec_key: document.getElementById('spec_key').value.trim(),
                            spec_value: document.getElementById('spec_value').value.trim(),
                            sort: document.getElementById('sort_by').value.trim()
                        };

                        // Hívjuk meg a fetchAndDisplayProducts függvényt a filter objektummal
                        fetchAndDisplayProducts(filter);
                        console.log(filter)
                    });
                }

            }


        }
    };
    xhr.send();
}


async function fetchAndDisplayProducts(filter = {}) {
    try {
        const url = 'http://localhost/webshop/api/products';

        // Szűrő objektum létrehozása a nem üres értékekkel
        const filteredFilter = {};
        for (const key in filter) {
            if (filter[key]) {
                filteredFilter[key] = filter[key];
            }
        }

        // Konvertáljuk a filter objektumot query stringgé
        const queryString = Object.keys(filteredFilter).map(key => key + '=' + encodeURIComponent(filteredFilter[key])).join('&');
        const fullUrl = queryString ? `${url}?${queryString}` : url;

        console.log("URL: --> ", fullUrl);
        const response = await fetch(fullUrl);

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
        let id = product._id.$oid;

        // Sablon másolatának készítése
        const productClone = document.importNode(template.content, true);

        // A másolat elemeinek kitöltése a termék adataival
        const imageElement = productClone.querySelector('img');
        imageElement.src = product.img_url;
        imageElement.style.width = '70%';
        imageElement.classList.add("product-image");

        const titleElement = productClone.querySelector('.title');
        titleElement.textContent = product.name;

        const subtitleElement = productClone.querySelector('.subtitle');
        subtitleElement.textContent = product.category;
        subtitleElement.style.textAlign = 'right'; // Align text to the right

        const descriptionElement = productClone.querySelector('.content p:nth-of-type(1)');
        let desc = `Description: \n${product.description}`;

        // Append specs as <ul> elements
        const specsList = document.createElement('ul');
        for (const [key, value] of Object.entries(product.specs)) {
            const listItem = document.createElement('li');

            // Create a span for the key with a class
            const keyElement = document.createElement('span');
            keyElement.textContent = `${key}:`;
            keyElement.classList.add('spec-key');

            // Create a span for the value
            const valueElement = document.createElement('span');
            valueElement.textContent = ` ${value}`;
            valueElement.classList.add('spec-value');

            // Append both spans to the list item
            listItem.appendChild(keyElement);
            listItem.appendChild(valueElement);

            specsList.appendChild(listItem);
        }

        descriptionElement.textContent = desc;
        descriptionElement.appendChild(specsList);

        const priceElement = productClone.querySelector('.content p:nth-of-type(2)');
        priceElement.textContent = `Price: ${product.price} $`;

        // Rejtett mező beállítása a termék _id-jével
        const hiddenInputElement = productClone.querySelector('.hidden-input');
        hiddenInputElement.value = id; // Termék _id-je

        // A termék elem hozzáadása a listához
        productListElement.appendChild(productClone);
    });
}

