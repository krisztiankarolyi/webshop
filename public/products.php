
<h1>PRODUCTS</h1>
<button class="button" onclick="fetchAndDisplayProducts()">Load Products</button>
<section class="section">
    <div class="container">
        <div id="productList" class="columns is-multiline">
            <!-- Ide kerülnek majd dinamikusan a termékek -->
        </div>
    </div>
</section>

<template id="productTemplate">
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
                    <p><strong>Price:</strong>  </p>
                </div>
            </div>
        </div>
    </div>
</template>
