//world.js

document.getElementById('lookup').addEventListener('click', function () {
    const country = document.getElementById('country').value.trim();
    const url = `world.php?country=${encodeURIComponent(country)}`;
	
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok`);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('result').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('result').innerHTML = `<p style="color: red;">Error fetching data: ${error.message}</p>`;
        });
});
