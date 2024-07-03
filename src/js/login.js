function login(){
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // AJAX request to login.php
    const xhr = new XMLHttpRequest();
    const url = `${config.apiUrl}/login`;
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        try {
            const response = JSON.parse(xhr.responseText);
            if (xhr.status === 200) {
                alert(response.message);
                if (response.status === 'success') {
                    // Redirect to another page or perform other actions
                    window.location.href = 'index.php'; // Replace with your desired URL

                    window.location.reload();
                }
            } else {
                alert('Login failed. Please try again.');
            }
        }
        catch (exception) {
            // Assuming the response is HTML, display it in a specific element
            document.getElementById('response-container').innerHTML = xhr.responseText;
        }


    };

    xhr.onerror = function() {
        alert('An error occurred during the request.');
    };

    const formData = `json=true&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`;
    xhr.send(formData); // Send form data
}