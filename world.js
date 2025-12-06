document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    const lookupCitiesButton = document.getElementById('lookup-cities');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    function performLookup(lookupType) {
        const countryName = countryInput.value.trim();
        let url = `world.php?country=${encodeURIComponent(countryName)}`;
        
        if (lookupType === 'cities') {
            url += '&lookup=cities';
        }

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = 'An error occurred while fetching data.';
            });
    }

    lookupButton.addEventListener('click', function(event) {
        event.preventDefault();
        performLookup('country');
    });

    if (lookupCitiesButton) {
        lookupCitiesButton.addEventListener('click', function(event) {
            event.preventDefault();
            performLookup('cities');
        });
    }
});