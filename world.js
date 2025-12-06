document.addEventListener('DOMContentLoaded', function() {
    // Listen for clicks on the button with id of lookup.
    const lookupButton = document.getElementById('lookup');
    if (lookupButton) {
        lookupButton.addEventListener('click', function(event) {
            event.preventDefault();

            // Get the value from the country search input field
            const countryInput = document.getElementById('country');
            const countryName = countryInput ? countryInput.value.trim() : '';

            // Construct the URL for the AJAX request, passing the country name as a query parameter
            const url = `world.php?country=${encodeURIComponent(countryName)}`;

            // Fetch the data by opening an Ajax connection to fetch data from world.php
            fetch(url)
                .then(response => {
                    // Check if the response status is OK (200)
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    // Extract the response body as text
                    return response.text();
                })
                .then(data => {
                    // Print the data obtained from the AJAX request into the div with id "result".
                    const resultDiv = document.getElementById('result');
                    if (resultDiv) {
                        resultDiv.innerHTML = data;
                    }
                })
                .catch(error => {
                    // Handle errors during the fetch operation
                    console.error('Fetch error:', error);
                    const resultDiv = document.getElementById('result');
                    if (resultDiv) {
                        resultDiv.innerHTML = `<p style="color: red;">Error retrieving country data: ${error.message}</p>`;
                    }
                });
        });
    }
});