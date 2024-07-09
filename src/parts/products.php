
<h1>PRODUCTS</h1>
<section class="section">
    <div class="container">

        <div class="form-container">
                <div class="columns is-multiline">
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" type="text" id="name" name="name" placeholder="Enter product name">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Category</label>
                            <div class="control">
                                <input class="input" type="text" id="category" name="category" placeholder="Enter category">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Minimum Price</label>
                            <div class="control">
                                <input class="input" type="number" id="min_price" name="min_price" placeholder="Enter minimum price">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Spec Key</label>
                            <div class="control">
                                <input class="input" type="text" id="spec_key" name="spec_key" placeholder="Enter spec key">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Spec Value</label>
                            <div class="control">
                                <input class="input" type="text" id="spec_value" name="spec_value" placeholder="Enter spec value">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Sort By</label>
                            <div class="control">
                                <div class="select">
                                    <select id="sort_by" name="sort_by">
                                        <option value="">Choose...</option>
                                        <option value="price_asc">Price (Low to High)</option>
                                        <option value="price_desc">Price (High to Low)</option>
                                        <option value="name_asc">Name (A to Z)</option>
                                        <option value="name_desc">Name (Z to A)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-primary" id="productFilterBtn">Filter Products</button>
                    </div>
                    <div class="control">
                        <button type="reset" class="button is-light">Clear</button>
                    </div>
                </div>
        </div>

        <div id="productList" class="columns is-multiline">
            <!-- Ide kerülnek majd dinamikusan a termékek -->
        </div>
    </div>
</section>

<template id="productTemplate">
    <div class="column is-one-third">
        <div class="card has-background-dark has-text-light">
            <div class="card-image">
                <figure class="image is-4by3">
                    <img src="" alt="Product Image">
                </figure>
            </div>
            <div class="card-content ">
                <input type="hidden" class="hidden-input">
                <p class="title is-4 has-text-info"></p>
                <p class="subtitle is-6"></p>
                <div class="content">
                    <p><strong>Description:</strong> </p>
                    <p class="has-text-success"><strong>Price:</strong>  </p>
                </div>
            </div>
            <div class="card-footer has-background-dark">
                <button class="button has-background-info-50 add-to-cart" onclick="addToCart(this)">Add to cart</button>
             </div>
        </div>
    </div>
</template>

