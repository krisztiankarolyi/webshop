<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    echo <<<EOF
<section class="section">
    <div class="container">
        <h1 class="title has-text-centered">Login</h1>
        <div class="columns is-centered">
            <div class="column is-one-third">
                <div id="loginForm" class="box">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" id="email" name="email" placeholder="Enter your email" required>
                            <input type="hidden" name="json" value="true">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button id="loginBtn" class="button is-link" onclick="login()">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="response-container">

    </div>
</section>
EOF;

}

?>