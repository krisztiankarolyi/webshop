const config = (function() {
    const environments = {
        development: {
            apiUrl: "http://localhost/webshop/api",
        },
        production: {
            apiUrl: "https://students.csik.sapientia.ro/~gi2021kak/webshop/api",
        },
    };

    // Környezet meghatározása. Ezt beállíthatod a böngésző konzoljában vagy más módon.
    const ENV = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1'
        ? 'development'
        : 'production';

    return environments[ENV];
})();